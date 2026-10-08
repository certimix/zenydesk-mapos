# Matriz de Paridade SNDesk (sndesk.com.br) × ZenyDesk OS

| Módulo / Funcionalidade SNDesk | Status ZenyDesk OS | Evidência (Arquivo:Linha) | Observações |
| :--- | :--- | :--- | :--- |
| **Segurança e Perfis Mínimos** | ✅ Implementado (Fase 0) | `application/database/migrations/20261008100000_harden_categorias_permissoes_minimas.php:1` | Apenas Administrador mantém privilégios `c*`. Demais 8 perfis contidos ao menor privilégio. |
| **Proteção de Força Bruta / Throttling** | ✅ Implementado (Fase 0) | `application/libraries/Login_throttle.php:1`<br>`application/controllers/Login.php:40`<br>`application/controllers/Mine.php:191`<br>`application/controllers/api/v1/UsuariosController.php:260`<br>`application/controllers/api/v1/client/ClientLoginController.php:32` | Throttling por IP + Conta, bloqueio progressivo, mensagens genéricas anti-enumeração. |
| **Cookies e Sessão Segura** | ✅ Implementado (Fase 0) | `application/config/config.php:409`<br>`application/config/config.php:428` | `cookie_httponly = true`, `cookie_secure` resiliente, `sess_regenerate_destroy = true`. |
| **Cabeçalhos HTTP de Segurança** | ✅ Implementado (Fase 0) | `application/hooks/security_headers.php:1`<br>`application/config/hooks.php:33`<br>`.htaccess:1` | CSP, X-Frame-Options DENY, X-Content-Type-Options nosniff, Referrer-Policy, HSTS. |
| **Proteção de Arquivos Sensíveis** | ✅ Implementado (Fase 0) | `.htaccess:2`<br>`docs/infra.md:15` | Bloqueio de `.env`, `banco.sql`, `composer.*`, `tests/`, `install/`. |
| **Testes com Assertivas Reais** | ✅ Implementado (Fase 0) | `tests/OsFotosTest.php:1`<br>`tests/LoginThrottleTest.php:1` | Assertivas verdadeiras em ambiente isolado. Métodos inseguros removidos de `Os.php`. |
| **Remoção de Segredos Fixos em Migrations** | ✅ Implementado (Fase 0) | `application/database/migrations/20261007150000_update_certimix_empresa_account.php:10`<br>`application/database/seeds/EmpresaAccountSeeder.php:1` | Dados agora gerenciados via `.env` e Seeder. |
| **Alinhamento da Landing Page** | ✅ Implementado (Fase 0) | `application/views/home/stats.php:13`<br>`application/views/home/dual-audience.php:15`<br>`application/views/home/faq.php:12` | Recursos futuros marcados como "em breve" ou alinhados ao escopo real entregue. |
| **Fundação Multi-Tenant (Banco por Empresa)** | ⏳ Planejado (Fase 1) | `PROMPT_ANTIGRAVITY_ZENYDESK_OS.md:37` | Banco master + banco por tenant, hook resolver, isolamento de sessão e storage. |
| **Núcleo OS: Prioridade, Responsável, Timeline** | ⏳ Planejado (Fase 2 / Onda 1) | — | Adição de prioridade, técnico responsável, timeline imutável, checklists e assinatura digital. |
| **Formulário Dinâmico / Interativo de OS** | ⏳ Planejado (Fase 2 / Onda 1) | — | Interface inspirada em `sndesk.com.br/cadastros/chamados/novo` (cliente, produto, departamentos, SLA, agenda, anexos). |
| **Operação: SLA, Kanban, Agenda, Automações** | ⏳ Planejado (Fase 2 / Onda 2) | — | Monitoramento de prazos, quadro kanban interativo, agenda e regras de automação. |
| **Gestão: Dashboards, NPS, Base Conhecimento** | ⏳ Planejado (Fase 2 / Onda 3) | — | Métricas de tempo médio de atendimento, satisfação do cliente e base de artigos. |
| **Campo: Check-in Geolocalizado, Rotas, PWA** | ⏳ Planejado (Fase 2 / Onda 4) | — | App móvel PWA com check-in técnico e auditoria LGPD. |
| **Integrações: WhatsApp, Bling, Omie, Webhooks** | ⏳ Planejado (Fase 2 / Onda 5) | — | Envio direto de mensagens, faturamento em ERPs parceiros e webhooks HMAC. |

---

## Riscos Residuais Mapeados (Auditoria Contínua)
1. **Configuração Nginx na VPS**: O arquivo `.htaccess` protege ambientes Apache; na VPS com Nginx, o bloco documentado em `docs/infra.md` deve ser mantido ativo na configuração do Nginx.
2. **Ambiente Multi-Tenant**: O isolamento estrito de um banco de dados por empresa será formalizado e testado na Fase 1.
