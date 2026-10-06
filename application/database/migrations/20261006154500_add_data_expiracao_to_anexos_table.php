<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_add_data_expiracao_to_anexos_table extends CI_Migration
{
    public function up()
    {
        if (!$this->db->field_exists('data_cadastro', 'anexos')) {
            $this->dbforge->add_column('anexos', [
                'data_cadastro' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
        }

        if (!$this->db->field_exists('data_expiracao', 'anexos')) {
            $this->dbforge->add_column('anexos', [
                'data_expiracao' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
        }

        if (!$this->db->field_exists('tipo', 'anexos')) {
            $this->dbforge->add_column('anexos', [
                'tipo' => [
                    'type' => 'VARCHAR',
                    'constraint' => '20',
                    'default' => 'foto',
                    'null' => true,
                ],
            ]);
        }

        // Define data_cadastro e data_expiracao de 5 anos para registros legados
        $this->db->query("UPDATE `anexos` SET `data_cadastro` = NOW(), `data_expiracao` = DATE_ADD(NOW(), INTERVAL 5 YEAR) WHERE `data_expiracao` IS NULL");
    }

    public function down()
    {
        if ($this->db->field_exists('data_cadastro', 'anexos')) {
            $this->dbforge->drop_column('anexos', 'data_cadastro');
        }
        if ($this->db->field_exists('data_expiracao', 'anexos')) {
            $this->dbforge->drop_column('anexos', 'data_expiracao');
        }
        if ($this->db->field_exists('tipo', 'anexos')) {
            $this->dbforge->drop_column('anexos', 'tipo');
        }
    }
}
