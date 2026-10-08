<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Tabela de checklist por Ordem de Serviço.
 *
 * Cada linha é um item de checklist livre (sem modelo/template, por decisão
 * de escopo) associado a uma OS, podendo ser marcado como concluído por um
 * usuário em um momento específico.
 */
class Migration_add_checklist_os_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'idChecklist' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'os_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'descricao' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'concluido' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
                'default' => 0,
            ],
            'concluido_por' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'concluido_em' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'criado_em' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);
        $this->dbforge->add_key('idChecklist', true);
        $this->dbforge->add_key('os_id');
        $this->dbforge->create_table('checklist_os', true, [
            'ENGINE' => 'InnoDB',
            'CHARACTER SET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci',
        ]);

        $this->db->query('ALTER TABLE `checklist_os` ADD CONSTRAINT `fk_checklist_os_os` FOREIGN KEY (`os_id`) REFERENCES `os` (`idOs`) ON DELETE CASCADE');
    }

    public function down()
    {
        $this->dbforge->drop_table('checklist_os');
    }
}
