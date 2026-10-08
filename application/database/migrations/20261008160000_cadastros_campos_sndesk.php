<?php

/**
 * Deixa os campos dos cadastros iguais aos do SNDesk.
 * Só ACRESCENTA colunas/tabelas. A única tabela removida é a antiga de
 * modelos de check list, depois de converter cada linha de cada modelo em
 * uma pergunta do novo Check List (nada se perde).
 */
class Migration_cadastros_campos_sndesk extends CI_Migration
{
    private function temColuna(string $tabela, string $coluna): bool
    {
        return $this->db->field_exists($coluna, $tabela);
    }

    /** Adiciona colunas que ainda não existem. $cols = [nome => definição SQL] */
    private function acrescentar(string $tabela, array $cols)
    {
        foreach ($cols as $nome => $def) {
            if (! $this->temColuna($tabela, $nome)) {
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
        // ---- SLAs: cor, prioridade 1..5, checkin/checkout, sem intervalos ----
        $this->acrescentar('cad_slas', [
            'cor' => "VARCHAR(7) NULL DEFAULT '#3c94e6' AFTER `nome`",
            'checkin_checkout' => 'TINYINT(1) NOT NULL DEFAULT 0 AFTER `horario_comercial`',
        ]);
        $this->db->query('ALTER TABLE `cad_slas` MODIFY `tempo_resposta` INT(11) NULL');
        foreach (['Baixa' => '1', 'Média' => '2', 'Alta' => '3', 'Urgente' => '4'] as $de => $para) {
            $this->db->where('prioridade', $de)->update('cad_slas', ['prioridade' => $para]);
        }
        if ((int) $this->db->count_all('cad_slas') === 0) {
            $agora = date('Y-m-d H:i:s');
            foreach ([['Baixa', '#4caf7d', '1', 6], ['Média', '#f2d544', '2', 4], ['Alta', '#ef4444', '3', 2]] as [$nome, $cor, $prio, $horas]) {
                $this->db->insert('cad_slas', [
                    'nome' => $nome, 'cor' => $cor, 'prioridade' => $prio, 'tempo_solucao' => $horas,
                    'horario_comercial' => 1, 'checkin_checkout' => 0, 'ativo' => 1, 'criado_em' => $agora,
                ]);
            }
        }

        // ---- Afastamentos: motivo livre + data/hora ----
        $this->acrescentar('cad_afastamentos', ['motivo' => 'VARCHAR(150) NULL AFTER `usuario_id`']);
        $this->db->query('UPDATE `cad_afastamentos` SET `motivo` = `tipo` WHERE `motivo` IS NULL');
        $this->db->query('ALTER TABLE `cad_afastamentos` MODIFY `tipo` VARCHAR(40) NULL');
        $this->db->query('ALTER TABLE `cad_afastamentos` MODIFY `data_inicio` DATETIME NOT NULL');
        $this->db->query('ALTER TABLE `cad_afastamentos` MODIFY `data_fim` DATETIME NOT NULL');

        // ---- Ativos: status, contrato, data de aquisição ----
        $this->acrescentar('cad_ativos', [
            'status' => "VARCHAR(30) NOT NULL DEFAULT 'Em uso' AFTER `nome`",
            'contrato' => 'VARCHAR(100) NULL AFTER `cliente_id`',
            'data_aquisicao' => 'DATE NULL AFTER `contrato`',
        ]);

        // ---- Campos adicionais: ordem e onde usar ----
        $this->acrescentar('cad_campos_adicionais', [
            'ordem' => 'INT(11) NOT NULL DEFAULT 1 AFTER `nome`',
            'usar_cliente' => 'TINYINT(1) NOT NULL DEFAULT 0 AFTER `opcoes`',
            'usar_chamado' => 'TINYINT(1) NOT NULL DEFAULT 1 AFTER `usar_cliente`',
            'usar_portal' => 'TINYINT(1) NOT NULL DEFAULT 0 AFTER `usar_chamado`',
            'so_edicao' => 'TINYINT(1) NOT NULL DEFAULT 0 AFTER `usar_portal`',
        ]);
        foreach (['Número' => 'Valor', 'Lista de opções' => 'Lista', 'Sim/Não' => 'Check Box'] as $de => $para) {
            $this->db->where('tipo', $de)->update('cad_campos_adicionais', ['tipo' => $para]);
        }

        // ---- Categorias / Sub Categorias / Departamentos: valor, SLA, portal ----
        foreach (['cad_categorias', 'cad_subcategorias', 'cad_departamentos'] as $t) {
            $this->acrescentar($t, [
                'valor' => 'DECIMAL(10,2) NULL',
                'sla_id' => 'INT(11) NULL',
                'remover_portal' => 'TINYINT(1) NOT NULL DEFAULT 0',
            ]);
            $this->fk($t, "fk_{$t}_sla", 'sla_id', 'cad_slas', 'id', 'SET NULL');
        }
        $this->acrescentar('cad_categorias', ['departamento_id' => 'INT(11) NULL AFTER `nome`']);
        $this->fk('cad_categorias', 'fk_cad_cat_dep', 'departamento_id', 'cad_departamentos', 'id', 'SET NULL');

        // ---- Check List: perguntas (como no SNDesk) ----
        $this->db->query("CREATE TABLE IF NOT EXISTS `cad_checklist_perguntas` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `descricao` TEXT NOT NULL,
            `ordem` INT(11) NOT NULL DEFAULT 1,
            `tipo` VARCHAR(30) NOT NULL,
            `opcoes` TEXT NULL,
            `requerido` TINYINT(1) NOT NULL DEFAULT 0,
            `ativo` TINYINT(1) NOT NULL DEFAULT 1,
            `criado_em` DATETIME NULL,
            `atualizado_em` DATETIME NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
        if ($this->db->table_exists('cad_checklist_modelos')) {
            // Converte modelos antigos (um item por linha) em perguntas, e só então remove a tabela.
            $ordem = 1;
            foreach ($this->db->get('cad_checklist_modelos')->result() as $m) {
                foreach (preg_split('/\r\n|\r|\n/', (string) $m->itens) as $linha) {
                    $linha = trim($linha);
                    if ($linha !== '') {
                        $this->db->insert('cad_checklist_perguntas', [
                            'descricao' => $linha, 'ordem' => $ordem++, 'tipo' => 'Caixa de Seleção',
                            'requerido' => 0, 'ativo' => (int) $m->ativo, 'criado_em' => date('Y-m-d H:i:s'),
                        ]);
                    }
                }
            }
            $this->db->query('DROP TABLE `cad_checklist_modelos`');
        }

        // ---- Edifícios: código, vigência, endereço completo, técnico e equipe ----
        $this->acrescentar('cad_edificios', [
            'codigo' => 'VARCHAR(50) NULL AFTER `id`',
            'vigencia_inicio' => 'DATE NULL AFTER `cliente_id`',
            'vigencia_fim' => 'DATE NULL AFTER `vigencia_inicio`',
            'cep' => 'VARCHAR(9) NULL AFTER `vigencia_fim`',
            'numero' => 'VARCHAR(20) NULL AFTER `endereco`',
            'bairro' => 'VARCHAR(100) NULL AFTER `numero`',
            'complemento' => 'VARCHAR(100) NULL AFTER `bairro`',
            'uf' => 'CHAR(2) NULL AFTER `cidade`',
            'tecnico_id' => 'INT(11) NULL',
            'equipe_id' => 'INT(11) NULL',
        ]);
        $this->fk('cad_edificios', 'fk_cad_edi_tec', 'tecnico_id', 'usuarios', 'idUsuarios', 'SET NULL');
        $this->fk('cad_edificios', 'fk_cad_edi_eq', 'equipe_id', 'cad_equipes', 'id', 'SET NULL');

        // ---- Equipes: nível e nível de acesso ----
        $this->acrescentar('cad_equipes', [
            'nivel' => 'INT(11) NOT NULL DEFAULT 1 AFTER `nome`',
            'nivel_acesso' => 'INT(11) NOT NULL DEFAULT 1 AFTER `nivel`',
        ]);

        // ---- Estágios: descrição ----
        $this->acrescentar('cad_estagios', ['descricao' => 'TEXT NULL AFTER `nome`']);
    }

    public function down()
    {
        // Mantém os dados: apenas a tabela nova de perguntas é removida.
        $this->db->query('DROP TABLE IF EXISTS `cad_checklist_perguntas`');
    }
}
