<?php

use Piggly\Pix\StaticPayload;

class Os_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array')
    {
        $this->db->select($fields . ',clientes.nomeCliente, clientes.celular as celular_cliente');
        $this->db->from($table);
        $this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
        $this->db->limit($perpage, $start);
        $this->db->order_by('idOs', 'desc');
        if ($where) {
            $this->db->where($where);
        }

        $query = $this->db->get();

        $result = ! $one ? $query->result() : $query->row();

        return $result;
    }

    public function getOs($table, $fields, $where = [], $perpage = 0, $start = 0, $one = false, $array = 'array')
    {
        $lista_clientes = [];
        if ($where) {
            if (array_key_exists('pesquisa', $where)) {
                $this->db->select('idClientes');
                $this->db->like('nomeCliente', $where['pesquisa']);
                $this->db->or_like('documento', $where['pesquisa']);
                $this->db->limit(25);
                $clientes = $this->db->get('clientes')->result();

                foreach ($clientes as $c) {
                    array_push($lista_clientes, $c->idClientes);
                }
            }
        }

        $this->db->select($fields . ',clientes.idClientes, clientes.nomeCliente, clientes.celular as celular_cliente, usuarios.nome, garantias.*');
        $this->db->from($table);
        $this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
        // LEFT: a OS pode estar sem técnico (fila "Chamados Sem Técnico")
        $this->db->join('usuarios', 'usuarios.idUsuarios = os.usuarios_id', 'left');
        $this->db->join('garantias', 'garantias.idGarantias = os.garantias_id', 'left');
        $this->db->join('produtos_os', 'produtos_os.os_id = os.idOs', 'left');

        // Pré-chamados (abertos pelo cliente e ainda não aprovados) só aparecem na fila própria
        $this->db->where('os.pre_chamado', array_key_exists('pre_chamado', $where) ? (int) $where['pre_chamado'] : 0);

        if (! empty($where['sem_tecnico'])) {
            // fila de trabalho: só chamados em aberto, sem responsável
            $this->db->where('os.usuarios_id IS NULL', null, false);
            if (! array_key_exists('status', $where)) {
                $this->db->where_not_in('os.status', ['Finalizado', 'Faturado', 'Cancelado']);
            }
        }
        $this->db->join('servicos_os', 'servicos_os.os_id = os.idOs', 'left');

        // condicionais da pesquisa

        // condicional de status
        if (array_key_exists('status', $where)) {
            $this->db->where_in('status', $where['status']);
        }

        // condicional de clientes
        if (array_key_exists('pesquisa', $where)) {
            if ($lista_clientes != null) {
                $this->db->where_in('os.clientes_id', $lista_clientes);
            }
        }

        // condicional data inicial
        if (array_key_exists('de', $where)) {
            $this->db->where('dataInicial >=', $where['de']);
        }
        // condicional data final
        if (array_key_exists('ate', $where)) {
            $this->db->where('dataFinal <=', $where['ate']);
        }

        // condicional "minha fila": restringe às OS atribuídas a um técnico/usuário específico
        if (array_key_exists('usuarios_id', $where)) {
            $this->db->where('os.usuarios_id', $where['usuarios_id']);
        }

        $this->db->limit($perpage, $start);
        $this->db->order_by('os.idOs', 'desc');
        $this->db->group_by('os.idOs');

        $query = $this->db->get();

        $result = ! $one ? $query->result() : $query->row();

        return $result;
    }

    /**
     * Lista de OS para o quadro Kanban: mesma base de dados de getOs(), mas
     * sem paginação (o Kanban mostra todas as OS em aberto de uma vez,
     * agrupadas por status) e com um teto de segurança para não sobrecarregar
     * a tela em bases muito grandes.
     */
    public function getOsKanban($where = [])
    {
        $this->db->select('os.*, clientes.nomeCliente, usuarios.nome as nomeUsuario');
        $this->db->from('os');
        $this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
        $this->db->join('usuarios', 'usuarios.idUsuarios = os.usuarios_id', 'left');
        $this->db->where('os.pre_chamado', 0);

        if (array_key_exists('usuarios_id', $where)) {
            $this->db->where('os.usuarios_id', $where['usuarios_id']);
        }

        if (array_key_exists('status', $where)) {
            $this->db->where_in('os.status', $where['status']);
        }

        $this->db->order_by('os.idOs', 'desc');
        $this->db->limit(500);

        return $this->db->get()->result();
    }

    /**
     * Listas para os campos de atendimento da OS (Departamento, Equipe,
     * Categoria, Sub Categoria e SLA). Só itens ativos, mais os que a OS
     * já usa (para não "sumir" um item desativado depois).
     */
    public function opcoesAtendimento($os = null): array
    {
        $usados = [
            'cad_departamentos' => $os->departamento_id ?? null,
            'cad_equipes' => $os->equipe_id ?? null,
            'cad_categorias' => $os->categoria_id ?? null,
            'cad_subcategorias' => $os->subcategoria_id ?? null,
            'cad_slas' => $os->sla_id ?? null,
        ];
        $buscar = function ($tabela, $campos, $ordem = 'nome') use ($usados) {
            $this->db->select($campos)->from($tabela);
            $this->db->group_start()->where('ativo', 1);
            if ($usados[$tabela]) {
                $this->db->or_where('id', (int) $usados[$tabela]);
            }
            $this->db->group_end()->order_by($ordem, 'ASC');

            return $this->db->get()->result();
        };

        return [
            'departamentos' => $buscar('cad_departamentos', 'id, nome, sla_id'),
            'equipes' => $buscar('cad_equipes', 'id, nome, departamento_id'),
            'categorias' => $buscar('cad_categorias', 'id, nome, sla_id, departamento_id'),
            'subcategorias' => $buscar('cad_subcategorias', 'id, nome, categoria_id, sla_id'),
            'slas' => $buscar('cad_slas', 'id, nome, cor, prioridade, tempo_solucao, horario_comercial', 'prioridade'),
        ];
    }

    /**
     * Lê e valida (contra as opções existentes) os campos de atendimento do POST.
     */
    public function dadosAtendimentoDoPost($os = null): array
    {
        $op = $this->opcoesAtendimento($os);
        $valido = function ($campo, $lista) {
            $v = (int) $this->input->post($campo);
            foreach ($lista as $item) {
                if ((int) $item->id === $v) {
                    return $v;
                }
            }

            return null;
        };

        return [
            'departamento_id' => $valido('departamento_id', $op['departamentos']),
            'equipe_id' => $valido('equipe_id', $op['equipes']),
            'categoria_id' => $valido('categoria_id', $op['categorias']),
            'subcategoria_id' => $valido('subcategoria_id', $op['subcategorias']),
            'sla_id' => $valido('sla_id', $op['slas']),
        ];
    }

    public function getById($id)
    {
        $this->db->select('os.*, clientes.*, clientes.celular as celular_cliente, clientes.telefone as telefone_cliente, clientes.contato as contato_cliente, garantias.refGarantia, garantias.textoGarantia, usuarios.telefone as telefone_usuario, usuarios.email as email_usuario, usuarios.nome');
        $this->db->select('cdep.nome as departamento_nome, ceq.nome as equipe_nome, ccat.nome as categoria_nome, csub.nome as subcategoria_nome, csla.nome as sla_nome, csla.cor as sla_cor, csla.tempo_solucao as sla_horas');
        $this->db->from('os');
        $this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
        $this->db->join('usuarios', 'usuarios.idUsuarios = os.usuarios_id', 'left');
        $this->db->join('garantias', 'garantias.idGarantias = os.garantias_id', 'left');
        $this->db->join('cad_departamentos cdep', 'cdep.id = os.departamento_id', 'left');
        $this->db->join('cad_equipes ceq', 'ceq.id = os.equipe_id', 'left');
        $this->db->join('cad_categorias ccat', 'ccat.id = os.categoria_id', 'left');
        $this->db->join('cad_subcategorias csub', 'csub.id = os.subcategoria_id', 'left');
        $this->db->join('cad_slas csla', 'csla.id = os.sla_id', 'left');
        $this->db->where('os.idOs', $id);
        $this->db->limit(1);

        return $this->db->get()->row();
    }

    public function getByIdCobrancas($id)
    {
        $this->db->select('os.*, clientes.*, clientes.celular as celular_cliente, garantias.refGarantia, garantias.textoGarantia, usuarios.telefone as telefone_usuario, usuarios.email as email_usuario, usuarios.nome,cobrancas.os_id,cobrancas.idCobranca,cobrancas.status');
        $this->db->from('os');
        $this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
        $this->db->join('usuarios', 'usuarios.idUsuarios = os.usuarios_id', 'left');
        $this->db->join('cobrancas', 'cobrancas.os_id = os.idOs');
        $this->db->join('garantias', 'garantias.idGarantias = os.garantias_id', 'left');
        $this->db->where('os.idOs', $id);
        $this->db->limit(1);

        return $this->db->get()->row();
    }

    public function getProdutos($id = null)
    {
        $this->db->select('produtos_os.*, produtos.*');
        $this->db->from('produtos_os');
        $this->db->join('produtos', 'produtos.idProdutos = produtos_os.produtos_id');
        $this->db->where('os_id', $id);

        return $this->db->get()->result();
    }

    public function getServicos($id = null)
    {
        $this->db->select('servicos_os.*, servicos.nome, servicos.preco as precoVenda');
        $this->db->from('servicos_os');
        $this->db->join('servicos', 'servicos.idServicos = servicos_os.servicos_id');
        $this->db->where('os_id', $id);

        return $this->db->get()->result();
    }

    public function add($table, $data, $returnId = false)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1') {
            if ($returnId == true) {
                return $this->db->insert_id($table);
            }

            return true;
        }

        return false;
    }

    public function edit($table, $data, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0) {
            return true;
        }

        return false;
    }

    public function delete($table, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1') {
            return true;
        }

        return false;
    }

    public function count($table)
    {
        return $this->db->count_all($table);
    }

    public function autoCompleteProduto($q)
    {
        $this->db->select('*');
        $this->db->limit(25);
        $this->db->like('codDeBarra', $q);
        $this->db->or_like('descricao', $q);
        $query = $this->db->get('produtos');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = ['label' => $row['descricao'] . ' | Preço: R$ ' . $row['precoVenda'] . ' | Estoque: ' . $row['estoque'], 'estoque' => $row['estoque'], 'id' => $row['idProdutos'], 'preco' => $row['precoVenda']];
            }
            echo json_encode($row_set);
        }
    }

    public function autoCompleteProdutoSaida($q)
    {
        $this->db->select('*');
        $this->db->limit(25);
        $this->db->like('codDeBarra', $q);
        $this->db->or_like('descricao', $q);
        $this->db->where('saida', 1);
        $query = $this->db->get('produtos');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = ['label' => $row['descricao'] . ' | Preço: R$ ' . $row['precoVenda'] . ' | Estoque: ' . $row['estoque'], 'estoque' => $row['estoque'], 'id' => $row['idProdutos'], 'preco' => $row['precoVenda']];
            }
            echo json_encode($row_set);
        }
    }

    public function autoCompleteCliente($q)
    {
        $this->db->select('*');
        $this->db->limit(25);
        $this->db->like('nomeCliente', $q);
        $this->db->or_like('telefone', $q);
        $this->db->or_like('celular', $q);
        $this->db->or_like('documento', $q);
        $query = $this->db->get('clientes');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = ['label' => $row['nomeCliente'] . ' | Telefone: ' . $row['telefone'] . ' | Celular: ' . $row['celular'] . ' | Documento: ' . $row['documento'], 'id' => $row['idClientes']];
            }
            echo json_encode($row_set);
        }
    }

    public function autoCompleteUsuario($q)
    {
        $this->db->select('*');
        $this->db->limit(25);
        $this->db->like('nome', $q);
        $this->db->where('situacao', 1);
        $query = $this->db->get('usuarios');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = ['label' => $row['nome'] . ' | Telefone: ' . $row['telefone'], 'id' => $row['idUsuarios']];
            }
            echo json_encode($row_set);
        }
    }

    public function autoCompleteTermoGarantia($q)
    {
        $this->db->select('*');
        $this->db->limit(25);
        $this->db->like('LOWER(refGarantia)', $q);
        $query = $this->db->get('garantias');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = ['label' => $row['refGarantia'], 'id' => $row['idGarantias']];
            }
            echo json_encode($row_set);
        }
    }

    public function autoCompleteServico($q)
    {
        $this->db->select('*');
        $this->db->limit(25);
        $this->db->like('nome', $q);
        $query = $this->db->get('servicos');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = ['label' => $row['nome'] . ' | Preço: R$ ' . $row['preco'], 'id' => $row['idServicos'], 'preco' => $row['preco']];
            }
            echo json_encode($row_set);
        }
    }

    public function checkAnexosExpirationColumns()
    {
        try {
            if (!$this->db->field_exists('data_expiracao', 'anexos')) {
                $this->db->query("ALTER TABLE `anexos` ADD COLUMN `data_cadastro` DATETIME DEFAULT CURRENT_TIMESTAMP, ADD COLUMN `data_expiracao` DATETIME NULL, ADD COLUMN `tipo` VARCHAR(20) DEFAULT 'foto', ADD INDEX `idx_anexos_expiracao` (`data_expiracao`)");
                $this->db->query("UPDATE `anexos` SET `data_cadastro` = NOW(), `data_expiracao` = DATE_ADD(NOW(), INTERVAL 5 YEAR) WHERE `data_expiracao` IS NULL");
            }
        } catch (\Throwable $e) {
            // Silencia em ambientes onde o usuário do banco não possui permissão DDL
        }
    }

    public function anexar($os, $anexo, $url, $thumb, $path, $tipo = 'foto', $dataCadastro = null, $dataExpiracao = null)
    {
        $this->checkAnexosExpirationColumns();

        $dataCadastro = $dataCadastro ?? date('Y-m-d H:i:s');
        // Política de Retenção: 5 anos de validade
        $dataExpiracao = $dataExpiracao ?? date('Y-m-d H:i:s', strtotime('+5 years', strtotime($dataCadastro)));

        $this->db->set('anexo', $anexo);
        $this->db->set('url', $url);
        $this->db->set('thumb', $thumb);
        $this->db->set('path', $path);
        $this->db->set('os_id', $os);
        if ($this->db->field_exists('tipo', 'anexos')) {
            $this->db->set('tipo', $tipo);
        }
        if ($this->db->field_exists('data_cadastro', 'anexos')) {
            $this->db->set('data_cadastro', $dataCadastro);
        }
        if ($this->db->field_exists('data_expiracao', 'anexos')) {
            $this->db->set('data_expiracao', $dataExpiracao);
        }

        return $this->db->insert('anexos');
    }

    public function limparFotosExpiradas()
    {
        $this->checkAnexosExpirationColumns();

        if (!$this->db->field_exists('data_expiracao', 'anexos')) {
            return 0;
        }

        // Busca fotos cuja data de expiração atingiu ou passou de 5 anos
        $this->db->where('data_expiracao IS NOT NULL');
        $this->db->where('data_expiracao <=', date('Y-m-d H:i:s'));
        $expirados = $this->db->get('anexos')->result();

        $totalExcluidos = 0;
        if (!empty($expirados)) {
            foreach ($expirados as $file) {
                // Remove arquivo principal do disco
                if (!empty($file->path) && !empty($file->anexo)) {
                    $arquivoPrincipal = $file->path . DIRECTORY_SEPARATOR . $file->anexo;
                    if (file_exists($arquivoPrincipal)) {
                        @unlink($arquivoPrincipal);
                    }
                }

                // Remove miniatura/thumb do disco
                if (!empty($file->path) && !empty($file->thumb)) {
                    $arquivoThumb = $file->path . DIRECTORY_SEPARATOR . 'thumbs' . DIRECTORY_SEPARATOR . $file->thumb;
                    if (file_exists($arquivoThumb)) {
                        @unlink($arquivoThumb);
                    }
                }

                // Remove o registro do banco de dados
                $this->db->where('idAnexos', $file->idAnexos);
                $this->db->delete('anexos');
                $totalExcluidos++;
            }

            if ($totalExcluidos > 0) {
                log_info("Auto-exclusão de fotos de OS: {$totalExcluidos} foto(s) com mais de 5 anos removida(s) automaticamente do banco e do disco.");
            }
        }

        return $totalExcluidos;
    }

    public function getAnexos($os)
    {
        $this->db->where('os_id', $os);

        return $this->db->get('anexos')->result();
    }

    public function getFotosOs($os)
    {
        $this->checkAnexosExpirationColumns();
        $this->db->where('os_id', $os);
        $this->db->order_by('idAnexos', 'desc');

        return $this->db->get('anexos')->result();
    }

    public function getAnotacoes($os)
    {
        $this->db->where('os_id', $os);
        $this->db->order_by('idAnotacoes', 'desc');

        return $this->db->get('anotacoes_os')->result();
    }

    /**
     * Itens de checklist de uma OS, mais antigos primeiro (ordem de criação).
     */
    public function getChecklist($os)
    {
        $this->db->where('os_id', $os);
        $this->db->order_by('idChecklist', 'asc');

        return $this->db->get('checklist_os')->result();
    }

    public function getCobrancas($id = null)
    {
        $this->db->select('cobrancas.*');
        $this->db->from('cobrancas');
        $this->db->where('os_id', $id);

        return $this->db->get()->result();
    }

    public function criarTextoWhats($textoBase, $troca)
    {
        $procura = ['{CLIENTE_NOME}', '{NUMERO_OS}', '{STATUS_OS}', '{VALOR_OS}', '{DESCRI_PRODUTOS}', '{EMITENTE}', '{TELEFONE_EMITENTE}', '{OBS_OS}', '{DEFEITO_OS}', '{LAUDO_OS}', '{DATA_FINAL}', '{DATA_INICIAL}', '{DATA_GARANTIA}'];
        $textoBase = str_replace($procura, $troca, $textoBase);
        $textoBase = strip_tags($textoBase);
        $textoBase = htmlentities(urlencode($textoBase));

        return $textoBase;
    }

    public function valorTotalOS($id = null)
    {
        $totalServico = 0;
        $totalProdutos = 0;
        $valorDesconto = 0;
        if ($servicos = $this->getServicos($id)) {
            foreach ($servicos as $s) {
                $preco = $s->preco ?: $s->precoVenda;
                $totalServico = $totalServico + ($preco * ($s->quantidade ?: 1));
            }
        }
        if ($produtos = $this->getProdutos($id)) {
            foreach ($produtos as $p) {
                $totalProdutos = $totalProdutos + $p->subTotal;
            }
        }
        if ($valorDescontoBD = $this->getById($id)) {
            $valorDesconto = $valorDescontoBD->valor_desconto;
        }

        return ['totalServico' => $totalServico, 'totalProdutos' => $totalProdutos, 'valor_desconto' => $valorDesconto];
    }

    public function isEditable($id = null)
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
            return false;
        }
        if ($os = $this->getById($id)) {
            $osT = (int) ($os->status === 'Faturado' || $os->status === 'Cancelado' || $os->faturado == 1);
            if ($osT) {
                return $this->data['configuration']['control_editos'] == '1';
            }
        }

        return true;
    }

    public function getQrCode($id, $pixKey, $emitente)
    {
        if (empty($id) || empty($pixKey) || empty($emitente)) {
            return;
        }

        $result = $this->valorTotalOS($id);
        $amount = $result['valor_desconto'] != 0 ? round(floatval($result['valor_desconto']), 2) : round(floatval($result['totalServico'] + $result['totalProdutos']), 2);

        if ($amount <= 0) {
            return;
        }

        $pix = (new StaticPayload())
            ->setAmount($amount)
            ->setTid($id)
            ->setDescription(sprintf('%s OS %s', substr($emitente->nome, 0, 18), $id), true)
            ->setPixKey(getPixKeyType($pixKey), $pixKey)
            ->setMerchantName($emitente->nome)
            ->setMerchantCity($emitente->cidade);

        return $pix->getQRCode();
    }
}
