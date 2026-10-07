<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Landing page pública do Zenydesk OS.
 *
 * Diferente dos demais controllers (que estendem MY_Controller e exigem
 * login), este é público de propósito: é a porta de entrada do site pra
 * quem ainda não é cliente. Quem já está logado é mandado direto pro
 * painel, pra não ver a landing de novo a cada vez que abre a URL raiz.
 *
 * @property CI_Session $session
 */
class Home extends CI_Controller
{
    public function index()
    {
        if ($this->session->userdata('logado')) {
            redirect('mapos');
        }

        $data = [
            'page_title' => 'Zenydesk OS — Ordens de serviço & atendimento',
            'page_description' => 'Cadastro de clientes, laudo com foto, orçamento automático via WhatsApp e termo de garantia — parte da plataforma Zenydesk.',
            'login_url' => site_url('login'),
            'whatsapp_url' => 'https://wa.me/5575998626311',
        ];

        $this->load->view('home/header', $data);
        $this->load->view('home/hero', $data);
        $this->load->view('home/stats');
        $this->load->view('home/features', $data);
        $this->load->view('home/dual-audience');
        $this->load->view('home/pricing', $data);
        $this->load->view('home/faq');
        $this->load->view('home/footer', $data);
    }
}
