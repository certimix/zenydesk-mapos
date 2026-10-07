<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Backup extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (! $this->session->userdata('logado')) {
            redirect('login');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'cBackup') && ! $this->permission->checkPermission($this->session->userdata('permissao'), 'cSistema')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para gerenciar backups do sistema.');
            redirect(base_url());
        }

        $this->load->model('mapos_model');
        $this->data['menuConfiguracoes'] = 'Backup';
    }

    public function index()
    {
        $this->data['menuPainel'] = 'Backup';
        $this->data['custom_error'] = '';
        $this->data['view'] = 'mapos/backup';

        return $this->layout();
    }

    public function download()
    {
        $this->load->dbutil();
        $this->load->helper('download');

        $prefs = [
            'format' => 'txt',
            'filename' => 'zenydesk_os_backup.sql',
            'add_drop' => true,
            'add_insert' => true,
            'newline' => "\n",
        ];

        $backup = $this->dbutil->backup($prefs);
        $filename = 'zenydesk_os_backup_' . date('Y-m-d_H-i-s') . '.sql';

        log_info('Realizou o download do backup do banco de dados.');
        force_download($filename, $backup);
    }

    public function restaurar()
    {
        if (empty($_FILES['userfile']['name'])) {
            $this->session->set_flashdata('error', 'Por favor, selecione um arquivo SQL de backup para enviar.');
            redirect('backup');
            return;
        }

        $file_tmp = $_FILES['userfile']['tmp_name'];
        $file_name = $_FILES['userfile']['name'];
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);

        if (strtolower($ext) !== 'sql' && strtolower($ext) !== 'txt') {
            $this->session->set_flashdata('error', 'Formato de arquivo inválido. Apenas arquivos .sql ou .txt são suportados.');
            redirect('backup');
            return;
        }

        $sql_content = file_get_contents($file_tmp);
        if (empty($sql_content)) {
            $this->session->set_flashdata('error', 'O arquivo enviado está vazio.');
            redirect('backup');
            return;
        }

        $queries = explode(";\n", $sql_content);
        $success_count = 0;
        $error_count = 0;

        $this->db->trans_start();
        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query)) {
                @$this->db->query($query);
                if ($this->db->error()['code'] === 0) {
                    $success_count++;
                } else {
                    $error_count++;
                }
            }
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            $this->session->set_flashdata('error', 'Ocorreu um erro durante a restauração do banco de dados.');
        } else {
            $this->session->set_flashdata('success', "Banco de dados restaurado com sucesso! Executadas {$success_count} instruções.");
            log_info('Restaurou o banco de dados via upload SQL.');
        }

        redirect('backup');
    }

    public function transferir()
    {
        $this->load->dbutil();
        $this->load->helper('download');

        $prefs = [
            'format' => 'txt',
            'filename' => 'database.sql',
            'add_drop' => true,
            'add_insert' => true,
            'newline' => "\n",
        ];

        $sql = $this->dbutil->backup($prefs);
        $meta = [
            'plataforma' => 'ZenyDesk OS',
            'versao' => '2026.1',
            'data_exportacao' => date('Y-m-d H:i:s'),
            'instrucoes' => 'Para migrar este banco de dados para outro servidor/domínio de sua preferência, importe o arquivo database.sql no MySQL/MariaDB da nova instalação.',
        ];

        $zip = new ZipArchive();
        $upload_dir = FCPATH . 'assets/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $zip_filename = $upload_dir . 'zenydesk_os_pacote_migracao_' . date('Y-m-d_H-i') . '.zip';

        if ($zip->open($zip_filename, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $zip->addFromString('database.sql', $sql);
            $zip->addFromString('manifesto_migracao.json', json_encode($meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $zip->close();

            log_info('Exportou pacote de transferência e migração do banco de dados.');
            force_download($zip_filename, null);
        } else {
            $this->session->set_flashdata('error', 'Não foi possível gerar o pacote ZIP de transferência.');
            redirect('backup');
        }
    }
}
