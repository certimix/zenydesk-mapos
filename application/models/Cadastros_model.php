<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Acesso a dados genérico dos cadastros auxiliares definidos em
 * application/config/cadastros.php. Toda tabela/coluna usada aqui vem
 * dessa configuração (nunca da requisição), e todo valor vindo do usuário
 * passa pelo Query Builder, que escapa.
 */
class Cadastros_model extends CI_Model
{
    /**
     * Monta SELECT + JOINs das relações para a listagem.
     */
    private function montarConsulta(array $ent, string $busca = '')
    {
        $t = $ent['tabela'];
        $this->db->select("{$t}.*");
        $this->db->from($t);

        foreach ($ent['campos'] as $nome => $campo) {
            if ($campo['tipo'] !== 'relacao') {
                continue;
            }
            $alias = 'r_' . $nome;
            $this->db->select("{$alias}.{$campo['exibir']} AS {$nome}__exibir");
            $this->db->join("{$campo['tabela']} {$alias}", "{$alias}.{$campo['chave']} = {$t}.{$nome}", 'left');
        }

        $busca = trim($busca);
        if ($busca !== '') {
            $colunas = [];
            foreach ($ent['campos'] as $nome => $campo) {
                if (! empty($campo['busca'])) {
                    $colunas[] = "{$t}.{$nome}";
                }
            }
            if ($colunas) {
                $this->db->group_start();
                foreach ($colunas as $i => $col) {
                    $i === 0 ? $this->db->like($col, $busca) : $this->db->or_like($col, $busca);
                }
                $this->db->group_end();
            }
        }
    }

    public function listar(array $ent, string $busca, int $porPagina, int $offset)
    {
        if (! $this->db->table_exists($ent['tabela'])) {
            return [];
        }

        $this->montarConsulta($ent, $busca);
        $ordem = $ent['ordem'] ?? null;
        if ($ordem) {
            foreach (explode(',', $ordem) as $parte) {
                [$col, $dir] = array_pad(preg_split('/\s+/', trim($parte)), 2, 'ASC');
                $this->db->order_by($ent['tabela'] . '.' . $col, $dir);
            }
        } else {
            $this->db->order_by($ent['tabela'] . '.id', 'DESC');
        }
        $this->db->limit($porPagina, $offset);

        return $this->db->get()->result();
    }

    public function contar(array $ent, string $busca): int
    {
        if (! $this->db->table_exists($ent['tabela'])) {
            return 0;
        }

        $this->montarConsulta($ent, $busca);

        return (int) $this->db->count_all_results();
    }

    public function obter(array $ent, int $id)
    {
        if (! $this->db->table_exists($ent['tabela'])) {
            return null;
        }

        return $this->db->where('id', $id)->limit(1)->get($ent['tabela'])->row();
    }

    public function inserir(array $ent, array $dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $this->db->insert($ent['tabela'], $dados);

        return $this->db->affected_rows() === 1 ? $this->db->insert_id() : false;
    }

    public function atualizar(array $ent, int $id, array $dados): bool
    {
        $dados['atualizado_em'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id)->update($ent['tabela'], $dados);

        return $this->db->error()['code'] === 0;
    }

    /**
     * Retorna true, ou uma mensagem de erro amigável (ex.: registro em uso).
     */
    public function excluir(array $ent, int $id)
    {
        $debugAnterior = $this->db->db_debug;
        $this->db->db_debug = false;
        $this->db->where('id', $id)->delete($ent['tabela']);
        $erro = $this->db->error();
        $this->db->db_debug = $debugAnterior;

        if ($erro['code'] === 0) {
            return true;
        }
        if ((int) $erro['code'] === 1451) {
            return 'Este registro está sendo usado em outro cadastro e não pode ser excluído. Desative-o em vez de excluir.';
        }

        return 'Não foi possível excluir o registro.';
    }

    public function existeOutro(array $ent, string $coluna, $valor, int $id = 0): bool
    {
        $this->db->where($coluna, $valor);
        if ($id) {
            $this->db->where('id !=', $id);
        }

        return $this->db->count_all_results($ent['tabela']) > 0;
    }

    /**
     * Opções [chave => texto] para um campo do tipo relacao.
     */
    public function opcoesRelacao(array $campo): array
    {
        if (! $this->db->table_exists($campo['tabela'])) {
            return [];
        }

        $this->db->select("{$campo['chave']} AS k, {$campo['exibir']} AS v");
        foreach ($campo['filtro'] ?? [] as $col => $valor) {
            $this->db->where($col, $valor);
        }
        $this->db->order_by($campo['exibir'], 'ASC');
        $this->db->limit(2000);

        $opcoes = [];
        foreach ($this->db->get($campo['tabela'])->result() as $r) {
            $opcoes[$r->k] = $r->v;
        }

        return $opcoes;
    }

    /**
     * Eventos da agenda num intervalo (para o FullCalendar).
     */
    public function eventosAgenda(?string $inicio, ?string $fim): array
    {
        if (! $this->db->table_exists('cad_eventos')) {
            return [];
        }

        $this->db->select('e.*, u.nome AS responsavel, c.nomeCliente AS cliente');
        $this->db->from('cad_eventos e');
        $this->db->join('usuarios u', 'u.idUsuarios = e.usuario_id', 'left');
        $this->db->join('clientes c', 'c.idClientes = e.cliente_id', 'left');
        if ($inicio) {
            $this->db->where('COALESCE(e.data_fim, e.data_inicio) >=', $inicio);
        }
        if ($fim) {
            $this->db->where('e.data_inicio <=', $fim);
        }
        $this->db->limit(2000);

        return $this->db->get()->result();
    }

    public function feriadosAtivos(): array
    {
        if (! $this->db->table_exists('cad_feriados')) {
            return [];
        }

        return $this->db->where('ativo', 1)->get('cad_feriados')->result();
    }

    public function afastamentosPeriodo(?string $inicio, ?string $fim): array
    {
        if (! $this->db->table_exists('cad_afastamentos')) {
            return [];
        }

        $this->db->select('a.*, u.nome AS usuario');
        $this->db->from('cad_afastamentos a');
        $this->db->join('usuarios u', 'u.idUsuarios = a.usuario_id', 'left');
        if ($inicio) {
            $this->db->where('a.data_fim >=', substr($inicio, 0, 10));
        }
        if ($fim) {
            $this->db->where('a.data_inicio <=', substr($fim, 0, 10));
        }
        $this->db->limit(2000);

        return $this->db->get()->result();
    }
}
