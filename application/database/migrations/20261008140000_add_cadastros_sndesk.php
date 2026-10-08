<?php

/**
 * Cadastros auxiliares no estilo do SNDesk (menu "Cadastros") e as
 * permissões vCadastro/aCadastro/eCadastro/dCadastro.
 *
 * Todas as tabelas usam o prefixo cad_ para não colidir com tabelas que o
 * Map-OS já tem (ex.: "categorias" é do financeiro).
 */
class Migration_add_cadastros_sndesk extends CI_Migration
{
    private $tabelas = [
        // ordem de criação respeita as chaves estrangeiras
        'cad_categorias', 'cad_subcategorias', 'cad_departamentos', 'cad_equipes',
        'cad_edificios', 'cad_ativos', 'cad_fluxos', 'cad_estagios', 'cad_afastamentos',
        'cad_campos_adicionais', 'cad_checklist_modelos', 'cad_eventos', 'cad_feriados',
        'cad_mensagens_predefinidas', 'cad_slas',
    ];

    private $flags = ['vCadastro', 'aCadastro', 'eCadastro', 'dCadastro'];

    public function up()
    {
        $padrao = 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci';
        $carimbo = '`criado_em` DATETIME NULL, `atualizado_em` DATETIME NULL';

        $sql = [
            "CREATE TABLE IF NOT EXISTS `cad_categorias` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `nome` VARCHAR(120) NOT NULL,
                `descricao` TEXT NULL,
                `ativo` TINYINT(1) NOT NULL DEFAULT 1,
                {$carimbo},
                PRIMARY KEY (`id`)
            ) {$padrao}",

            "CREATE TABLE IF NOT EXISTS `cad_subcategorias` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `categoria_id` INT(11) NOT NULL,
                `nome` VARCHAR(120) NOT NULL,
                `ativo` TINYINT(1) NOT NULL DEFAULT 1,
                {$carimbo},
                PRIMARY KEY (`id`),
                KEY `categoria_id` (`categoria_id`),
                CONSTRAINT `fk_cad_sub_cat` FOREIGN KEY (`categoria_id`) REFERENCES `cad_categorias` (`id`) ON DELETE RESTRICT
            ) {$padrao}",

            "CREATE TABLE IF NOT EXISTS `cad_departamentos` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `nome` VARCHAR(120) NOT NULL,
                `responsavel_id` INT(11) NULL,
                `email` VARCHAR(150) NULL,
                `telefone` VARCHAR(30) NULL,
                `ativo` TINYINT(1) NOT NULL DEFAULT 1,
                {$carimbo},
                PRIMARY KEY (`id`),
                KEY `responsavel_id` (`responsavel_id`),
                CONSTRAINT `fk_cad_dep_usu` FOREIGN KEY (`responsavel_id`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE SET NULL
            ) {$padrao}",

            "CREATE TABLE IF NOT EXISTS `cad_equipes` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `nome` VARCHAR(120) NOT NULL,
                `departamento_id` INT(11) NULL,
                `lider_id` INT(11) NULL,
                `descricao` TEXT NULL,
                `ativo` TINYINT(1) NOT NULL DEFAULT 1,
                {$carimbo},
                PRIMARY KEY (`id`),
                KEY `departamento_id` (`departamento_id`),
                KEY `lider_id` (`lider_id`),
                CONSTRAINT `fk_cad_eq_dep` FOREIGN KEY (`departamento_id`) REFERENCES `cad_departamentos` (`id`) ON DELETE RESTRICT,
                CONSTRAINT `fk_cad_eq_usu` FOREIGN KEY (`lider_id`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE SET NULL
            ) {$padrao}",

            "CREATE TABLE IF NOT EXISTS `cad_edificios` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `nome` VARCHAR(150) NOT NULL,
                `cliente_id` INT(11) NULL,
                `endereco` VARCHAR(255) NULL,
                `cidade` VARCHAR(100) NULL,
                `observacao` TEXT NULL,
                `ativo` TINYINT(1) NOT NULL DEFAULT 1,
                {$carimbo},
                PRIMARY KEY (`id`),
                KEY `cliente_id` (`cliente_id`),
                CONSTRAINT `fk_cad_edi_cli` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`idClientes`) ON DELETE SET NULL
            ) {$padrao}",

            "CREATE TABLE IF NOT EXISTS `cad_ativos` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `nome` VARCHAR(150) NOT NULL,
                `cliente_id` INT(11) NULL,
                `categoria_id` INT(11) NULL,
                `subcategoria_id` INT(11) NULL,
                `edificio_id` INT(11) NULL,
                `numero_serie` VARCHAR(100) NULL,
                `patrimonio` VARCHAR(100) NULL,
                `observacao` TEXT NULL,
                `ativo` TINYINT(1) NOT NULL DEFAULT 1,
                {$carimbo},
                PRIMARY KEY (`id`),
                KEY `cliente_id` (`cliente_id`),
                KEY `categoria_id` (`categoria_id`),
                KEY `subcategoria_id` (`subcategoria_id`),
                KEY `edificio_id` (`edificio_id`),
                CONSTRAINT `fk_cad_atv_cli` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`idClientes`) ON DELETE SET NULL,
                CONSTRAINT `fk_cad_atv_cat` FOREIGN KEY (`categoria_id`) REFERENCES `cad_categorias` (`id`) ON DELETE RESTRICT,
                CONSTRAINT `fk_cad_atv_sub` FOREIGN KEY (`subcategoria_id`) REFERENCES `cad_subcategorias` (`id`) ON DELETE RESTRICT,
                CONSTRAINT `fk_cad_atv_edi` FOREIGN KEY (`edificio_id`) REFERENCES `cad_edificios` (`id`) ON DELETE RESTRICT
            ) {$padrao}",

            "CREATE TABLE IF NOT EXISTS `cad_fluxos` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `nome` VARCHAR(120) NOT NULL,
                `descricao` TEXT NULL,
                `ativo` TINYINT(1) NOT NULL DEFAULT 1,
                {$carimbo},
                PRIMARY KEY (`id`)
            ) {$padrao}",

            "CREATE TABLE IF NOT EXISTS `cad_estagios` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `fluxo_id` INT(11) NOT NULL,
                `nome` VARCHAR(120) NOT NULL,
                `ordem` INT(11) NOT NULL DEFAULT 1,
                `cor` VARCHAR(7) NULL,
                `ativo` TINYINT(1) NOT NULL DEFAULT 1,
                {$carimbo},
                PRIMARY KEY (`id`),
                KEY `fluxo_id` (`fluxo_id`),
                CONSTRAINT `fk_cad_est_flu` FOREIGN KEY (`fluxo_id`) REFERENCES `cad_fluxos` (`id`) ON DELETE RESTRICT
            ) {$padrao}",

            "CREATE TABLE IF NOT EXISTS `cad_afastamentos` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `usuario_id` INT(11) NOT NULL,
                `tipo` VARCHAR(40) NOT NULL,
                `data_inicio` DATE NOT NULL,
                `data_fim` DATE NOT NULL,
                `observacao` TEXT NULL,
                {$carimbo},
                PRIMARY KEY (`id`),
                KEY `usuario_id` (`usuario_id`),
                CONSTRAINT `fk_cad_afa_usu` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE CASCADE
            ) {$padrao}",

            "CREATE TABLE IF NOT EXISTS `cad_campos_adicionais` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `nome` VARCHAR(100) NOT NULL,
                `tipo` VARCHAR(30) NOT NULL,
                `opcoes` TEXT NULL,
                `obrigatorio` TINYINT(1) NOT NULL DEFAULT 0,
                `ativo` TINYINT(1) NOT NULL DEFAULT 1,
                {$carimbo},
                PRIMARY KEY (`id`)
            ) {$padrao}",

            "CREATE TABLE IF NOT EXISTS `cad_checklist_modelos` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `nome` VARCHAR(120) NOT NULL,
                `itens` TEXT NOT NULL,
                `ativo` TINYINT(1) NOT NULL DEFAULT 1,
                {$carimbo},
                PRIMARY KEY (`id`)
            ) {$padrao}",

            "CREATE TABLE IF NOT EXISTS `cad_eventos` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `titulo` VARCHAR(150) NOT NULL,
                `tipo` VARCHAR(40) NULL,
                `data_inicio` DATETIME NOT NULL,
                `data_fim` DATETIME NULL,
                `usuario_id` INT(11) NULL,
                `cliente_id` INT(11) NULL,
                `cor` VARCHAR(7) NULL,
                `descricao` TEXT NULL,
                {$carimbo},
                PRIMARY KEY (`id`),
                KEY `data_inicio` (`data_inicio`),
                KEY `usuario_id` (`usuario_id`),
                KEY `cliente_id` (`cliente_id`),
                CONSTRAINT `fk_cad_evt_usu` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE SET NULL,
                CONSTRAINT `fk_cad_evt_cli` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`idClientes`) ON DELETE SET NULL
            ) {$padrao}",

            "CREATE TABLE IF NOT EXISTS `cad_feriados` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `nome` VARCHAR(120) NOT NULL,
                `data` DATE NOT NULL,
                `recorrente` TINYINT(1) NOT NULL DEFAULT 1,
                `ativo` TINYINT(1) NOT NULL DEFAULT 1,
                {$carimbo},
                PRIMARY KEY (`id`)
            ) {$padrao}",

            "CREATE TABLE IF NOT EXISTS `cad_mensagens_predefinidas` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `titulo` VARCHAR(150) NOT NULL,
                `mensagem` TEXT NOT NULL,
                `ativo` TINYINT(1) NOT NULL DEFAULT 1,
                {$carimbo},
                PRIMARY KEY (`id`)
            ) {$padrao}",

            "CREATE TABLE IF NOT EXISTS `cad_slas` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `nome` VARCHAR(120) NOT NULL,
                `prioridade` VARCHAR(20) NOT NULL,
                `tempo_resposta` INT(11) NOT NULL,
                `tempo_solucao` INT(11) NOT NULL,
                `horario_comercial` TINYINT(1) NOT NULL DEFAULT 1,
                `descricao` TEXT NULL,
                `ativo` TINYINT(1) NOT NULL DEFAULT 1,
                {$carimbo},
                PRIMARY KEY (`id`)
            ) {$padrao}",
        ];

        foreach ($sql as $q) {
            $this->db->query($q);
        }

        // Feriados nacionais fixos para já começar com algo útil.
        if ((int) $this->db->count_all('cad_feriados') === 0) {
            $agora = date('Y-m-d H:i:s');
            $ano = date('Y');
            $nacionais = [
                ['Confraternização Universal', '01-01'], ['Tiradentes', '04-21'], ['Dia do Trabalho', '05-01'],
                ['Independência do Brasil', '09-07'], ['Nossa Senhora Aparecida', '10-12'], ['Finados', '11-02'],
                ['Proclamação da República', '11-15'], ['Dia Nacional de Zumbi e da Consciência Negra', '11-20'],
                ['Natal', '12-25'],
            ];
            foreach ($nacionais as [$nome, $mmdd]) {
                $this->db->insert('cad_feriados', [
                    'nome' => $nome, 'data' => "{$ano}-{$mmdd}", 'recorrente' => 1, 'ativo' => 1, 'criado_em' => $agora,
                ]);
            }
        }

        // Dá as permissões de Cadastros a quem já pode configurar o sistema.
        $this->ajustarPermissoes(true);
    }

    public function down()
    {
        $this->ajustarPermissoes(false);
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        foreach (array_reverse($this->tabelas) as $t) {
            $this->db->query("DROP TABLE IF EXISTS `{$t}`");
        }
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
    }

    private function ajustarPermissoes(bool $adicionar)
    {
        $perfis = $this->db->select('idPermissao, permissoes')->get('permissoes')->result();
        foreach ($perfis as $p) {
            $lista = json_decode_legacy((string) $p->permissoes);
            if (! is_array($lista)) {
                continue;
            }

            if ($adicionar) {
                $ehAdmin = isset($lista['cSistema']) && (string) $lista['cSistema'] === '1';
                foreach ($this->flags as $f) {
                    if (! array_key_exists($f, $lista)) {
                        $lista[$f] = $ehAdmin ? '1' : '';
                    }
                }
            } else {
                foreach ($this->flags as $f) {
                    unset($lista[$f]);
                }
            }

            $this->db->where('idPermissao', $p->idPermissao)
                ->update('permissoes', ['permissoes' => json_encode($lista)]);
        }
    }
}
