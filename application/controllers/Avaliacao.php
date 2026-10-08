<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Página PÚBLICA de avaliação do atendimento (sem login):
 *   GET  /avaliacao/<token>  → formulário com nota 1–5 e comentário
 *   POST /avaliacao/<token>  → grava a resposta (uma vez só)
 *
 * O token é aleatório (160 bits) e único por OS.
 */
class Avaliacao extends CI_Controller
{
    public function index($token = '')
    {
        $this->load->model('avaliacoes_model');
        $this->load->model('mapos_model');
        $av = $this->avaliacoes_model->porToken((string) $token);

        $dados = [
            'av' => $av,
            'token' => (string) $token,
            'emitente' => $this->mapos_model->getEmitente(),
            'erro' => '',
            'enviado' => false,
        ];

        if ($av && $this->input->method() === 'post' && ! $av->respondido_em) {
            $nota = (int) $this->input->post('nota');
            $comentario = trim((string) $this->input->post('comentario'));
            if ($nota < 1 || $nota > 5) {
                $dados['erro'] = 'Escolha uma nota de 1 a 5 estrelas.';
            } elseif (mb_strlen($comentario) > 2000) {
                $dados['erro'] = 'O comentário pode ter no máximo 2000 caracteres.';
            } else {
                $this->avaliacoes_model->responder((int) $av->id, $nota, $comentario, (string) $this->input->ip_address());
                $dados['enviado'] = true;
                $dados['av'] = $this->avaliacoes_model->porToken((string) $token);
            }
        }

        if (! $av) {
            $this->output->set_status_header(404);
        }

        $this->load->view('avaliacoes/publica', $dados);
    }
}
