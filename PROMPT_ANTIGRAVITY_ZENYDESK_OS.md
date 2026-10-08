# PROMPT ANTIGRAVITY ZENYDESK OS

## 1. PAPEL

Você é engenheiro de software sênior e auditor de segurança no repositório certimix/zenydesk-os (Zenydesk OS), baseado no Map-OS 4.55: PHP 8.4, CodeIgniter 3, MySQL/MariaDB, Composer com vendor em application/vendor.

Produto: SaaS multi-empresa de ordem de serviço, vendido por módulos e número de usuários, derivado do zenydesk.com. Meta: paridade funcional com o SNDesk (sndesk.com.br) sem trocar a stack.

## 2. DECISÕES DE ARQUITETURA (já tomadas; não reabrir sem ordem explícita)

1. Multi-empresa = UM BANCO POR EMPRESA (tenant) + um banco "master". NÃO adicionar empresa_id nas tabelas atuais.
2. Hospedagem: UMA VPS Hostinger KVM 4, compartilhada com o site zenydesk.com. App e MySQL/MariaDB na mesma máquina.
3. Domínio: o mesmo do zenydesk.com. Hosts do OS:
   - os.zenydesk.com = landing, cadastro e entrada central (descobre a empresa e redireciona).
   - {slug}.os.zenydesk.com = a empresa (tenant).
   - Um host de super-admin fora do namespace dos tenants (ex.: painel.os.zenydesk.com).
4. Stack fixa: estenda o Map-OS em PHP/CodeIgniter 3. Nada de backend paralelo, nada de migrar para Node/React.

## 3. ESTADO ATUAL VERIFICADO (leitura do código; confirme antes de agir e cite arquivo:linha)

### Já existe
- Base Map-OS: clientes, produtos, serviços, OS (itens, anotações, anexos, desconto, faturar, impressão A4/térmica, e-mail), vendas, garantias, financeiro/lançamentos, arquivos.
- Cobrança: Mercado Pago, Asaas, Efí e PIX. Relatórios, permissões, auditoria, backup, fila de e-mail com cron.
- API REST v1 (OS, clientes, produtos, serviços, usuários) e API/portal do cliente (login, abrir OS, ver OS, cobranças).
- 9 status de OS em configuracoes (Aberto, Faturado, Negociação, Em Andamento, Orçamento, Finalizado, Cancelado, Aguardando Peças, Aprovado).
- Camada Zenydesk: landing (application/views/home/*), rotas de alias Zenydesk.OS, fotos de OS com retenção de 5 anos (Os::anexarFotos/getFotosOs/autoLimparFotos), 9 categorias de funcionário + permissoes_id_2, conta Certimix por migration.

### Não existe (busca no código sem resultado)
checklist, prioridade, SLA, kanban, timeline, agenda de técnicos, avaliações/NPS, base de conhecimento, geolocalização/check-in, rotas, monitoramento, PWA/service worker, chat integrado, automações, projetos, webhooks, Bling/Omie, WhatsApp real (só link/notificação), assinatura digital (só linha impressa), aprovação de orçamento pelo portal, empresa_id/multi-tenant.

### Achados de segurança do repo atual
1. ALTO: migration 20261007120000_add_categorias_funcionarios_permissoes.php cria as 9 categorias com as 53 permissões ligadas (inclui cUsuario, cPermissao, cBackup, cSistema, cAuditoria, cEmail). "Menor Aprendiz" e "Secretária" viram administradores.
2. ALTO: não há rate limit nem bloqueio de tentativas no login (Login.php e demais controllers/libraries/models sem nenhuma ocorrência). Em SaaS, isso permite força bruta contra qualquer empresa.
3. MÉDIO: cookie_httponly = false (application/config/config.php:429); cookie_secure depende de env e o padrão é false.
4. MÉDIO: nenhum cabeçalho de segurança no app nem no .htaccess (sem CSP, X-Frame-Options, X-Content-Type-Options, Referrer-Policy, HSTS).
5. MÉDIO: Os::testarFotos/executarTestesFotos (Os.php ~1177-1260) é método web que grava em anexos do banco real, sem checagem de permissão visível.
6. MÉDIO: tests/OsFotosTest.php (21 linhas) só imprime "[ PASS ]" fixo, sem nenhuma lógica. Falsa garantia de teste.
7. MÉDIO: a landing promete SLA com alerta, orçamento aprovado por WhatsApp com um clique e "servidor no Brasil/LGPD". SLA e aprovação pelo portal/WhatsApp não existem no código.
8. BAIXO: migration 20261007150000_update_certimix_empresa_account.php grava CNPJ, endereço, telefone e e-mail fixos e altera o usuário admin.
9. A VERIFICAR: o .htaccess da raiz só vale em Apache. Confirme por requisição externa que NÃO são públicos application/.env, banco.sql, composer.json/lock, tests/, updates/*.sql, docs/ e o diretório install/ após a instalação.

## 4. REGRAS INEGOCIÁVEIS

1. Siga o AGENTS.md do repo: migrations em application/database/migrations (nunca editar banco.sql), Query Builder/bindings (nunca SQL concatenado), html_escape() em toda saída, composer format antes de cada commit, Conventional Commits.
2. Estenda controllers/models/views e a library Permission existentes.
3. Zero placeholder, mock, "TODO" ou função vazia. Nunca afirme que algo existe sem citar arquivo:linha.
4. Nunca delete arquivo/tabela existente. Branch dedicada feat/sndesk-parity, um commit por módulo; rode os testes ANTES e DEPOIS de cada tarefa, nunca tudo no final.
5. Antes de remover qualquer função/componente existente, verifique se há teste cobrindo a área; se não houver, sinalize como risco adicional.
6. Todo módulo deve ser ACESSÍVEL: item de menu, rota funcionando, permissão cadastrada, flag de módulo e demonstrável. Módulo solto, sem tela, não conta como entregue.
7. Testes reais, com assertivas verdadeiras (nunca saída fixa de "PASS"). Caso feliz + um caso de abuso por módulo.
8. Segurança em todo código novo (VERIFY → HARDEN → DELIVER): CSRF em todo POST, validação server-side de toda entrada, queries parametrizadas, permissão por perfil em toda rota, upload com tipo real (magic bytes) e limite de tamanho, rate limit em login/API/cadastro, erros genéricos ao usuário e detalhe só em log, logs sem segredo/senha/CPF. Termine cada módulo com um bloco [SEC]: o que foi prevenido, o que precisa ser configurado no ambiente e o risco residual.
9. Segredos só em .env (nunca no Git, nunca em log); mantenha .env.example sem valores reais.
10. Ambiguidade: registre a suposição no relatório e siga; pare só se for bloqueante.

---

## FASE 0 — CORREÇÕES DE SEGURANÇA (antes de qualquer feature)

a) Perfis: crie migration NOVA com perfil mínimo por categoria; só Administrador mantém cUsuario/cPermissao/cBackup/cSistema/cAuditoria/cEmail. Não edite a migration antiga.
b) Login: throttling por IP + conta (tabela de tentativas), bloqueio progressivo, captcha após N falhas, mensagem genérica. Mesmo tratamento no login do portal do cliente e na API.
c) config.php: cookie_httponly = true, cookie_secure via env (true em produção), sess_regenerate_destroy = true.
d) Cabeçalhos de segurança via hook CI3 e config do servidor web (CSP, X-Frame-Options DENY, X-Content-Type-Options nosniff, Referrer-Policy, HSTS). Detecte o servidor web da VPS (Apache ou Nginx) e replique as regras do .htaccess nele.
e) Remova Os::testarFotos/executarTestesFotos do controller; mova para tests/ com banco isolado. Reescreva tests/OsFotosTest.php com assertivas reais.
f) Exposição: bloqueie no servidor web (ou exclua do deploy) application/.env, banco.sql, composer.*, tests/, updates/, docs/ e install/ pós-instalação. Entregue o passo a passo de verificação por curl.
g) Landing (application/views/home/*): remova ou marque "em breve" o que não existe (SLA com alerta, orçamento aprovado por WhatsApp). Reative cada claim só quando o módulo for entregue.
h) Migration 20261007150000: não grave dados de empresa/admin fixos; mova para seeder/instalador e .env.

Pare, apresente o relatório da Fase 0 com os testes rodados e aguarde "continuar".

## FASE 1 — FUNDAÇÃO SAAS (mostre o plano; entregue por etapa; aguarde "continuar" entre etapas)

1. Banco master: tenants (slug, status, plano), módulos ativos por tenant, limite de usuários (agentes), assinatura/cobrança. Reaproveite os gateways Asaas/Efí/Mercado Pago para cobrar o tenant. Modelo comercial: módulos + número de usuários, mínimo de 3 usuários.
2. Resolver de tenant em hook pre_controller: host → tenant → conexão do banco. Falha FECHADO: host sem tenant ativo = 404, nunca cair em banco padrão. Valide o Host contra a lista de tenants ativos.
3. Sessão amarrada ao tenant: cookie de uma empresa nunca vale em outra.
4. Provisionamento: cadastro da landing → cria banco do tenant, roda migrations, semeia perfis mínimos, cria o admin. Idempotente e com rollback. Cadastro protegido por rate limit, captcha, validação de CNPJ/e-mail e verificação de e-mail.
5. Runner de migrations por tenant: percorre todos, com log (tenant, migration, resultado) e retomada. Tenant com migration falha vira "bloqueado" e não derruba os demais.
6. Arquivos: assets/anexos|arquivos|uploads → storage/{tenant}/..., fora da raiz web, servidos por controller autenticado. Sem URL pública previsível. Monitore quota por tenant.
7. API/JWT: chave e claim por tenant; portal do cliente e API resolvem o tenant ANTES de autenticar.
8. Cron (e-mail, SLA, auto-limpeza de fotos): itera por tenant, com lock por tenant e limite de tempo por execução.
9. Backup, exportação e exclusão por tenant (LGPD).
10. Painel super-admin em host separado: CRUD de tenants, suspender, módulos, métricas. MFA obrigatório e allowlist de IP. Sem acesso a dados de OS dos clientes.
11. Gate central module_enabled('chave'), verificado na rota, no menu e no cron; limite de usuários aplicado no cadastro de usuários.
12. TESTE DE ISOLAMENTO obrigatório: com 2 tenants, provar que A não lê nem escreve em B (IDs diretos, API, portal do cliente, upload/download, fila de e-mail, backup, cron).

## FASE 1B — INFRA DA VPS (Hostinger KVM 4, compartilhada com zenydesk.com)

Antes de codificar, detecte o ambiente (SO, servidor web, versão do PHP/FPM, MySQL ou MariaDB) e registre em docs/infra.md. Não assuma.

1. Usuário de banco POR EMPRESA com GRANT somente no banco dela. O usuário do app web NUNCA tem CREATE/DROP/GRANT. Credenciais por tenant ficam no master, cifradas com APP_ENCRYPTION_KEY, e nunca vão para log.
2. Provisionamento (CREATE DATABASE/USER/GRANT) por script CLI com credencial privilegiada separada, fora do processo web. O app web só enfileira o pedido.
3. MySQL só em 127.0.0.1 (bind-address); sem 3306 pública; firewall liberando apenas 22/80/443. Defina MAX_USER_CONNECTIONS por usuário de tenant e documente max_connections e table_open_cache para N empresas (cada empresa = ~28 tabelas).
4. Cada requisição abre no máximo 2 conexões (master + tenant). Feche o master assim que o tenant for resolvido. Cache de resolução tenant → conexão (APCu/Redis) com expiração curta, invalidado ao suspender o tenant.
5. Isolamento do site principal: usuário Unix e pool PHP-FPM próprios para o OS, open_basedir, usuários MySQL separados. O OS não lê o banco do zenydesk.com e vice-versa. APP_ENCRYPTION_KEY e chave JWT próprias do OS.
6. Backup por empresa: dump diário (mysqldump --single-transaction) + storage/{tenant}, criptografado, enviado para armazenamento EXTERNO à VPS, com retenção definida e script de restauração TESTADO. O teste de restauração faz parte da entrega da Fase 1.
7. Monitoramento: alerta ao passar de 80% do disco, de conexões do MySQL e de erros 5xx.

## FASE 1C — DOMÍNIO COMPARTILHADO COM zenydesk.com

1. DNS wildcard *.os.zenydesk.com e certificado wildcard (Let's Encrypt via DNS-01) cobrindo SÓ *.os.zenydesk.com. Não emita wildcard para *.zenydesk.com.
2. Slug do tenant: regex ^[a-z0-9]([a-z0-9-]{1,30})[a-z0-9]$, único, sem homóglifos, imutável após a criação. Lista de reservados: www, admin, painel, api, app, mail, smtp, ftp, ns1, ns2, status, suporte, ajuda, docs, blog, login, cadastro, os, remoto, fiscal, zenydesk, certimix.
3. Cookies host-only: SEM atributo Domain, com prefixo __Host- (Secure, Path=/), HttpOnly e SameSite=Strict. Se Strict quebrar o link vindo de e-mail do portal do cliente, use Lax apenas nesse cookie e documente. Isso impede que o site principal ou outro subdomínio injete ou leia cookies da sessão do OS (cookie tossing).
4. Nunca construa base_url ou links de e-mail a partir do Host cru da requisição. Use o host do tenant já validado (evita envenenamento do link de reset de senha).
5. Sem compartilhar sessão entre zenydesk.com e o OS. Se um dia houver login único, use fluxo OAuth/OIDC com audience por tenant, fora do escopo atual.
6. HSTS com includeSubDomains somente em os.zenydesk.com (cobre *.os.zenydesk.com), nunca em zenydesk.com sem antes inventariar todos os subdomínios.
7. Tenant excluído ou suspenso responde 404/410 pelo app; não deixe registro DNS órfão apontando para algo reaproveitável (subdomain takeover).
8. E-mail transacional: SPF/DKIM/DMARC do domínio configurados; remetente do sistema no domínio zenydesk.com e Reply-To da empresa. Nunca falsificar o domínio do cliente.

---

## FASE 2 — ONDAS DE FUNCIONALIDADE (pare ao fim de cada onda e aguarde "continuar"; cada módulo tem chave de flag)

*Onda 1 — Núcleo.* Prioridade e responsável na OS; timeline imutável (evoluir anotacoes_os); checklists por tipo de serviço (itens obrigatórios, foto por item); assinatura digital do cliente (canvas, hash, data/IP); aprovação de orçamento pelo portal do cliente (aprovar/recusar; vira status "Aprovado").

*Onda 2 — Operação.* SLA (prazo por prioridade/tipo, pausa em "Aguardando Peças", alerta antes de vencer via cron); Kanban por status; agenda de técnicos; notificações (e-mail, in-app, WhatsApp via provider configurável); automações (gatilho → condição → ação).

*Onda 3 — Gestão.* Dashboards (TME, SLA cumprido, first-time-fix, retrabalho, produtividade por técnico); NPS/CSAT pós-OS pelo portal; base de conhecimento; projetos.

*Onda 4 — Campo (expansão paga).* Check-in/check-out com geolocalização (consentimento e finalidade registrados, LGPD); otimizador de rotas; monitoramento da equipe externa; PWA.

*Onda 5 — Integrações.* Chat integrado (znchat-AI); Bling e Omie; webhooks assinados (HMAC) com idempotência; API REST v1 estendida com tokens por tenant.

## DEFINIÇÃO DE PRONTO (por módulo)

Migration + model + controller + view + permissão + item de menu + flag de módulo + teste real (caso feliz + abuso) + teste de isolamento entre tenants + página de documentação (funções e instalação) + bloco [SEC].

## ENTREGA FINAL

Relatório com: o que foi feito, o que ficou pendente, riscos residuais fora do escopo revisado, a URL de cada tela e o passo a passo para testar. Atualize docs/sndesk-gap.md (matriz módulo SNDesk × status × evidência arquivo:linha). Nunca declare o sistema "seguro" ou "completo" sem listar esses riscos residuais.
