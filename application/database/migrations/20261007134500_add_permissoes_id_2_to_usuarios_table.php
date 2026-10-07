<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_add_permissoes_id_2_to_usuarios_table extends CI_Migration
{
    public function up()
    {
        if (!$this->db->field_exists('permissoes_id_2', 'usuarios')) {
            $this->dbforge->add_column('usuarios', [
                'permissoes_id_2' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => true,
                    'default' => null,
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->field_exists('permissoes_id_2', 'usuarios')) {
            $this->dbforge->drop_column('usuarios', 'permissoes_id_2');
        }
    }
}
