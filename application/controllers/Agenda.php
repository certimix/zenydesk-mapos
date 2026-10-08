<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Agenda (atalho "Agenda" do Menu rápido): calendário único com
 * - Ordens de Serviço (pela data final, mesma fonte do painel)
 * - Eventos (Cadastros > Eventos)
 * - Feriados e Afastamentos (dias marcados no fundo)
 */
class Agenda extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cadastros_model');
        $this->data['menuAgenda'] = true;
    }

    private function pode(string $flag): bool
    {
        return $this->permission->checkPermission($this->session->userdata('permissao'), $flag);
    }

    public function index()
    {
        if (! $this->pode('vOs') && ! $this->pode('vCadastro')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para ver a agenda.');
            redirect(base_url());
        }

        $this->data['verOs'] = $this->pode('vOs');
        $this->data['verCadastros'] = $this->pode('vCadastro');
        $this->data['podeAdicionarEvento'] = $this->pode('vCadastro') && $this->pode('aCadastro');
        $this->data['view'] = 'agenda/agenda';

        return $this->layout();
    }

    /**
     * JSON para o FullCalendar: eventos, feriados e afastamentos.
     */
    public function eventos()
    {
        if (! $this->pode('vCadastro')) {
            return $this->json([]);
        }

        $inicio = $this->dataValida($this->input->get('start'));
        $fim = $this->dataValida($this->input->get('end'));
        $saida = [];

        foreach ($this->cadastros_model->eventosAgenda($inicio, $fim) as $e) {
            $detalhes = [];
            if ($e->tipo) {
                $detalhes[] = '<b>Tipo:</b> ' . html_escape($e->tipo);
            }
            if ($e->responsavel) {
                $detalhes[] = '<b>Responsável:</b> ' . html_escape($e->responsavel);
            }
            if ($e->cliente) {
                $detalhes[] = '<b>Cliente:</b> ' . html_escape($e->cliente);
            }
            if ($e->descricao) {
                $detalhes[] = '<b>Descrição:</b> ' . nl2br(html_escape($e->descricao));
            }

            $saida[] = [
                'title' => $e->titulo,
                'start' => $e->data_inicio,
                'end' => $e->data_fim ?: null,
                'color' => $e->cor ?: '#17b8a6',
                'url' => site_url('cadastros/eventos/editar/' . $e->id),
                'extendedProps' => ['detalhes' => implode('<br>', $detalhes)],
            ];
        }

        // Feriados: os recorrentes repetem em todos os anos do intervalo pedido.
        $anoIni = (int) substr($inicio ?: date('Y-m-d'), 0, 4);
        $anoFim = (int) substr($fim ?: date('Y-m-d'), 0, 4);
        foreach ($this->cadastros_model->feriadosAtivos() as $f) {
            $datas = [$f->data];
            if ($f->recorrente) {
                $datas = [];
                for ($a = $anoIni; $a <= $anoFim; $a++) {
                    $datas[] = $a . substr($f->data, 4);
                }
            }
            foreach ($datas as $d) {
                $saida[] = [
                    'title' => '',
                    'start' => $d,
                    'allDay' => true,
                    'display' => 'background',
                    'color' => '#ffb648',
                ];
                $saida[] = [
                    'title' => 'Feriado: ' . $f->nome,
                    'start' => $d,
                    'allDay' => true,
                    'color' => '#ff8a3d',
                ];
            }
        }

        foreach ($this->cadastros_model->afastamentosPeriodo($inicio, $fim) as $a) {
            $saida[] = [
                'title' => 'Afastamento: ' . ($a->usuario ?: '—') . ($a->motivo ? " ({$a->motivo})" : ''),
                'start' => $a->data_inicio,
                'end' => $a->data_fim,
                'color' => '#a78bfa',
                'url' => site_url('cadastros/afastamentos/editar/' . $a->id),
            ];
        }

        return $this->json($saida);
    }

    private function dataValida($v): ?string
    {
        if (! is_string($v) || ! preg_match('/^\d{4}-\d{2}-\d{2}/', $v)) {
            return null;
        }

        return substr($v, 0, 10) . ' 00:00:00';
    }

    private function json($dados)
    {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($dados));
    }
}
