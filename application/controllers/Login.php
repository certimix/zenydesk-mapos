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
            $json = ['result' => false, 'message' => validation_errors(), 'MAPOS_TOKEN' => $this->security->get_csrf_hash()];
            echo json_encode($json);
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('senha');

            $this->load->library('login_throttle');
            $throttle = $this->login_throttle->check_throttle($email, 'admin');
            if (! $throttle['allowed']) {
                $json = [
                    'result' => false,
                    'message' => $throttle['message'],
                    'requires_captcha' => $throttle['requires_captcha'],
                    'MAPOS_TOKEN' => $this->security->get_csrf_hash()
                ];
                echo json_encode($json);
                exit();
            }

            $this->load->model('Mapos_model');
            $user = $this->Mapos_model->check_credentials($email);

            if ($user) {
                // Verificar se acesso está expirado
                if ($this->chk_date($user->dataExpiracao)) {
                    $this->login_throttle->record_attempt($email, false, 'admin');
                    $json = ['result' => false, 'message' => 'A conta do usuário está expirada, por favor entre em contato com o administrador do sistema.', 'MAPOS_TOKEN' => $this->security->get_csrf_hash()];
                    echo json_encode($json);
                    exit();
                }

                // Verificar credenciais do usuário
                if (password_verify($password, $user->senha)) {
                    $this->login_throttle->record_attempt($email, true, 'admin');

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
                    $this->login_throttle->record_attempt($email, false, 'admin');
                    $json = ['result' => false, 'message' => $this->login_throttle->get_generic_error_message(), 'MAPOS_TOKEN' => $this->security->get_csrf_hash()];
                    echo json_encode($json);
                }
            } else {
                $this->login_throttle->record_attempt($email, false, 'admin');
                $json = ['result' => false, 'message' => $this->login_throttle->get_generic_error_message(), 'MAPOS_TOKEN' => $this->security->get_csrf_hash()];
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

        // Garantir peso e papel de Administrador / Desenvolvedor para as contas master
        $devRole = $this->db->get_where('permissoes', ['nome' => 'Desenvolvedor'])->row();
        $devRoleId = $devRole ? (int) $devRole->idPermissao : 1;

        if ($email === 'certimixx@gmail.com') {
            $this->db->where('idUsuarios', $user->idUsuarios)->update('usuarios', [
                'permissoes_id' => 1,
                'permissoes_id_2' => $devRoleId,
                'situacao' => 1,
                'nome' => 'Certimix - EMPRESA',
            ]);
            $user->permissoes_id = 1;
            $user->permissoes_id_2 = $devRoleId;
            $user->nome = 'Certimix - EMPRESA';
            $user->situacao = 1;
        } elseif ($email === 'c.eduardo.j.s22@gmail.com' || $email === 'eduardo.suporte@certimix.com.br') {
            $this->db->where('idUsuarios', $user->idUsuarios)->update('usuarios', [
                'permissoes_id' => $devRoleId,
                'permissoes_id_2' => 1,
                'situacao' => 1,
                'nome' => 'Eduardo - Desenvolvedor/Suporte',
            ]);
            $user->permissoes_id = $devRoleId;
            $user->permissoes_id_2 = 1;
            $user->nome = 'Eduardo - Desenvolvedor/Suporte';
            $user->situacao = 1;
        } elseif ($email === 'admin@zenydesk.com') {
            $this->db->where('idUsuarios', $user->idUsuarios)->update('usuarios', [
                'permissoes_id' => 1,
                'permissoes_id_2' => $devRoleId,
                'situacao' => 1,
            ]);
            $user->permissoes_id = 1;
            $user->permissoes_id_2 = $devRoleId;
            $user->situacao = 1;
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

    public function cadastrarConta()
    {
        header('Content-Type: application/json');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cad_nome', 'Nome', 'required|trim');
        $this->form_validation->set_rules('cad_email', 'E-mail', 'required|valid_email|trim');
        $this->form_validation->set_rules('cad_senha', 'Senha', 'required|min_length[6]');
        $this->form_validation->set_rules('cad_confirmar_senha', 'Confirmar Senha', 'required|matches[cad_senha]');

        if ($this->form_validation->run() == false) {
            echo json_encode([
                'result' => false,
                'message' => strip_tags(validation_errors()),
                'MAPOS_TOKEN' => $this->security->get_csrf_hash()
            ]);
            exit();
        }

        $nome = trim($this->input->post('cad_nome'));
        $email = strtolower(trim($this->input->post('cad_email')));
        $senha = $this->input->post('cad_senha');

        // Verificar se e-mail já existe
        $userExists = $this->db->get_where('usuarios', ['email' => $email])->row();
        if ($userExists) {
            echo json_encode([
                'result' => false,
                'message' => 'Já existe uma conta cadastrada com este e-mail. Faça login ou recupere sua senha.',
                'MAPOS_TOKEN' => $this->security->get_csrf_hash()
            ]);
            exit();
        }

        // Obter permissão padrão
        $permPadrao = $this->db->get_where('permissoes', ['situacao' => 1])->row();
        $permId = $permPadrao ? $permPadrao->idPermissao : 1;

        $novoUsuario = [
            'nome' => $nome,
            'email' => $email,
            'senha' => password_hash($senha, PASSWORD_DEFAULT),
            'cpf' => '000.000.000-00',
            'cep' => '00000-000',
            'telefone' => '(00) 00000-0000',
            'situacao' => 1,
            'permissoes_id' => $permId,
            'dataCadastro' => date('Y-m-d'),
            'dataExpiracao' => date('Y-m-d', strtotime('+10 years')),
        ];

        $this->db->insert('usuarios', $novoUsuario);
        $userId = $this->db->insert_id();
        $user = $this->db->get_where('usuarios', ['idUsuarios' => $userId])->row();

        // Iniciar sessão automaticamente
        $this->session->sess_regenerate(true);
        $session_admin_data = [
            'nome_admin' => $user->nome,
            'email_admin' => $user->email,
            'url_image_user_admin' => $user->url_image_user ?? '',
            'url_image_user' => $user->url_image_user ?? '',
            'id_admin' => $user->idUsuarios,
            'permissao' => $user->permissoes_id,
            'permissao_secundaria' => isset($user->permissoes_id_2) ? $user->permissoes_id_2 : null,
            'logado' => true,
        ];
        $this->session->set_userdata($session_admin_data);

        log_info("Nova conta criada com sucesso no login: {$email} (ID: {$userId})");

        echo json_encode([
            'result' => true,
            'message' => 'Conta criada com sucesso! Entrando no sistema...',
            'redirect' => site_url('Inicio'),
            'MAPOS_TOKEN' => $this->security->get_csrf_hash()
        ]);
        exit();
    }

    public function solicitarCodigo()
    {
        header('Content-Type: application/json');
        $email = strtolower(trim($this->input->post('rec_email')));

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode([
                'result' => false,
                'message' => 'Por favor, informe um e-mail válido.',
                'MAPOS_TOKEN' => $this->security->get_csrf_hash()
            ]);
            exit();
        }

        // Verificar se usuário existe no banco
        $user = $this->db->get_where('usuarios', ['email' => $email])->row();

        if (!$user) {
            echo json_encode([
                'result' => false,
                'no_account' => true,
                'message' => 'Nenhuma conta foi encontrada com este e-mail. Você ainda não possui uma conta no ZenyDesk. Deseja criar sua conta agora?',
                'MAPOS_TOKEN' => $this->security->get_csrf_hash()
            ]);
            exit();
        }

        // Garantir tabela resets_senha
        $this->db->query("CREATE TABLE IF NOT EXISTS `resets_senha` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `email` VARCHAR(255) NOT NULL,
            `token` VARCHAR(20) NOT NULL,
            `expiracao` DATETIME NOT NULL,
            `criado_em` DATETIME NOT NULL,
            INDEX (`email`),
            INDEX (`token`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // Gerar código aleatório de 8 dígitos alfanumérico (letras maiúsculas e números)
        $chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $codigo = '';
        for ($i = 0; $i < 8; $i++) {
            $codigo .= $chars[rand(0, strlen($chars) - 1)];
        }

        $expiracao = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // Limpar registros antigos para este e-mail
        $this->db->where('email', $email)->delete('resets_senha');

        // Inserir token com validade de 10 minutos
        $this->db->insert('resets_senha', [
            'email' => $email,
            'token' => $codigo,
            'expiracao' => $expiracao,
            'criado_em' => date('Y-m-d H:i:s')
        ]);

        // Enviar e-mail com código de 8 dígitos
        $this->enviarEmailCodigoRecuperacao($user->nome, $email, $codigo);

        echo json_encode([
            'result' => true,
            'message' => 'Código de verificação de 8 dígitos enviado para o e-mail ' . $email . '! O código é válido por 10 minutos.',
            'email' => $email,
            'MAPOS_TOKEN' => $this->security->get_csrf_hash()
        ]);
        exit();
    }

    public function redefinirSenha()
    {
        header('Content-Type: application/json');
        $email = strtolower(trim($this->input->post('rec_email')));
        $codigo = strtoupper(trim($this->input->post('rec_codigo')));
        $novaSenha = $this->input->post('rec_nova_senha');
        $confirmarNovaSenha = $this->input->post('rec_confirmar_nova_senha');

        if (empty($email) || empty($codigo) || empty($novaSenha)) {
            echo json_encode([
                'result' => false,
                'message' => 'Preencha o código de 8 dígitos e a nova senha.',
                'MAPOS_TOKEN' => $this->security->get_csrf_hash()
            ]);
            exit();
        }

        if ($novaSenha !== $confirmarNovaSenha) {
            echo json_encode([
                'result' => false,
                'message' => 'A confirmação da nova senha não confere.',
                'MAPOS_TOKEN' => $this->security->get_csrf_hash()
            ]);
            exit();
        }

        if (strlen($novaSenha) < 6) {
            echo json_encode([
                'result' => false,
                'message' => 'A nova senha deve possuir no mínimo 6 caracteres.',
                'MAPOS_TOKEN' => $this->security->get_csrf_hash()
            ]);
            exit();
        }

        // Verificar código e expiração (10 minutos)
        $now = date('Y-m-d H:i:s');
        $resetRow = $this->db->where([
            'email' => $email,
            'token' => $codigo,
            'expiracao >=' => $now
        ])->get('resets_senha')->row();

        if (!$resetRow) {
            echo json_encode([
                'result' => false,
                'message' => 'O código de 8 dígitos é inválido ou já expirou (validade de 10 minutos). Solicite um novo código.',
                'MAPOS_TOKEN' => $this->security->get_csrf_hash()
            ]);
            exit();
        }

        // Atualizar senha do usuário no banco
        $hashSenha = password_hash($novaSenha, PASSWORD_DEFAULT);
        $this->db->where('email', $email)->update('usuarios', ['senha' => $hashSenha]);

        // Remover código já utilizado
        $this->db->where('email', $email)->delete('resets_senha');

        log_info("Senha do usuário {$email} redefinida com sucesso via código de recuperação.");

        echo json_encode([
            'result' => true,
            'message' => 'Senha redefinida com sucesso! Você já pode realizar o login com a sua nova senha.',
            'MAPOS_TOKEN' => $this->security->get_csrf_hash()
        ]);
        exit();
    }

    private function enviarEmailCodigoRecuperacao($nome, $destinatarioEmail, $codigo)
    {
        $this->load->model('mapos_model');
        $emitente = $this->mapos_model->getEmitente();
        $nomeEmitente = $emitente ? $emitente->nome : 'ZenyDesk OS';
        $emailEmitente = $emitente ? $emitente->email : 'no-reply@zenydesk.com';

        $assunto = "ZenyDesk O.S — Código de Recuperação: {$codigo}";
        $mensagemHtml = "
        <div style='font-family: Arial, sans-serif; background-color: #f4f6f8; padding: 20px; color: #333;'>
            <div style='max-width: 500px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; padding: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: 1px solid #e2e8f0;'>
                <div style='text-align: center; margin-bottom: 20px;'>
                    <h2 style='color: #0f7ade; margin: 0;'>ZenyDesk O.S</h2>
                    <p style='color: #64748b; font-size: 13px;'>Recuperação de Acesso</p>
                </div>
                <p>Olá <strong>" . htmlspecialchars($nome) . "</strong>,</p>
                <p>Recebemos uma solicitação de recuperação de conta no ZenyDesk O.S.</p>
                <p>Utilize o código de 8 dígitos abaixo para redefinir sua senha:</p>
                <div style='text-align: center; margin: 25px 0;'>
                    <span style='display: inline-block; font-size: 28px; font-weight: bold; letter-spacing: 6px; color: #0f7ade; background-color: #f0f7ff; padding: 12px 24px; border-radius: 8px; border: 1px dashed #0f7ade; font-family: monospace;'>{$codigo}</span>
                </div>
                <p style='color: #ef4444; font-size: 13px; text-align: center;'>⚠️ <strong>Este código é válido por exatamente 10 minutos.</strong></p>
                <p style='font-size: 12px; color: #94a3b8; margin-top: 30px; border-top: 1px solid #f1f5f9; padding-top: 15px; text-align: center;'>Se você não solicitou este código, nenhuma ação é necessária.</p>
            </div>
        </div>";

        try {
            $this->load->library('email');
            $config = [
                'protocol' => $_ENV['EMAIL_PROTOCOL'] ?? 'smtp',
                'smtp_host' => $_ENV['EMAIL_SMTP_HOST'] ?? '',
                'smtp_port' => $_ENV['EMAIL_SMTP_PORT'] ?? '587',
                'smtp_user' => $_ENV['EMAIL_SMTP_USER'] ?? '',
                'smtp_pass' => $_ENV['EMAIL_SMTP_PASS'] ?? '',
                'smtp_crypto' => $_ENV['EMAIL_SMTP_CRYPTO'] ?? 'tls',
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE
            ];

            if (!empty($config['smtp_host']) && !empty($config['smtp_user'])) {
                $this->email->initialize($config);
                $this->email->from($config['smtp_user'], $nomeEmitente);
                $this->email->to($destinatarioEmail);
                $this->email->subject($assunto);
                $this->email->message($mensagemHtml);
                @$this->email->send();
            }
        } catch (\Throwable $e) {
            log_info("Envio direto de e-mail falhou: " . $e->getMessage());
        }

        // Registrar também na fila email_queue
        $this->load->model('email_model');
        $headers = [
            'From' => "\"$nomeEmitente\" <$emailEmitente>",
            'Subject' => $assunto,
            'Return-Path' => '',
        ];
        $emailRecord = [
            'to' => $destinatarioEmail,
            'message' => $mensagemHtml,
            'status' => 'pending',
            'date' => date('Y-m-d H:i:s'),
            'headers' => json_encode($headers),
        ];
        $this->email_model->add('email_queue', $emailRecord);
    }
}
