<?php
/**
 * Stubs for IDE static analysis and code intelligence (CodeIgniter 3)
 * Este arquivo fornece assinaturas para linters e IDEs quando o framework core não está no vendor local.
 */

if (!function_exists('base_url')) {
    function base_url($uri = '', $protocol = null) { return ''; }
}

if (!function_exists('site_url')) {
    function site_url($uri = '', $protocol = null) { return ''; }
}

if (!function_exists('current_url')) {
    function current_url() { return ''; }
}

if (!function_exists('set_value')) {
    function set_value($field = '', $default = '') { return ''; }
}

if (!function_exists('validation_errors')) {
    function validation_errors($prefix = '', $suffix = '') { return ''; }
}

if (!function_exists('get_instance')) {
    function &get_instance() {
        $instance = null;
        return $instance;
    }
}

if (!function_exists('redirect')) {
    function redirect($uri = '', $method = 'auto', $code = null) {}
}

if (!function_exists('log_info')) {
    function log_info($msg) {}
}
