<?php

/**
 * Ativa o tema "Zenydesk O.S" (claro, estilo SNDesk).
 * Reversível em Configurações > Sistema > Tema do Sistema.
 */
class Migration_set_tema_zenydesk_desk extends CI_Migration
{
    public function up()
    {
        $this->db->query("INSERT INTO `configuracoes` (`config`, `valor`) VALUES ('app_theme', 'zenydeskos')
            ON DUPLICATE KEY UPDATE `valor` = 'zenydeskos'");
    }

    public function down()
    {
        $this->db->query("UPDATE `configuracoes` SET `valor` = 'zenydeskgms' WHERE `config` = 'app_theme' AND `valor` IN ('zenydeskos', 'zenydeskdesk')");
    }
}
