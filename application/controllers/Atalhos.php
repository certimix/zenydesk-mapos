<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Itens do menu no estilo SNDesk que nÃ£o sÃ£o cadastros:
 *   /atalhos/osEmBranco      â†’ OS em branco para imprimir e preencher Ã  mÃ£o
 *   /atalhos/emBreve/<item>  â†’ aviso dos itens ainda nÃ£o construÃ­dos
 */
class Atalhos extends MY_Controller
{
    private $emBreve = [
        'usuario-portal' => [
            'UsuÃ¡rio Portal',
            'bx-id-card',
            'Hoje o cliente entra no portal com o e-mail e a senha do prÃ³prio cadastro de Clientes (botÃ£o de chave na lista de Clientes). Uma tela prÃ³pria para gerenciar os usuÃ¡rios do portal vem numa prÃ³xima etapa.',
        ],
        'pre-chamados' => [
            'PrÃ©-Chamados',
            'bx-message-square-add',
            'Chamados abertos pelo cliente que aguardam aprovaÃ§Ã£o antes de virar OS.',
        ],
        'sem-tecnico' => [
            'Chamados Sem TÃ©cnico',
            'bx-user-x',
            'Hoje toda OS nasce com um tÃ©cnico responsÃ¡vel. Esta fila depende de permitir OS sem tÃ©cnico atribuÃ­do.',
        ],
        'avaliacoes' => [
            'AvaliaÃ§Ãµes',
            'bx-badge-check',
            'Pesquisa de satisfaÃ§Ã£o enviada ao cliente quando a OS Ã© finalizada, com nota e comentÃ¡rio.',
        ],
    ];

    public function osEmBranco()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'VocÃª nÃ£o tem permissÃ£o para imprimir O.S.');
            redirect(base_url());
        }

        $this->load->model('mapos_model');
        $this->load->view('atalhos/os_branco', [
            'emitente' => $this->mapos_model->getEmitente(),
            'configuration' => $this->data['configuration'],
        ]);
    }

    public function emBreve($item = '')
    {
        if (! isset($this->emBreve[$item])) {
            show_404();
        }

        [$titulo, $icone, $descricao] = $this->emBreve[$item];
        $this->data['titulo'] = $titulo;
        $this->data['icone'] = $icone;
        $this->data['descricao'] = $descricao;
        $this->data['view'] = 'atalhos/em_breve';

        return $this->layout();
    }
}
