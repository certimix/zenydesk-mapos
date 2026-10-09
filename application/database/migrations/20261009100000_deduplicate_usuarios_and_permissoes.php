<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_deduplicate_usuarios_and_permissoes extends CI_Migration
{
    public function up()
    {
        // =====================================================================
        // 1. DEDUPLICAÇÃO E CONSOLIDAÇÃO DE PERMISSÕES (NÍVEIS / CATEGORIAS)
        // =====================================================================
        $allPerms = $this->db->order_by('idPermissao', 'asc')->get('permissoes')->result();
        
        $canonicalPerms = []; // nome_norm => idPermissao
        $duplicatesToCanonical = []; // dup_id => canonical_id

        foreach ($allPerms as $p) {
            $norm = mb_strtolower(trim((string) $p->nome));
            if (!isset($canonicalPerms[$norm])) {
                $canonicalPerms[$norm] = (int) $p->idPermissao;
            } else {
                $duplicatesToCanonical[(int) $p->idPermissao] = $canonicalPerms[$norm];
            }
        }

        // Remapear usuários que apontam para IDs de permissão duplicados
        foreach ($duplicatesToCanonical as $dupId => $canonicalId) {
            $this->db->where('permissoes_id', $dupId)->update('usuarios', ['permissoes_id' => $canonicalId]);
            $this->db->where('permissoes_id_2', $dupId)->update('usuarios', ['permissoes_id_2' => $canonicalId]);
            $this->db->where('idPermissao', $dupId)->delete('permissoes');
        }

        // Tentar adicionar índice único em permissoes(nome)
        try {
            $this->db->query("ALTER TABLE permissoes ADD UNIQUE INDEX idx_permissoes_nome (nome)");
        } catch (\Throwable $e) {
            // Ignora se o índice já existir
        }

        // =====================================================================
        // 2. DEDUPLICAÇÃO E CONSOLIDAÇÃO DE USUÁRIOS
        // =====================================================================
        // Usuários legítimos e canônicos: IDs 1 a 5 (com dados e CPFs reais)
        // Registros com IDs >= 6 que duplicam admin@zenydesk.com, c.eduardo.j.s22@gmail.com, etc.
        $allUsers = $this->db->order_by('idUsuarios', 'asc')->get('usuarios')->result();

        $canonicalUsers = []; // email_norm => idUsuarios
        $userDuplicates = []; // dup_id => canonical_id

        foreach ($allUsers as $u) {
            $email = mb_strtolower(trim((string) $u->email));
            if (empty($email)) {
                continue;
            }

            if (!isset($canonicalUsers[$email])) {
                $canonicalUsers[$email] = (int) $u->idUsuarios;
            } else {
                // Se o usuário atual for cópia (ex: IDs >= 6 com CPF genérico ou posterior)
                $userDuplicates[(int) $u->idUsuarios] = $canonicalUsers[$email];
            }
        }

        // Remapear dependências (os, vendas, lancamentos) para o usuário canônico
        foreach ($userDuplicates as $dupUserId => $canonicalUserId) {
            try {
                $this->db->where('usuarios_id', $dupUserId)->update('os', ['usuarios_id' => $canonicalUserId]);
            } catch (\Throwable $e) {}
            try {
                $this->db->where('usuarios_id', $dupUserId)->update('vendas', ['usuarios_id' => $canonicalUserId]);
            } catch (\Throwable $e) {}
            try {
                $this->db->where('usuarios_id', $dupUserId)->update('lancamentos', ['usuarios_id' => $canonicalUserId]);
            } catch (\Throwable $e) {}

            // Deletar o usuário duplicado
            $this->db->where('idUsuarios', $dupUserId)->delete('usuarios');
        }

        // Tentar adicionar índice único em usuarios(email) para blindar contra futuras inserções duplicadas
        try {
            $this->db->query("ALTER TABLE usuarios ADD UNIQUE INDEX idx_usuarios_email (email)");
        } catch (\Throwable $e) {
            // Ignora se o índice já existir
        }
    }

    public function down()
    {
        // Sem rollback destrutivo de deduplicação
    }
}
