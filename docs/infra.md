# Documentação de Infraestrutura e Hardening de Segurança (ZenyDesk OS)

## 1. Topologia de Produção e Ambiente Detectado

* **Servidor**: Hostinger VPS KVM 4 (`179.199.142.52`)
* **Sistema Operacional**: Ubuntu Linux (64-bit)
* **Servidor Web Principal**: Nginx 1.24.0 (Proxy Reverso + FastCGI)
* **Interpretador PHP**: PHP 8.4 (PHP-FPM)
* **Banco de Dados**: MariaDB / MySQL (Bind estrito em `127.0.0.1:3306`, sem exposição pública)
* **Hosts do Sistema**:
  - `os.zenydesk.com`: Landing Page, Portal de Entrada e Cadastro Central
  - `{slug}.os.zenydesk.com`: Tenants / Empresas Isoladas (Banco dedicado por empresa)
  - `painel.os.zenydesk.com`: Super Administrador central

---

## 2. Hardening do Servidor Web (Nginx)

Para garantir que arquivos críticos de configuração, dados e testes não sejam expostos publicamente, a seguinte configuração deve constar no bloco do servidor no Nginx (`/etc/nginx/sites-available/zenydesk-os` ou equivalente):

```nginx
# ==============================================================
# Hardening de Segurança — Bloqueio de Arquivos e Pastas Sensíveis
# ==============================================================

# 1. Bloqueio de arquivos de ambiente, banco e dependências
location ~* (\.env|banco\.sql|composer\.(json|lock)|phpunit\.xml) {
    deny all;
    return 404;
}

# 2. Bloqueio de pastas de infraestrutura, testes e instalação
location ~* ^/(application|\.git|tests|updates|docs|install)/ {
    deny all;
    return 404;
}

# 3. Cabeçalhos HTTP de Segurança
add_header X-Frame-Options "DENY" always;
add_header X-Content-Type-Options "nosniff" always;
add_header X-XSS-Protection "1; mode=block" always;
add_header Referrer-Policy "strict-origin-when-cross-origin" always;
add_header Strict-Transport-Security "max-age=31536000; includeSubDomains; preload" always;
```

---

## 3. Passo a Passo de Verificação por Curl (Auditoria Externa)

Execute os comandos abaixo a partir de qualquer terminal externo para comprovar que as rotas sensíveis estão estritamente bloqueadas:

```bash
# 1. Testar bloqueio de .env (deve retornar 403 Forbidden ou 404 Not Found)
curl -s -I "https://os.zenydesk.com/application/.env" | grep -E "HTTP/|403|404"

# 2. Testar bloqueio de dump de banco (deve retornar 403 ou 404)
curl -s -I "https://os.zenydesk.com/banco.sql" | grep -E "HTTP/|403|404"

# 3. Testar bloqueio de composer.json e lock (deve retornar 403 ou 404)
curl -s -I "https://os.zenydesk.com/composer.json" | grep -E "HTTP/|403|404"
curl -s -I "https://os.zenydesk.com/composer.lock" | grep -E "HTTP/|403|404"

# 4. Testar bloqueio da pasta de instalação pós-deploy (deve retornar 403 ou 404)
curl -s -I "https://os.zenydesk.com/install/" | grep -E "HTTP/|403|404"

# 5. Testar presença dos cabeçalhos de segurança (X-Frame-Options, X-Content-Type-Options, etc)
curl -s -I "https://os.zenydesk.com/" | grep -iE "X-Frame-Options|X-Content-Type-Options|Referrer-Policy|Strict-Transport-Security"
```
