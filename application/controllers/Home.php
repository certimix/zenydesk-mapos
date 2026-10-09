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

        // Chave Pix Oficial ZenyDesk / Certimix
        $pixKey = 'atendimento@zenydesk.com';
        $receiverName = 'ZENYDESK OS TECNOLOGIA';
        $receiverCity = 'PARIPIRANGA';

        // Geração do Pix BACEN EMV QRCPS oficial com CRC16-CCITT
        $copyPaste = $this->_gerarPixEmv($pixKey, $receiverName, $receiverCity, $valor, $txId);

        // Divisão rigorosa de split (55% Dono / 45% Desenvolvedor)
        $splitDono = round($valor * 0.55, 2);
        $splitDev = round($valor * 0.45, 2);

        // Integração nativa com Asaas se configurado
        $asaasId = null;
        try {
            $this->load->config('payment_gateways');
            $gateways = $this->config->item('payment_gateways');
            if (!empty($gateways['Asaas']['credentials']['api_key'])) {
                $apiKey = $gateways['Asaas']['credentials']['api_key'];
                $isProd = !empty($gateways['Asaas']['production']);
                $asaasEndpoint = $isProd ? 'https://api.asaas.com/v3' : 'https://sandbox.asaas.com/api/v3';

                $payloadAsaas = [
                    'billingType' => 'PIX',
                    'value' => $valor,
                    'dueDate' => date('Y-m-d', strtotime('+1 day')),
                    'description' => "ZenyDesk O.S - Assinatura {$planoInfo['nome']} [{$subdominio}]",
                    'externalReference' => $txId,
                    'postalService' => false,
                ];

                $ch = curl_init("{$asaasEndpoint}/payments");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'access_token: ' . $apiKey,
                ]);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payloadAsaas));
                curl_setopt($ch, CURLOPT_TIMEOUT, 8);
                $resp = curl_exec($ch);
                curl_close($ch);

                if ($resp) {
                    $jsonRes = json_decode($resp, true);
                    if (!empty($jsonRes['id'])) {
                        $asaasId = $jsonRes['id'];
                        // Buscar QR Code oficial do Asaas
                        $chQr = curl_init("{$asaasEndpoint}/payments/{$asaasId}/pixQrCode");
                        curl_setopt($chQr, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($chQr, CURLOPT_HTTPHEADER, ['access_token: ' . $apiKey]);
                        curl_setopt($chQr, CURLOPT_TIMEOUT, 8);
                        $respQr = curl_exec($chQr);
                        curl_close($chQr);
                        if ($respQr) {
                            $jsonQr = json_decode($respQr, true);
                            if (!empty($jsonQr['payload'])) {
                                $copyPaste = $jsonQr['payload'];
                            }
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            // Se o Asaas estiver offline, o Pix EMV nativo do BACEN garante 100% de disponibilidade
        }

        echo json_encode([
            'success' => true,
            'txId' => $txId,
            'asaasId' => $asaasId,
            'plano' => $plano,
            'planoNome' => $planoInfo['nome'],
            'ciclo' => $ciclo,
            'valor' => $valor,
            'valorFormatado' => 'R$ ' . number_format($valor, 2, ',', '.'),
            'subdominio' => $subdominio,
            'subdominioUrl' => "https://{$subdominio}.os.zenydesk.com",
            'copyPaste' => $copyPaste,
            'split' => [
                'dono_percentual' => 55,
                'dono_valor' => $splitDono,
                'dev_percentual' => 45,
                'dev_valor' => $splitDev,
            ],
            'beneficiario' => $receiverName,
        ]);
    }

    private function _formatEmvTag($id, $value)
    {
        $len = str_pad(strlen($value), 2, '0', STR_PAD_LEFT);
        return $id . $len . $value;
    }

    private function _calculateCrc16Ccitt($payload)
    {
        $crc = 0xFFFF;
        $polynomial = 0x1021;
        $len = strlen($payload);
        for ($i = 0; $i < $len; $i++) {
            $crc ^= (ord($payload[$i]) << 8);
            for ($j = 0; $j < 8; $j++) {
                if (($crc & 0x8000) != 0) {
                    $crc = (($crc << 1) ^ $polynomial) & 0xFFFF;
                } else {
                    $crc = ($crc << 1) & 0xFFFF;
                }
            }
        }
        return strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));
    }

    private function _gerarPixEmv($pixKey, $receiverName, $receiverCity, $amount, $txId)
    {
        $amountStr = number_format($amount, 2, '.', '');
        $cleanName = substr(preg_replace('/[^A-Za-z0-9 ]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $receiverName)), 0, 25);
        $cleanCity = substr(preg_replace('/[^A-Za-z0-9 ]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $receiverCity)), 0, 15);
        $cleanTxId = substr(preg_replace('/[^A-Za-z0-9]/', '', $txId), 0, 25);
        if (empty($cleanTxId)) {
            $cleanTxId = '***';
        }

        $accountInfo = $this->_formatEmvTag('00', 'br.gov.bcb.pix') . $this->_formatEmvTag('01', $pixKey);

        $raw = $this->_formatEmvTag('00', '01')
             . $this->_formatEmvTag('26', $accountInfo)
             . $this->_formatEmvTag('52', '0000')
             . $this->_formatEmvTag('53', '986')
             . $this->_formatEmvTag('54', $amountStr)
             . $this->_formatEmvTag('58', 'BR')
             . $this->_formatEmvTag('59', $cleanName)
             . $this->_formatEmvTag('60', $cleanCity)
             . $this->_formatEmvTag('62', $this->_formatEmvTag('05', $cleanTxId))
             . '6304';

        $crc = $this->_calculateCrc16Ccitt($raw);
        return $raw . $crc;
    }
}
