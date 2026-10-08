<?php

defined('BASEPATH') or exit('No direct script access allowed');

class SecurityHeadersHook
{
    public function setHeaders()
    {
        // Envia apenas se cabecalhos ainda nao foram enviados
        if (headers_sent()) {
            return;
        }

        // 1. Prevencao contra Clickjacking
        $frameOptions = $_ENV['APP_X_FRAME_OPTIONS'] ?? 'DENY';
        header("X-Frame-Options: {$frameOptions}");

        // 2. Prevencao contra MIME-sniffing
        header('X-Content-Type-Options: nosniff');

        // 3. Filtro contra XSS
        header('X-XSS-Protection: 1; mode=block');

        // 4. Politica de Referrer
        header('Referrer-Policy: strict-origin-when-cross-origin');

        // 5. Content Security Policy robusta para CodeIgniter + scripts administrativos + Google Sign-In + Boxicons
        $csp = "default-src 'self'; "
            . "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://accounts.google.com https://cdn.jsdelivr.net https://unpkg.com; "
            . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://accounts.google.com https://unpkg.com; "
            . "font-src 'self' data: https://fonts.gstatic.com https://unpkg.com; "
            . "img-src 'self' data: blob: https:; "
            . "frame-src 'self' https://accounts.google.com; "
            . "connect-src 'self' https:; "
            . "frame-ancestors 'none';";
        header("Content-Security-Policy: {$csp}");

        // 6. HSTS (Strict-Transport-Security) em conexoes HTTPS
        $isHttps = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
            || (ENVIRONMENT === 'production');

        if ($isHttps) {
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
        }
    }
}
