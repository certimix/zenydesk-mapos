<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Quadro Kanban das Ordens de Serviço.
 *
 * É uma visão alternativa das mesmas OS já geridas pelo controller Os — não
 * cria nenhuma entidade nova. As colunas vêm da mesma lista de status
 * configurável em Configurações > OS (chave "os_status_list"), a mesma usada
 * para filtrar a listagem tradicional. Arrastar um card entre colunas chama
 * moverStatus(), que faz exatamente a mesma atualização que editar uma OS e
 * trocar o campo Status manualmente teria feito.
 *
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 * @property Permission $permission
 * @property Os_model $os_model
 */
class Kanban extends MY_Controller
{
    /**
     * Lista completa de status possíveis de uma OS (mesmos valores do
     * <select> em application/views/os/editarOs.php e adicionarOs.php).
     */
    private $statusPadrao = [
        'Aberto',
        'Orçamento',
        'Negociação',
        'Aprovado',
        'Aguardando Peças',
        'Em Andamento',
        'Finalizado',
        'Faturado',
        'Cancelado',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('os_model');
        // Sem 'menuOs': o item "Kanban" do menu já se marca como ativo pela URL,
        // e setar menuOs aqui destacava "Ordens de Serviço" junto.
    }

    public function index()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar O.S.');
            redirect(base_url());
        }

        // Mesmo filtro "Minha Fila" já usado na listagem tradicional de OS.
        $minhas = $this->input->get('minhas') ? '1' : '';

        $where = [];
        if ($minhas) {
            $where['usuarios_id'] = $this->session->userdata('id_admin');
        }

        $colunas = $this->getColunasConfiguradas();
        $where['status'] = $colunas;

        $todasAsOs = $this->os_model->getOsKanban($where);

        $quadro = [];
        foreach ($colunas as $status) {
            $quadro[$status] = [];
        }
        foreach ($todasAsOs as $os) {
            // Se a OS tiver um status fora da lista configurada (ex.: configuração
            // foi alterada depois que a OS foi criada), ela simplesmente não
            // aparece no quadro, igual já acontece hoje na listagem tradicional.
            if (array_key_exists($os->status, $quadro)) {
                $quadro[$os->status][] = $os;
            }
        }

        $this->data['quadro'] = $quadro;
        $this->data['minhas'] = $minhas;
        $this->data['podeEditar'] = $this->permission->checkPermission($this->session->userdata('permissao'), 'eOs');
        $this->data['view'] = 'kanban/kanban';

        return $this->layout();
    }

    public function moverStatus()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
            echo json_encode(['result' => false, 'mensagem' => 'Você não tem permissão para editar O.S.']);

            return;
        }

        $idOs = (int) $this->input->post('idOs');
        $novoStatus = $this->input->post('status');

        if ($idOs <= 0 || ! $this->os_model->getById($idOs)) {
            echo json_encode(['result' => false, 'mensagem' => 'Ordem de serviço inválida.']);

            return;
        }

        if (! in_array($novoStatus, $this->statusPadrao, true)) {
            echo json_encode(['result' => false, 'mensagem' => 'Status inválido.']);

            return;
        }

        $os = $this->os_model->getById($idOs);

        // Mesma regra de devolução/débito de estoque que Os::editar() já
        // aplica quando o status muda de/para Cancelado, pra não deixar o
        // Kanban desalinhado do controle de estoque.
        $this->load->model('produtos_model');
        if (strtolower($novoStatus) == 'cancelado' && strtolower($os->status) != 'cancelado') {
            $this->devolucaoEstoque($idOs);
        }
        if (strtolower($os->status) == 'cancelado' && strtolower($novoStatus) != 'cancelado') {
            $this->debitarEstoque($idOs);
        }

        // Registra quando a OS foi encerrada (para o SLA "cumprido / fora do prazo")
        $this->load->helper('sla');
        $dados = ['status' => $novoStatus];
        if (os_status_encerrado($novoStatus) && ! os_status_encerrado($os->status)) {
            $dados['encerrado_em'] = date('Y-m-d H:i:s');
        } elseif (! os_status_encerrado($novoStatus)) {
            $dados['encerrado_em'] = null;
        }

        if ($this->os_model->edit('os', $dados, 'idOs', $idOs) == true) {
            if (in_array($novoStatus, ['Finalizado', 'Faturado'], true)) {
                $this->load->model('avaliacoes_model');
                $this->avaliacoes_model->garantirLink((int) $idOs);
            }
            log_info("Moveu OS no Kanban. ID: {$idOs}. Novo status: {$novoStatus}");
            echo json_encode(['result' => true]);
        } else {
            echo json_encode(['result' => false]);
        }
    }

    /**
     * Mesma lógica de application/views/os/os.php: usa a lista configurada em
     * Configurações > OS quando ela existir, senão cai para a lista completa.
     */
    private function getColunasConfiguradas()
    {
        $configurados = json_decode($this->data['configuration']['os_status_list'] ?? '');

        if (is_array($configurados) && count($configurados) > 0) {
            // Preserva a ordem "natural" do fluxo de atendimento, não a ordem
            // salva na configuração.
            return array_values(array_intersect($this->statusPadrao, $configurados));
        }

        return $this->statusPadrao;
    }

    private function devolucaoEstoque($id)
    {
        if ($produtos = $this->os_model->getProdutos($id)) {
            if ($this->data['configuration']['control_estoque']) {
                foreach ($produtos as $p) {
                    $this->produtos_model->updateEstoque($p->produtos_id, $p->quantidade, '+');
                    log_info('ESTOQUE: Produto id ' . $p->produtos_id . ' voltou ao estoque. Quantidade: ' . $p->quantidade . '. Motivo: OS cancelada via Kanban');
                }
            }
        }
    }

    private function debitarEstoque($id)
    {
        if ($produtos = $this->os_model->getProdutos($id)) {
            if ($this->data['configuration']['control_estoque']) {
                foreach ($produtos as $p) {
                    $this->produtos_model->updateEstoque($p->produtos_id, $p->quantidade, '-');
                    log_info('ESTOQUE: Produto id ' . $p->produtos_id . ' baixa do estoque. Quantidade: ' . $p->quantidade . '. Motivo: OS reaberta via Kanban (estava Cancelado)');
                }
            }
        }
    }
}
