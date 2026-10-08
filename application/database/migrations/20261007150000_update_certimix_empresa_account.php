<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_update_certimix_empresa_account extends CI_Migration
{
    public function up()
    {
        // Dados configurados via variaveis de ambiente (.env)
        $nomeEmpresa = $_ENV['APP_DEFAULT_EMITENTE_NOME'] ?? null;
        $cnpjEmpresa = $_ENV['APP_DEFAULT_EMITENTE_CNPJ'] ?? null;
        $emailEmpresa = $_ENV['APP_DEFAULT_EMITENTE_EMAIL'] ?? null;

        if (!empty($nomeEmpresa) && !empty($cnpjEmpresa)) {
            $emitente = $this->db->get('emitente')->row();
            $dataEmitente = [
                'nome' => $nomeEmpresa,
                'cnpj' => $cnpjEmpresa,
                'ie' => $_ENV['APP_DEFAULT_EMITENTE_IE'] ?? 'ISENTO',
                'cep' => $_ENV['APP_DEFAULT_EMITENTE_CEP'] ?? '',
                'logradouro' => $_ENV['APP_DEFAULT_EMITENTE_LOGRADOURO'] ?? '',
                'numero' => $_ENV['APP_DEFAULT_EMITENTE_NUMERO'] ?? '',
                'bairro' => $_ENV['APP_DEFAULT_EMITENTE_BAIRRO'] ?? '',
                'cidade' => $_ENV['APP_DEFAULT_EMITENTE_CIDADE'] ?? '',
                'uf' => $_ENV['APP_DEFAULT_EMITENTE_UF'] ?? '',
                'telefone' => $_ENV['APP_DEFAULT_EMITENTE_TELEFONE'] ?? '',
                'email' => $emailEmpresa ?: 'admin@zenydesk.com',
            ];

            if ($emitente) {
                $this->db->where('id', $emitente->id)->update('emitente', $dataEmitente);
            } else {
                $this->db->insert('emitente', $dataEmitente);
            }

            // Garantir que o usuario administrador inicial mantenha situacao ativa e permissao 1
            $userEmpresa = $this->db->get_where('usuarios', ['cnpj' => $cnpjEmpresa])->row();
            if ($userEmpresa) {
                $this->db->where('idUsuarios', $userEmpresa->idUsuarios)->update('usuarios', [
                    'nome' => $nomeEmpresa,
                    'email' => $emailEmpresa ?: $userEmpresa->email,
                    'permissoes_id' => 1,
                    'situacao' => 1,
                ]);
            }
        }
    }

    public function down()
    {
        // No destruct needed
    }
}
