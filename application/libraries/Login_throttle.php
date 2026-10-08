<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login_throttle
{
    private $CI;
    private $max_attempts_before_captcha = 3;
    private $max_attempts_before_lockout = 5;
    private $window_seconds = 900; // 15 minutos

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->database();
    }

    public function check_throttle(string $username, string $context = 'admin'): array
    {
        $ip = $this->CI->input->ip_address();
        $since = date('Y-m-d H:i:s', time() - $this->window_seconds);

        // Contagem de falhas recentes por IP
        $this->CI->db->where('ip_address', $ip);
        $this->CI->db->where('attempt_time >=', $since);
        $this->CI->db->where('success', 0);
        $ip_fails = $this->CI->db->count_all_results('login_attempts');

        // Contagem de falhas recentes por Usuário/E-mail
        $user_fails = 0;
        if (!empty($username)) {
            $this->CI->db->where('username', strtolower(trim($username)));
            $this->CI->db->where('attempt_time >=', $since);
            $this->CI->db->where('success', 0);
            $user_fails = $this->CI->db->count_all_results('login_attempts');
        }

        $highest_fails = max($ip_fails, $user_fails);

        if ($highest_fails >= $this->max_attempts_before_lockout) {
            // Busca o timestamp do ultimo erro para calcular tempo restante
            $this->CI->db->select('attempt_time');
            $this->CI->db->group_start();
            $this->CI->db->where('ip_address', $ip);
            if (!empty($username)) {
                $this->CI->or_where('username', strtolower(trim($username)));
            }
            $this->CI->group_end();
            $this->CI->db->where('success', 0);
            $this->CI->db->order_by('attempt_time', 'DESC');
            $this->CI->db->limit(1);
            $last_row = $this->CI->db->get('login_attempts')->row();

            $wait_seconds = 60;
            if ($last_row) {
                $last_time = strtotime($last_row->attempt_time);
                $elapsed = time() - $last_time;
                $lock_duration = ($highest_fails >= 10) ? $this->window_seconds : 60;
                $wait_seconds = max(1, $lock_duration - $elapsed);
            }

            return [
                'allowed' => false,
                'requires_captcha' => true,
                'wait_seconds' => $wait_seconds,
                'fails' => $highest_fails,
                'message' => 'Muitas tentativas sem sucesso. Por motivos de segurança, tente novamente em ' . $wait_seconds . ' segundos.',
            ];
        }

        return [
            'allowed' => true,
            'requires_captcha' => ($highest_fails >= $this->max_attempts_before_captcha),
            'wait_seconds' => 0,
            'fails' => $highest_fails,
            'message' => '',
        ];
    }

    public function record_attempt(string $username, bool $success, string $context = 'admin'): void
    {
        $data = [
            'ip_address' => $this->CI->input->ip_address(),
            'username' => strtolower(trim($username)),
            'context' => $context,
            'attempt_time' => date('Y-m-d H:i:s'),
            'success' => $success ? 1 : 0,
        ];
        $this->CI->db->insert('login_attempts', $data);

        // Se sucesso, limpa registros antigos para nao acumular falso positivo
        if ($success) {
            $this->CI->db->where('username', strtolower(trim($username)));
            $this->CI->db->or_where('ip_address', $this->CI->input->ip_address());
            $this->CI->db->delete('login_attempts');
        }
    }

    public function get_generic_error_message(): string
    {
        return 'Os dados de acesso estão incorretos.';
    }
}
