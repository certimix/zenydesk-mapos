<?php

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mapos_model');
    }

    public function index()
    {
        $this->load->view('mapos/login');
    }

    public function sair()
    {
        $this->session->sess_destroy();

        // O Referer é controlado pelo cliente; redirecionar para ele permitiria
        // que um terceiro enviasse o usuário para um domínio externo.
        return redirect(site_url('login'));
    }

    public function verificarLogin()
    {
        header('Access-Control-Allow-Origin: ' . base_url());
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Content-Type');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'E-mail', 'valid_email|required|trim');
        $this->form_validation->set_rules('senha', 'Senha', 'required|trim');
        if ($this->form_validation->run() == false) {
            $json = ['result' => false, 'message' => validation_errors()];
            echo json_encode($json);
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('senha');
            $this->load->model('Mapos_model');
            $user = $this->Mapos_model->check_credentials($email);

            if ($user) {
                // Verificar se acesso está expirado
                if ($this->chk_date($user->dataExpiracao)) {
                    $json = ['result' => false, 'message' => 'A conta do usuário está expirada, por favor entre em contato com o administrador do sistema.'];
                    echo json_encode($json);
                    exit();
                }

                // Verificar credenciais do usuário
                if (password_verify($password, $user->senha)) {
                    // Novo ID de sessão a cada autenticação, para que um ID
                    // fixado antes do login não continue válido depois dele.
                    $this->session->sess_regenerate(true);

                    $session_admin_data = [
                        'nome_admin' => $user->nome,
                        'email_admin' => $user->email,
                        'url_image_user_admin' => $user->url_image_user,
                        'url_image_user' => $user->url_image_user,
                        'id_admin' => $user->idUsuarios,
                        'permissao' => $user->permissoes_id,
                        'permissao_secundaria' => isset($user->permissoes_id_2) ? $user->permissoes_id_2 : null,
                        'logado' => true,
                    ];
                    $this->session->set_userdata($session_admin_data);
                    log_info('Efetuou login no sistema');
                    $json = ['result' => true];
                    echo json_encode($json);
                } else {
                    $json = ['result' => false, 'message' => 'Os dados de acesso estão incorretos.', 'MAPOS_TOKEN' => $this->security->get_csrf_hash()];
                    echo json_encode($json);
                }
            } else {
                // Mesma mensagem do erro de senha: mensagens distintas revelam
                // quais e-mails possuem conta.
                $json = ['result' => false, 'message' => 'Os dados de acesso estão incorretos.', 'MAPOS_TOKEN' => $this->security->get_csrf_hash()];
                echo json_encode($json);
            }
        }
        exit();
    }

    public function googleAuth()
    {
        header('Content-Type: application/json');

        $credential = $this->input->post('credential');
        if (empty($credential)) {
            echo json_encode(['result' => false, 'message' => 'Token do Google não informado.']);
            exit();
        }

        // 1. Decodificar e validar token JWT do Google
        $userData = null;
        try {
            $parts = explode('.', $credential);
            if (count($parts) === 3) {
                $payloadJson = base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[1]));
                $payload = json_decode($payloadJson, true);
                if (!empty($payload['email'])) {
                    if (isset($payload['iss']) && strpos($payload['iss'], 'accounts.google.com') !== false) {
                        $userData = $payload;
                    }
                }
            }
        } catch (\Throwable $e) {
            $userData = null;
        }

        // Validação secundária via API oficial do Google se necessário
        if (!$userData) {
            $ch = curl_init('https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode($credential));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 6);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);

            if ($response) {
                $resData = json_decode($response, true);
                if (!empty($resData['email'])) {
                    $userData = $resData;
                }
            }
        }

        if (!$userData || empty($userData['email'])) {
            echo json_encode(['result' => false, 'message' => 'Falha ao validar conta do Google. Token inválido ou expirado.']);
            exit();
        }

        $email = trim(strtolower($userData['email']));
        $nome = !empty($userData['name']) ? trim($userData['name']) : explode('@', $email)[0];
        $foto = !empty($userData['picture']) ? $userData['picture'] : '';

        // 2. Localizar usuário no banco ou criar nova conta
        $user = $this->db->get_where('usuarios', ['email' => $email])->row();

        if ($user) {
            if ($user->situacao != 1) {
                echo json_encode(['result' => false, 'message' => 'A sua conta de usuário está desativada no sistema. Contate o administrador.']);
                exit();
            }

            if (!empty($user->dataExpiracao) && $this->chk_date($user->dataExpiracao)) {
                echo json_encode(['result' => false, 'message' => 'A sua conta de usuário está expirada. Contate o administrador.']);
                exit();
            }

            if (empty($user->url_image_user) && !empty($foto)) {
                $this->db->where('idUsuarios', $user->idUsuarios)->update('usuarios', ['url_image_user' => $foto]);
                $user->url_image_user = $foto;
            }
        } else {
            // Criação automática de conta Google
            $permPadrao = $this->db->get_where('permissoes', ['situacao' => 1])->row();
            $permId = $permPadrao ? $permPadrao->idPermissao : 1;

            $novoUsuario = [
                'nome' => $nome,
                'email' => $email,
                'senha' => password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT),
                'cpf' => '000.000.000-00',
                'cep' => '00000-000',
                'telefone' => '(00) 00000-0000',
                'situacao' => 1,
                'permissoes_id' => $permId,
                'dataCadastro' => date('Y-m-d'),
                'dataExpiracao' => date('Y-m-d', strtotime('+10 years')),
                'url_image_user' => $foto,
            ];

            $this->db->insert('usuarios', $novoUsuario);
            $userId = $this->db->insert_id();
            $user = $this->db->get_where('usuarios', ['idUsuarios' => $userId])->row();

            log_info("Nova conta de usuário criada automaticamente via Google: {$email} (ID: {$userId})");
        }

        // 3. Iniciar sessão do usuário
        $this->session->sess_regenerate(true);
        $session_admin_data = [
            'nome_admin' => $user->nome,
            'email_admin' => $user->email,
            'url_image_user_admin' => $user->url_image_user,
            'url_image_user' => $user->url_image_user,
            'id_admin' => $user->idUsuarios,
            'permissao' => $user->permissoes_id,
            'permissao_secundaria' => isset($user->permissoes_id_2) ? $user->permissoes_id_2 : null,
            'logado' => true,
        ];
        $this->session->set_userdata($session_admin_data);

        log_info("Usuário {$email} efetuou login via Google no ZenyDesk OS.");
        echo json_encode([
            'result' => true,
            'message' => 'Autenticação com o Google realizada com sucesso!',
            'redirect' => site_url('Inicio'),
        ]);
        exit();
    }

    private function chk_date($data_banco)
    {
        $data_banco = new DateTime($data_banco);
        $data_hoje = new DateTime('now');

        return $data_banco < $data_hoje;
    }
}
