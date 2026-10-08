<?php

/**
 * Ativa o tema visual "Zenydesk (moderno)" (assets/css/tema-zenydesk-gms.css)
 * como tema do sistema. Reversível a qualquer momento em
 * Configurações > Sistema > Tema do Sistema.
 */
class Migration_set_tema_zenydesk_gms extends CI_Migration
{
    public function up()
    {
        $this->db->query("INSERT INTO `configuracoes` (`config`, `valor`) VALUES ('app_theme', 'zenydeskgms')
            ON DUPLICATE KEY UPDATE `valor` = 'zenydeskgms'");
    }

    public function down()
    {
        $this->db->query("UPDATE `configuracoes` SET `valor` = 'default' WHERE `config` = 'app_theme' AND `valor` = 'zenydeskgms'");
    }
}
