<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_setup_admin_and_developer_accounts extends CI_Migration
{
    private function getAllFullPermissionsSerialized(): string
    {
        $allKeys = [
            'aCliente', 'eCliente', 'dCliente', 'vCliente',
            'aProduto', 'eProduto', 'dProduto', 'vProduto',
            'aServico', 'eServico', 'dServico', 'vServico',
            'aOs', 'eOs', 'dOs', 'vOs',
            'aVenda', 'eVenda', 'dVenda', 'vVenda',
            'aGarantia', 'eGarantia', 'dGarantia', 'vGarantia',
            'aArquivo', 'eArquivo', 'dArquivo', 'vArquivo',
            'aPagamento', 'ePagamento', 'dPagamento', 'vPagamento',
            'aLancamento', 'eLancamento', 'dLancamento', 'vLancamento',
            'cUsuario', 'cEmitente', 'cPermissao', 'cBackup', 'cAuditoria', 'cEmail', 'cSistema',
            'rCliente', 'rProduto', 'rServico', 'rOs', 'rVenda', 'rFinanceiro',
            'aCobranca', 'eCobranca', 'dCobranca', 'vCobranca',
            'vCadastro', 'aCadastro', 'eCadastro', 'dCadastro',
        ];

        $data = [];
        foreach ($allKeys as $k) {
            $data[$k] = '1';
        }

        return serialize($data);
    }

    public function up()
    {
        $fullPerms = $this->getAllFullPermissionsSerialized();
        $validUntil = '2036-12-31';

        // 1. Garantir que o perfil 'Administrador' (idPermissao = 1) possua todas as permissoes ativas
        $adminRole = $this->db->get_where('permissoes', ['idPermissao' => 1])->row();
        if ($adminRole) {
            $this->db->where('idPermissao', 1)->update('permissoes', [
                'permissoes' => $fullPerms,
                'situacao' => 1,
            ]);
        } else {
            $this->db->insert('permissoes', [
                'idPermissao' => 1,
                'nome' => 'Administrador',
                'permissoes' => $fullPerms,
                'situacao' => 1,
                'data' => date('Y-m-d'),
            ]);
        }

        // 2. Garantir o perfil 'Desenvolvedor' com exatamente o mesmo peso de Administrador (100% permissoes)
        $devRole = $this->db->get_where('permissoes', ['nome' => 'Desenvolvedor'])->row();
        if ($devRole) {
            $this->db->where('idPermissao', $devRole->idPermissao)->update('permissoes', [
                'permissoes' => $fullPerms,
                'situacao' => 1,
            ]);
            $devRoleId = (int) $devRole->idPermissao;
        } else {
            $this->db->insert('permissoes', [
                'nome' => 'Desenvolvedor',
                'permissoes' => $fullPerms,
                'situacao' => 1,
                'data' => date('Y-m-d'),
            ]);
            $devRoleId = (int) $this->db->insert_id();
        }

        // 3. Garantir o perfil 'Desenvolvedor/Suporte' (alias) tambem com 100% de permissoes
        $devSuporteRole = $this->db->get_where('permissoes', ['nome' => 'Desenvolvedor/Suporte'])->row();
        if ($devSuporteRole) {
            $this->db->where('idPermissao', $devSuporteRole->idPermissao)->update('permissoes', [
                'permissoes' => $fullPerms,
                'situacao' => 1,
            ]);
        } else {
            $this->db->insert('permissoes', [
                'nome' => 'Desenvolvedor/Suporte',
                'permissoes' => $fullPerms,
                'situacao' => 1,
                'data' => date('Y-m-d'),
            ]);
        }

        // Senha canônica solicitada: Vh8IFSRwSjU2DTPV6jwMGhfRLjqaPhz
        $senhaHash = password_hash('Vh8IFSRwSjU2DTPV6jwMGhfRLjqaPhz', PASSWORD_DEFAULT);

        // 4. Usuario: admin@zenydesk.com (Administrador master)
        $userAdmin = $this->db->get_where('usuarios', ['email' => 'admin@zenydesk.com'])->row();
        if ($userAdmin) {
            $this->db->where('idUsuarios', $userAdmin->idUsuarios)->update('usuarios', [
                'nome' => 'Administrador ZenyDesk',
                'senha' => $senhaHash,
                'permissoes_id' => 1,
                'permissoes_id_2' => $devRoleId,
                'situacao' => 1,
                'dataExpiracao' => $validUntil,
            ]);
        } else {
            $this->db->insert('usuarios', [
                'nome' => 'Administrador ZenyDesk',
                'email' => 'admin@zenydesk.com',
                'senha' => $senhaHash,
                'cpf' => '000.000.000-00',
                'cep' => '00000-000',
                'telefone' => '(00) 00000-0000',
                'situacao' => 1,
                'permissoes_id' => 1,
                'permissoes_id_2' => $devRoleId,
                'dataCadastro' => date('Y-m-d'),
                'dataExpiracao' => $validUntil,
            ]);
        }

        // 5. Usuario: certimixx@gmail.com (Certimix - EMPRESA via Google)
        $userCertimix = $this->db->get_where('usuarios', ['email' => 'certimixx@gmail.com'])->row();
        if ($userCertimix) {
            $this->db->where('idUsuarios', $userCertimix->idUsuarios)->update('usuarios', [
                'nome' => 'Certimix - EMPRESA',
                'senha' => $senhaHash,
                'permissoes_id' => 1,
                'permissoes_id_2' => $devRoleId,
                'situacao' => 1,
                'dataExpiracao' => $validUntil,
            ]);
        } else {
            $this->db->insert('usuarios', [
                'nome' => 'Certimix - EMPRESA',
                'email' => 'certimixx@gmail.com',
                'senha' => $senhaHash,
                'cpf' => '000.000.000-00',
                'cep' => '00000-000',
                'telefone' => '(00) 00000-0000',
                'situacao' => 1,
                'permissoes_id' => 1,
                'permissoes_id_2' => $devRoleId,
                'dataCadastro' => date('Y-m-d'),
                'dataExpiracao' => $validUntil,
            ]);
        }

        // 6. Usuario: Eduardo - Desenvolvedor/Suporte (c.eduardo.j.s22@gmail.com)
        $userEduardo1 = $this->db->get_where('usuarios', ['email' => 'c.eduardo.j.s22@gmail.com'])->row();
        if ($userEduardo1) {
            $this->db->where('idUsuarios', $userEduardo1->idUsuarios)->update('usuarios', [
                'nome' => 'Eduardo - Desenvolvedor/Suporte',
                'senha' => $senhaHash,
                'permissoes_id' => $devRoleId,
                'permissoes_id_2' => 1,
                'situacao' => 1,
                'dataExpiracao' => $validUntil,
            ]);
        } else {
            $this->db->insert('usuarios', [
                'nome' => 'Eduardo - Desenvolvedor/Suporte',
                'email' => 'c.eduardo.j.s22@gmail.com',
                'senha' => $senhaHash,
                'cpf' => '000.000.000-00',
                'cep' => '00000-000',
                'telefone' => '(00) 00000-0000',
                'situacao' => 1,
                'permissoes_id' => $devRoleId,
                'permissoes_id_2' => 1,
                'dataCadastro' => date('Y-m-d'),
                'dataExpiracao' => $validUntil,
            ]);
        }

        // 7. Usuario: Eduardo - Desenvolvedor/Suporte (eduardo.suporte@certimix.com.br)
        $userEduardo2 = $this->db->get_where('usuarios', ['email' => 'eduardo.suporte@certimix.com.br'])->row();
        if ($userEduardo2) {
            $this->db->where('idUsuarios', $userEduardo2->idUsuarios)->update('usuarios', [
                'nome' => 'Eduardo - Desenvolvedor/Suporte',
                'senha' => $senhaHash,
                'permissoes_id' => $devRoleId,
                'permissoes_id_2' => 1,
                'situacao' => 1,
                'dataExpiracao' => $validUntil,
            ]);
        } else {
            $this->db->insert('usuarios', [
                'nome' => 'Eduardo - Desenvolvedor/Suporte',
                'email' => 'eduardo.suporte@certimix.com.br',
                'senha' => $senhaHash,
                'cpf' => '000.000.000-00',
                'cep' => '00000-000',
                'telefone' => '(00) 00000-0000',
                'situacao' => 1,
                'permissoes_id' => $devRoleId,
                'permissoes_id_2' => 1,
                'dataCadastro' => date('Y-m-d'),
                'dataExpiracao' => $validUntil,
            ]);
        }

        // 8. Garantir configuracao de tema ativo para 'zenydeskos'
        $this->db->query("INSERT INTO `configuracoes` (`config`, `valor`) VALUES ('app_theme', 'zenydeskos')
            ON DUPLICATE KEY UPDATE `valor` = 'zenydeskos'");
    }

    public function down()
    {
        // Operacao segura de provisionamento idempotente
    }
}
