<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Landing page pública do Zenydesk OS.
 *
 * Diferente dos demais controllers (que estendem MY_Controller e exigem
 * login), este é público de propósito: é a porta de entrada do site pra
 * quem ainda não é cliente. Quem já está logado é mandado direto pro
 * painel, pra não ver a landing de novo a cada vez que abre a URL raiz.
 *
 * @property CI_Session $session
 */
class Home extends CI_Controller
{
    public function index()
    {
        if ($this->session->userdata('logado')) {
            redirect('Inicio');
        }

        $data = [
            'page_title' => 'Zenydesk OS — Ordens de serviço & atendimento',
            'page_description' => 'Cadastro de clientes, laudo com foto, orçamento automático via WhatsApp e termo de garantia — parte da plataforma Zenydesk.',
            'login_url' => site_url('login'),
            'signup_url' => site_url('login?action=cadastrar'),
            'whatsapp_url' => 'https://wa.me/5575998626311',
        ];

        $this->load->view('home/header', $data);
        $this->load->view('home/hero', $data);
        $this->load->view('home/stats');
        $this->load->view('home/features', $data);
        $this->load->view('home/dual-audience');
        $this->load->view('home/pricing', $data);
        $this->load->view('home/faq');
        $this->load->view('home/footer', $data);
    }

    /**
     * Checkout público para contratação do ZenyDesk O.S com Split nativo Asaas (55% Dono / 45% Dev)
     * e geração oficial de Pix BACEN EMV QRCPS (QR Code + Copia e Cola).
     */
    public function assinar()
    {
        header('Content-Type: application/json; charset=utf-8');

        $plano = strtolower(trim($this->input->post('plano', true) ?: ''));
        $ciclo = strtolower(trim($this->input->post('ciclo', true) ?: 'mensal'));
        $subdominio = strtolower(trim(preg_replace('/[^a-z0-9-]/i', '', $this->input->post('subdominio', true) ?: '')));
        $nome_empresa = trim($this->input->post('nome_empresa', true) ?: '');
        $responsavel = trim($this->input->post('responsavel', true) ?: '');
        $email = trim($this->input->post('email', true) ?: '');
        $telefone = trim($this->input->post('telefone', true) ?: '');
        $cpf_cnpj = preg_replace('/\D/', '', $this->input->post('cpf_cnpj', true) ?: '');

        if (empty($subdominio) || strlen($subdominio) < 2) {
            echo json_encode(['success' => false, 'error' => 'Informe um subdomínio válido com no mínimo 2 caracteres.']);
            return;
        }

        if (empty($nome_empresa) || empty($responsavel) || empty($email) || empty($cpf_cnpj)) {
            echo json_encode(['success' => false, 'error' => 'Preencha todos os campos obrigatórios (Empresa, Responsável, E-mail e CPF/CNPJ).']);
            return;
        }

        if (strlen($cpf_cnpj) < 11) {
            echo json_encode(['success' => false, 'error' => 'CPF ou CNPJ inválido.']);
            return;
        }

        // Tabela Oficial de Planos ZenyDesk O.S (Modelo SMDesk Adaptado)
        $planosConfig = [
            'basico' => [
                'nome' => 'Básico (até 4 usuários)',
                'mensal' => 247.00,
                'anual' => 2364.00, // R$ 197/mês
                'max_usuarios' => 4,
                'storage_gb' => 3,
            ],
            'profissional' => [
                'nome' => 'Profissional (até 10 usuários)',
                'mensal' => 497.00,
                'anual' => 4764.00, // R$ 397/mês
                'max_usuarios' => 10,
                'storage_gb' => 5,
            ],
            'avancado' => [
                'nome' => 'Avançado (até 25 usuários)',
                'mensal' => 897.00,
                'anual' => 9564.00, // R$ 797/mês
                'max_usuarios' => 25,
                'storage_gb' => 15,
            ],
        ];

        if (!isset($planosConfig[$plano])) {
            echo json_encode(['success' => false, 'error' => 'Plano selecionado inválido. Para Enterprise, entre em contato via WhatsApp comercial.']);
            return;
        }

        $planoInfo = $planosConfig[$plano];
        $valor = $ciclo === 'anual' ? $planoInfo['anual'] : $planoInfo['mensal'];
        $txId = 'zdos' . substr(md5(uniqid(mt_rand(), true)), 0, 16);

        // Divisão rigorosa de split (55% Dono / 45% Desenvolvedor)
        $splitDono = round($valor * 0.55, 2);
        $splitDev = round($valor * 0.45, 2);

        // Carrega credenciais oficiais do Asaas
        $this->load->config('payment_gateways');
        $gateways = $this->config->item('payment_gateways');
        $apiKey = $gateways['Asaas']['credentials']['api_key'] ?? $_ENV['PAYMENT_GATEWAYS_ASAAS_CREDENTIAIS_API_KEY'] ?? '';

        if (empty($apiKey) || strpos($apiKey, 'insira_aqui') !== false || strpos($apiKey, 'sua_chave') !== false) {
            echo json_encode([
                'success' => false,
                'error' => 'A contratação requer a chave da API do Banco Asaas configurada no servidor (Configurações > Pagamentos). Nenhuma chave Pix fictícia é permitida.',
            ]);
            return;
        }

        $isProd = !empty($gateways['Asaas']['production']) || (!empty($_ENV['PAYMENT_GATEWAYS_ASAAS_PRODUCTION']) && filter_var($_ENV['PAYMENT_GATEWAYS_ASAAS_PRODUCTION'], FILTER_VALIDATE_BOOLEAN));
        $asaasEndpoint = $isProd ? 'https://api.asaas.com/v3' : 'https://sandbox.asaas.com/api/v3';

        // 1. Localiza ou cria cliente no Asaas
        $customerId = null;
        $chCustSearch = curl_init("{$asaasEndpoint}/customers?cpfCnpj=" . urlencode($cpf_cnpj));
        curl_setopt($chCustSearch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chCustSearch, CURLOPT_HTTPHEADER, ['access_token: ' . $apiKey]);
        curl_setopt($chCustSearch, CURLOPT_TIMEOUT, 10);
        $respCustSearch = curl_exec($chCustSearch);
        curl_close($chCustSearch);

        if ($respCustSearch) {
            $jsonCustSearch = json_decode($respCustSearch, true);
            if (!empty($jsonCustSearch['data'][0]['id'])) {
                $customerId = $jsonCustSearch['data'][0]['id'];
            }
        }

        if (!$customerId) {
            $payloadCust = [
                'name' => $nome_empresa,
                'email' => $email,
                'cpfCnpj' => $cpf_cnpj,
                'mobilePhone' => preg_replace('/\D/', '', $telefone),
                'notificationDisabled' => false,
            ];
            $chCust = curl_init("{$asaasEndpoint}/customers");
            curl_setopt($chCust, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chCust, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'access_token: ' . $apiKey,
            ]);
            curl_setopt($chCust, CURLOPT_POST, true);
            curl_setopt($chCust, CURLOPT_POSTFIELDS, json_encode($payloadCust));
            curl_setopt($chCust, CURLOPT_TIMEOUT, 10);
            $respCust = curl_exec($chCust);
            curl_close($chCust);

            if ($respCust) {
                $jsonCust = json_decode($respCust, true);
                if (!empty($jsonCust['id'])) {
                    $customerId = $jsonCust['id'];
                } else {
                    $errMsg = $jsonCust['errors'][0]['description'] ?? 'Erro ao cadastrar cliente no Asaas.';
                    echo json_encode(['success' => false, 'error' => $errMsg]);
                    return;
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'Falha na comunicação com os servidores do Asaas.']);
                return;
            }
        }

        // 2. Cria Assinatura no Asaas com Split 55% Dono / 45% Dev
        $ownerWalletId = $_ENV['SPLIT_OWNER_WALLET_ID'] ?? '';
        $devWalletId = $_ENV['SPLIT_DEVELOPER_WALLET_ID'] ?? '';

        $splitArray = [];
        if (!empty($ownerWalletId) && strpos($ownerWalletId, 'placeholder') === false) {
            $splitArray[] = [
                'walletId' => $ownerWalletId,
                'percentualValue' => 55,
            ];
        }
        if (!empty($devWalletId) && strpos($devWalletId, 'placeholder') === false) {
            $splitArray[] = [
                'walletId' => $devWalletId,
                'percentualValue' => 45,
            ];
        }

        $payloadSub = [
            'customer' => $customerId,
            'billingType' => 'PIX',
            'value' => $valor,
            'nextDueDate' => date('Y-m-d'),
            'cycle' => $ciclo === 'anual' ? 'YEARLY' : 'MONTHLY',
            'description' => "Assinatura ZenyDesk O.S - {$planoInfo['nome']} [{$subdominio}]",
            'externalReference' => $txId,
        ];
        if (!empty($splitArray)) {
            $payloadSub['split'] = $splitArray;
        }

        $chSub = curl_init("{$asaasEndpoint}/subscriptions");
        curl_setopt($chSub, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chSub, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'access_token: ' . $apiKey,
        ]);
        curl_setopt($chSub, CURLOPT_POST, true);
        curl_setopt($chSub, CURLOPT_POSTFIELDS, json_encode($payloadSub));
        curl_setopt($chSub, CURLOPT_TIMEOUT, 10);
        $respSub = curl_exec($chSub);
        curl_close($chSub);

        if (!$respSub) {
            echo json_encode(['success' => false, 'error' => 'Falha na criação da assinatura no Asaas.']);
            return;
        }

        $jsonSub = json_decode($respSub, true);
        if (empty($jsonSub['id'])) {
            $errMsg = $jsonSub['errors'][0]['description'] ?? 'Erro ao criar assinatura no Asaas.';
            echo json_encode(['success' => false, 'error' => $errMsg]);
            return;
        }

        $subscriptionId = $jsonSub['id'];

        // 3. Busca a cobrança gerada para a assinatura
        $chPayments = curl_init("{$asaasEndpoint}/subscriptions/{$subscriptionId}/payments");
        curl_setopt($chPayments, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chPayments, CURLOPT_HTTPHEADER, ['access_token: ' . $apiKey]);
        curl_setopt($chPayments, CURLOPT_TIMEOUT, 10);
        $respPayments = curl_exec($chPayments);
        curl_close($chPayments);

        if (!$respPayments) {
            echo json_encode(['success' => false, 'error' => 'Falha ao buscar cobrança da assinatura no Asaas.']);
            return;
        }

        $jsonPayments = json_decode($respPayments, true);
        if (empty($jsonPayments['data'][0]['id'])) {
            echo json_encode(['success' => false, 'error' => 'Cobrança da assinatura não localizada no Asaas.']);
            return;
        }

        $paymentId = $jsonPayments['data'][0]['id'];

        // 4. Busca QR Code Pix Oficial do Asaas
        $chPix = curl_init("{$asaasEndpoint}/payments/{$paymentId}/pixQrCode");
        curl_setopt($chPix, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chPix, CURLOPT_HTTPHEADER, ['access_token: ' . $apiKey]);
        curl_setopt($chPix, CURLOPT_TIMEOUT, 10);
        $respPix = curl_exec($chPix);
        curl_close($chPix);

        if (!$respPix) {
            echo json_encode(['success' => false, 'error' => 'Falha ao buscar QR Code Pix no Asaas.']);
            return;
        }

        $jsonPix = json_decode($respPix, true);
        if (empty($jsonPix['payload'])) {
            echo json_encode(['success' => false, 'error' => 'O Asaas não retornou o payload do Pix. Verifique se o Pix está ativado na conta Asaas.']);
            return;
        }

        $copyPaste = $jsonPix['payload'];
        $encodedImage = $jsonPix['encodedImage'] ?? '';

        echo json_encode([
            'success' => true,
            'txId' => $txId,
            'subscriptionId' => $subscriptionId,
            'paymentId' => $paymentId,
            'plano' => $plano,
            'planoNome' => $planoInfo['nome'],
            'ciclo' => $ciclo,
            'valor' => $valor,
            'valorFormatado' => 'R$ ' . number_format($valor, 2, ',', '.'),
            'subdominio' => $subdominio,
            'subdominioUrl' => "https://{$subdominio}.os.zenydesk.com",
            'copyPaste' => $copyPaste,
            'qrBase64' => $encodedImage ? (strpos($encodedImage, 'data:') === 0 ? $encodedImage : 'data:image/png;base64,' . $encodedImage) : null,
            'split' => [
                'dono_percentual' => 55,
                'dono_valor' => $splitDono,
                'dev_percentual' => 45,
                'dev_valor' => $splitDev,
            ],
            'beneficiario' => 'Asaas Gestão Financeira S.A. (Banco 461) - ZenyDesk',
        ]);
    }
}
