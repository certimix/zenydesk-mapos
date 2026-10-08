<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Avaliações de atendimento (menu Avaliações):
 *   /avaliacoes            → resumo (média, % satisfeitos, distribuição) + respostas
 *   /avaliacoes/link/<id>  → POST: gera (ou devolve) o link de avaliação da OS (JSON)
 */
class Avaliacoes extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para ver as avaliações.');
            redirect(base_url());
        }
        $this->load->model('avaliacoes_model');
        $this->data['menuAvaliacoes'] = true;
    }

    public function index($offset = 0)
    {
        $f = [
            'de' => $this->dataValida($this->input->get('de')),
            'ate' => $this->dataValida($this->input->get('ate')),
            'tecnico' => (int) $this->input->get('tecnico') ?: null,
            'nota' => in_array((int) $this->input->get('nota'), [1, 2, 3, 4, 5], true) ? (int) $this->input->get('nota') : null,
        ];

        $this->load->library('pagination');
        $cfg = $this->data['configuration'];
        $cfg['base_url'] = site_url('avaliacoes/index');
        $cfg['total_rows'] = $this->avaliacoes_model->contar($f);
        $cfg['uri_segment'] = 3;
        $cfg['reuse_query_string'] = true;
        $this->pagination->initialize($cfg);

        $this->data['filtros'] = $f;
        $this->data['resumo'] = $this->avaliacoes_model->resumo($f);
        $this->data['results'] = $this->avaliacoes_model->listar($f, (int) $cfg['per_page'], (int) $offset);
        $this->data['tecnicos'] = $this->avaliacoes_model->tecnicos();
        $this->data['view'] = 'avaliacoes/avaliacoes';

        return $this->layout();
    }

    public function link($idOs = 0)
    {
        $this->load->model('os_model');
        $os = $this->os_model->getById((int) $idOs);
        if ($this->input->method() !== 'post' || ! $os) {
            return $this->json(['result' => false, 'mensagem' => 'OS não encontrada.']);
        }

        $av = $this->avaliacoes_model->garantirLink((int) $idOs);
        $url = site_url('avaliacao/' . $av->token);
        $telefone = preg_replace('/\D/', '', (string) ($os->celular_cliente ?: $os->telefone_cliente));
        if ($telefone !== '' && strlen($telefone) <= 11) {
            $telefone = '55' . $telefone;
        }
        $mensagem = "Olá, {$os->nomeCliente}! Sua OS #{$os->idOs} foi concluída. Pode avaliar nosso atendimento? Leva 10 segundos: {$url}";

        return $this->json([
            'result' => true,
            'url' => $url,
            'respondida' => (bool) $av->respondido_em,
            'whatsapp' => $telefone ? 'https://wa.me/' . $telefone . '?text=' . rawurlencode($mensagem) : null,
        ]);
    }

    private function dataValida($v): ?string
    {
        return is_string($v) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $v) ? $v : null;
    }

    private function json($dados)
    {
        return $this->output->set_content_type('application/json')->set_output(json_encode($dados));
    }
}
