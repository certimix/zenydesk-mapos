<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Pré-Chamados: OS abertas pelo cliente no portal que aguardam aprovação.
 *   /prechamados          → fila
 *   /prechamados/aprovar  → POST idOs, usuarios_id?, sla_id? → vira OS normal
 *   /prechamados/recusar  → POST idOs, motivo → OS cancelada
 */
class Prechamados extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar O.S.');
            redirect(base_url());
        }
        $this->load->model('os_model');
        $this->data['menuPreChamados'] = true;
    }

    public function index($offset = 0)
    {
        $this->data['results'] = $this->os_model->getOs(
            'os',
            'os.*',
            ['pre_chamado' => 1],
            200,
            0
        );
        $this->data['tecnicos'] = $this->db->select('idUsuarios, nome')->where('situacao', 1)->order_by('nome')->get('usuarios')->result();
        $this->data['slas'] = $this->db->select('id, nome, tempo_solucao')->where('ativo', 1)->order_by('prioridade')->get('cad_slas')->result();
        $this->data['podeEditar'] = $this->permission->checkPermission($this->session->userdata('permissao'), 'eOs');
        $this->data['view'] = 'prechamados/prechamados';

        return $this->layout();
    }

    private function osPendente()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eOs') || $this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar O.S.');
            redirect(site_url('prechamados'));
        }
        $os = $this->os_model->getById((int) $this->input->post('idOs'));
        if (! $os || ! (int) $os->pre_chamado) {
            $this->session->set_flashdata('error', 'Pré-chamado não encontrado ou já tratado.');
            redirect(site_url('prechamados'));
        }

        return $os;
    }

    public function aprovar()
    {
        $os = $this->osPendente();

        $tecnico = (int) $this->input->post('usuarios_id');
        if ($tecnico && ! $this->db->where('idUsuarios', $tecnico)->where('situacao', 1)->count_all_results('usuarios')) {
            $tecnico = 0;
        }
        $slaId = (int) $this->input->post('sla_id') ?: (int) $os->sla_id;
        if ($slaId && ! $this->db->where('id', $slaId)->count_all_results('cad_slas')) {
            $slaId = 0;
        }

        $this->load->library('sla');
        $abertura = $os->aberto_em ?: date('Y-m-d H:i:s');
        $this->os_model->edit('os', [
            'pre_chamado' => 0,
            'usuarios_id' => $tecnico ?: null,
            'sla_id' => $slaId ?: null,
            'sla_prazo' => $slaId ? $this->sla->prazoDaOs($abertura, $slaId) : null,
            'aberto_em' => $abertura,
        ], 'idOs', $os->idOs);

        log_info("Aprovou o pré-chamado #{$os->idOs}");
        $this->session->set_flashdata('success', "Pré-chamado #{$os->idOs} aprovado" . ($tecnico ? '.' : ' — ficou na fila "Chamados Sem Técnico".'));
        redirect(site_url('prechamados'));
    }

    public function recusar()
    {
        $os = $this->osPendente();
        $motivo = trim((string) $this->input->post('motivo'));
        $motivo = mb_substr($motivo, 0, 255);

        $this->os_model->edit('os', [
            'pre_chamado' => 0,
            'status' => 'Cancelado',
            'encerrado_em' => date('Y-m-d H:i:s'),
            'pre_chamado_motivo' => $motivo !== '' ? $motivo : 'Recusado',
        ], 'idOs', $os->idOs);

        log_info("Recusou o pré-chamado #{$os->idOs}");
        $this->session->set_flashdata('success', "Pré-chamado #{$os->idOs} recusado.");
        redirect(site_url('prechamados'));
    }
}
