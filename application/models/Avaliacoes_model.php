<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Avaliações de atendimento: cada OS tem no máximo um link (token) que o
 * cliente usa para dar nota de 1 a 5 e um comentário.
 */
class Avaliacoes_model extends CI_Model
{
    public function porOs(int $osId)
    {
        return $this->db->where('os_id', $osId)->get('os_avaliacoes')->row();
    }

    public function porToken(string $token)
    {
        if (! preg_match('/^[a-f0-9]{40}$/', $token)) {
            return null;
        }
        $this->db->select('a.*, os.idOs, os.status, os.dataFinal, os.descricaoProduto, c.nomeCliente, u.nome AS tecnico');
        $this->db->from('os_avaliacoes a');
        $this->db->join('os', 'os.idOs = a.os_id');
        $this->db->join('clientes c', 'c.idClientes = os.clientes_id');
        $this->db->join('usuarios u', 'u.idUsuarios = os.usuarios_id', 'left');
        $this->db->where('a.token', $token);

        return $this->db->get()->row();
    }

    /** Cria o link de avaliação da OS (se ainda não existir) e devolve o registro. */
    public function garantirLink(int $osId)
    {
        $existente = $this->porOs($osId);
        if ($existente) {
            return $existente;
        }
        $this->db->insert('os_avaliacoes', [
            'os_id' => $osId,
            'token' => bin2hex(random_bytes(20)),
            'criado_em' => date('Y-m-d H:i:s'),
        ]);

        return $this->porOs($osId);
    }

    public function responder(int $id, int $nota, string $comentario, string $ip): bool
    {
        $this->db->where('id', $id)->where('respondido_em IS NULL', null, false)->update('os_avaliacoes', [
            'nota' => $nota,
            'comentario' => $comentario !== '' ? $comentario : null,
            'respondido_em' => date('Y-m-d H:i:s'),
            'ip' => $ip,
        ]);

        return $this->db->affected_rows() === 1;
    }

    private function filtros(array $f)
    {
        if (! empty($f['de'])) {
            $this->db->where('a.respondido_em >=', $f['de'] . ' 00:00:00');
        }
        if (! empty($f['ate'])) {
            $this->db->where('a.respondido_em <=', $f['ate'] . ' 23:59:59');
        }
        if (! empty($f['tecnico'])) {
            $this->db->where('os.usuarios_id', (int) $f['tecnico']);
        }
        if (! empty($f['nota'])) {
            $this->db->where('a.nota', (int) $f['nota']);
        }
    }

    public function listar(array $f, int $limite, int $offset): array
    {
        $this->db->select('a.*, os.idOs, os.status, c.nomeCliente, u.nome AS tecnico');
        $this->db->from('os_avaliacoes a');
        $this->db->join('os', 'os.idOs = a.os_id');
        $this->db->join('clientes c', 'c.idClientes = os.clientes_id');
        $this->db->join('usuarios u', 'u.idUsuarios = os.usuarios_id', 'left');
        $this->db->where('a.respondido_em IS NOT NULL', null, false);
        $this->filtros($f);
        $this->db->order_by('a.respondido_em', 'DESC');
        $this->db->limit($limite, $offset);

        return $this->db->get()->result();
    }

    public function contar(array $f): int
    {
        $this->db->from('os_avaliacoes a');
        $this->db->join('os', 'os.idOs = a.os_id');
        $this->db->where('a.respondido_em IS NOT NULL', null, false);
        $this->filtros($f);

        return (int) $this->db->count_all_results();
    }

    /** Média, total, distribuição 1..5 e pendentes, respeitando os filtros. */
    public function resumo(array $f): array
    {
        $this->db->select('a.nota, COUNT(*) AS qtd');
        $this->db->from('os_avaliacoes a');
        $this->db->join('os', 'os.idOs = a.os_id');
        $this->db->where('a.respondido_em IS NOT NULL', null, false);
        $this->filtros($f);
        $this->db->group_by('a.nota');

        $dist = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        $total = 0;
        $soma = 0;
        foreach ($this->db->get()->result() as $r) {
            $dist[(int) $r->nota] = (int) $r->qtd;
            $total += (int) $r->qtd;
            $soma += (int) $r->nota * (int) $r->qtd;
        }

        $pendentes = (int) $this->db->where('respondido_em IS NULL', null, false)->count_all_results('os_avaliacoes');

        return [
            'total' => $total,
            'media' => $total ? round($soma / $total, 1) : null,
            'satisfeitos' => $total ? (int) round(($dist[4] + $dist[5]) * 100 / $total) : null,
            'distribuicao' => $dist,
            'pendentes' => $pendentes,
        ];
    }

    public function tecnicos(): array
    {
        return $this->db->select('idUsuarios, nome')->where('situacao', 1)->order_by('nome')->get('usuarios')->result();
    }
}
