<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_login_attempts_table extends CI_Migration
{
    public function up()
    {
        if (!$this->db->table_exists('login_attempts')) {
            $this->dbforge->add_field([
                'id' => [
                    'type' => 'BIGINT',
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'ip_address' => [
                    'type' => 'VARCHAR',
                    'constraint' => 45,
                    'null' => false,
                ],
                'username' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ],
                'context' => [
                    'type' => 'VARCHAR',
                    'constraint' => 30,
                    'default' => 'admin',
                    'null' => false,
                ],
                'attempt_time' => [
                    'type' => 'DATETIME',
                    'null' => false,
                ],
                'success' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 0,
                    'null' => false,
                ],
            ]);
            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('login_attempts', true);

            $this->db->query('ALTER TABLE `login_attempts` ADD INDEX `idx_ip_time` (`ip_address`, `attempt_time`)');
            $this->db->query('ALTER TABLE `login_attempts` ADD INDEX `idx_user_time` (`username`, `attempt_time`)');
        }
    }

    public function down()
    {
        if ($this->db->table_exists('login_attempts')) {
            $this->dbforge->drop_table('login_attempts', true);
        }
    }
}
