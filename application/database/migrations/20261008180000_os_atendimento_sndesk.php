<?php

/**
 * Atendimento no estilo SNDesk dentro da OS:
 *  - OS com Departamento, Equipe, Categoria, Sub Categoria, SLA e prazo do SLA
 *  - OS pode ficar sem técnico (fila "Chamados Sem Técnico")
 *  - Pré-chamados (abertos pelo cliente no portal, aguardando aprovação)
 *  - Usuários do portal (vários logins por cliente)
 *  - Avaliações de atendimento (link por OS)
 * Só acrescenta colunas/tabelas; nenhum dado existente é apagado.
 */
class Migration_os_atendimento_sndesk extends CI_Migration
{
    private function acrescentar(string $tabela, array $cols)
    {
        foreach ($cols as $nome => $def) {
            if (! $this->db->field_exists($nome, $tabela)) {
                $this->db->query("ALTER TABLE `{$tabela}` ADD COLUMN `{$nome}` {$def}");
            }
        }
    }

    private function fk(string $tabela, string $nome, string $coluna, string $ref, string $refCol, string $acao)
    {
        $existe = $this->db->query(
            'SELECT 1 FROM information_schema.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = ? AND CONSTRAINT_NAME = ?',
            [$tabela, $nome]
        )->num_rows() > 0;
        if (! $existe) {
            $this->db->query("ALTER TABLE `{$tabela}` ADD CONSTRAINT `{$nome}` FOREIGN KEY (`{$coluna}`) REFERENCES `{$ref}` (`{$refCol}`) ON DELETE {$acao}");
        }
    }

    public function up()
    {
        // ---- OS: técnico opcional + dados de atendimento ----
        $this->db->query('ALTER TABLE `os` MODIFY `usuarios_id` INT(11) NULL');

        $this->acrescentar('os', [
            'departamento_id' => 'INT(11) NULL',
            'equipe_id' => 'INT(11) NULL',
            'categoria_id' => 'INT(11) NULL',
            'subcategoria_id' => 'INT(11) NULL',
            'sla_id' => 'INT(11) NULL',
            'sla_prazo' => 'DATETIME NULL',
            'aberto_em' => 'DATETIME NULL',
            'encerrado_em' => 'DATETIME NULL',
            'origem' => "VARCHAR(20) NOT NULL DEFAULT 'interno'",
            'pre_chamado' => 'TINYINT(1) NOT NULL DEFAULT 0',
            'pre_chamado_motivo' => 'VARCHAR(255) NULL',
            'portal_usuario_id' => 'INT(11) NULL',
        ]);

        foreach (['departamento_id' => 'cad_departamentos', 'equipe_id' => 'cad_equipes', 'categoria_id' => 'cad_categorias',
            'subcategoria_id' => 'cad_subcategorias', 'sla_id' => 'cad_slas'] as $col => $ref) {
            $this->fk('os', "fk_os_{$col}", $col, $ref, 'id', 'SET NULL');
        }

        if (! $this->db->query("SHOW INDEX FROM `os` WHERE Key_name = 'idx_os_pre_chamado'")->num_rows()) {
            $this->db->query('ALTER TABLE `os` ADD INDEX `idx_os_pre_chamado` (`pre_chamado`)');
        }

        // Abertura das OS antigas = data inicial (o SLA delas começa a contar dali).
        $this->db->query('UPDATE `os` SET `aberto_em` = CONCAT(`dataInicial`, \' 08:00:00\') WHERE `aberto_em` IS NULL AND `dataInicial` IS NOT NULL');

        // ---- Usuários do portal do cliente ----
        $this->db->query("CREATE TABLE IF NOT EXISTS `cad_usuarios_portal` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `cliente_id` INT(11) NOT NULL,
            `nome` VARCHAR(120) NOT NULL,
            `email` VARCHAR(150) NOT NULL,
            `telefone` VARCHAR(30) NULL,
            `senha` VARCHAR(255) NOT NULL,
            `sla_id` INT(11) NULL,
            `ativo` TINYINT(1) NOT NULL DEFAULT 1,
            `ultimo_acesso` DATETIME NULL,
            `criado_em` DATETIME NULL,
            `atualizado_em` DATETIME NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `uk_cad_usuarios_portal_email` (`email`),
            KEY `cliente_id` (`cliente_id`),
            CONSTRAINT `fk_cad_up_cli` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`idClientes`) ON DELETE CASCADE,
            CONSTRAINT `fk_cad_up_sla` FOREIGN KEY (`sla_id`) REFERENCES `cad_slas` (`id`) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
        $this->fk('os', 'fk_os_portal_usuario', 'portal_usuario_id', 'cad_usuarios_portal', 'id', 'SET NULL');

        // ---- Avaliações de atendimento ----
        $this->db->query("CREATE TABLE IF NOT EXISTS `os_avaliacoes` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `os_id` INT(11) NOT NULL,
            `token` CHAR(40) NOT NULL,
            `nota` TINYINT(1) NULL,
            `comentario` TEXT NULL,
            `criado_em` DATETIME NOT NULL,
            `respondido_em` DATETIME NULL,
            `ip` VARCHAR(45) NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `uk_os_avaliacoes_os` (`os_id`),
            UNIQUE KEY `uk_os_avaliacoes_token` (`token`),
            CONSTRAINT `fk_os_avaliacoes_os` FOREIGN KEY (`os_id`) REFERENCES `os` (`idOs`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

        // ---- Nome do tema: "Zenydesk Desk" passou a se chamar "Zenydesk O.S" ----
        $this->db->where('config', 'app_theme')->where('valor', 'zenydeskdesk')->update('configuracoes', ['valor' => 'zenydeskos']);
    }

    public function down()
    {
        $this->db->query('DROP TABLE IF EXISTS `os_avaliacoes`');
        foreach (['departamento_id', 'equipe_id', 'categoria_id', 'subcategoria_id', 'sla_id', 'portal_usuario'] as $c) {
            $nome = $c === 'portal_usuario' ? 'fk_os_portal_usuario' : "fk_os_{$c}";
            $existe = $this->db->query(
                'SELECT 1 FROM information_schema.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = ? AND CONSTRAINT_NAME = ?',
                ['os', $nome]
            )->num_rows() > 0;
            if ($existe) {
                $this->db->query("ALTER TABLE `os` DROP FOREIGN KEY `{$nome}`");
            }
        }
        $this->db->query('DROP TABLE IF EXISTS `cad_usuarios_portal`');
        // As colunas novas da OS são mantidas (podem conter dados de atendimento).
    }
}
