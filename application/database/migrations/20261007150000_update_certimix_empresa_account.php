<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_update_certimix_empresa_account extends CI_Migration
{
    public function up()
    {
        // 1. Atualizar ou Inserir Emitente Oficial Certimix- EMPRESA
        $emitente = $this->db->get('emitente')->row();
        $dataEmitente = [
            'nome' => 'Certimix- EMPRESA',
            'cnpj' => '35.624.635/0001-44',
            'ie' => 'ISENTO',
            'cep' => '48431-455',
            'logradouro' => 'Rua Professor Jânio',
            'numero' => '9766',
            'bairro' => 'Universitário',
            'cidade' => 'Paripiranga',
            'uf' => 'BA',
            'telefone' => '(75) 99848-1895',
            'email' => 'admin@zenydesk.com',
        ];

        if ($emitente) {
            $this->db->where('id', $emitente->id)->update('emitente', $dataEmitente);
        } else {
            $this->db->insert('emitente', $dataEmitente);
        }

        // 2. Garantir que a conta Certimix- EMPRESA possua privilegios de Super Administrador
        $userEmpresa = $this->db->get_where('usuarios', ['cnpj' => '35.624.635/0001-44'])->row();
        if ($userEmpresa) {
            $this->db->where('idUsuarios', $userEmpresa->idUsuarios)->update('usuarios', [
                'nome' => 'Certimix- EMPRESA',
                'email' => 'admin@zenydesk.com',
                'permissoes_id' => 1,
                'situacao' => 1,
            ]);
        }
    }

    public function down()
    {
        // No destruct needed
    }
}
