<?php

class Permissoes_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array')
    {
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idPermissao', 'desc');
        $this->db->limit($perpage, $start);
        if ($where) {
            $this->db->where($where);
        }

        $query = $this->db->get();

        $result = ! $one ? $query->result() : $query->row();

        return $result;
    }

    public function ensureDefaultCategorias()
    {
        $defaultCategorias = [
            'Administrador',
            'Suporte',
            'Secretária',
            'Menor Aprendiz',
            'Contribuinte Individual / Terceirizado (PJ)',
            'Trabalhador Intermitente',
            'Trabalhador Temporário',
            'Empregado Geral (CLT)',
            'Desenvolvedor',
        ];

        $defaultPerms = 'a:53:{s:8:"aCliente";s:1:"1";s:8:"eCliente";s:1:"1";s:8:"dCliente";s:1:"1";s:8:"vCliente";s:1:"1";s:8:"aProduto";s:1:"1";s:8:"eProduto";s:1:"1";s:8:"dProduto";s:1:"1";s:8:"vProduto";s:1:"1";s:8:"aServico";s:1:"1";s:8:"eServico";s:1:"1";s:8:"dServico";s:1:"1";s:8:"vServico";s:1:"1";s:3:"aOs";s:1:"1";s:3:"eOs";s:1:"1";s:3:"dOs";s:1:"1";s:3:"vOs";s:1:"1";s:6:"aVenda";s:1:"1";s:6:"eVenda";s:1:"1";s:6:"dVenda";s:1:"1";s:6:"vVenda";s:1:"1";s:9:"aGarantia";s:1:"1";s:9:"eGarantia";s:1:"1";s:9:"dGarantia";s:1:"1";s:9:"vGarantia";s:1:"1";s:8:"aArquivo";s:1:"1";s:8:"eArquivo";s:1:"1";s:8:"dArquivo";s:1:"1";s:8:"vArquivo";s:1:"1";s:10:"aPagamento";s:1:"1";s:10:"ePagamento";s:1:"1";s:10:"dPagamento";s:1:"1";s:10:"vPagamento";s:1:"1";s:11:"aLancamento";s:1:"1";s:11:"eLancamento";s:1:"1";s:11:"dLancamento";s:1:"1";s:11:"vLancamento";s:1:"1";s:8:"cUsuario";s:1:"1";s:9:"cEmitente";s:1:"1";s:10:"cPermissao";s:1:"1";s:7:"cBackup";s:1:"1";s:10:"cAuditoria";s:1:"1";s:6:"cEmail";s:1:"1";s:8:"cSistema";s:1:"1";s:8:"rCliente";s:1:"1";s:8:"rProduto";s:1:"1";s:8:"rServico";s:1:"1";s:3:"rOs";s:1:"1";s:6:"rVenda";s:1:"1";s:11:"rFinanceiro";s:1:"1";s:9:"aCobranca";s:1:"1";s:9:"eCobranca";s:1:"1";s:9:"dCobranca";s:1:"1";s:9:"vCobranca";s:1:"1";}';

        foreach ($defaultCategorias as $cat) {
            $check = $this->db->where('LOWER(TRIM(nome))', strtolower(trim($cat)))->get('permissoes')->row();
            if (! $check) {
                $this->db->insert('permissoes', [
                    'nome' => $cat,
                    'permissoes' => $defaultPerms,
                    'situacao' => 1,
                    'data' => date('Y-m-d'),
                ]);
            }
        }
    }

    public function getActive($table, $fields)
    {
        $this->ensureDefaultCategorias();
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->where('situacao', 1);
        $this->db->order_by('idPermissao', 'asc');
        $query = $this->db->get();
        $rows = $query->result();

        // Deduplicar garantindo unicidade estrita por nome de permissão no dropdown
        $seen = [];
        $unique = [];
        foreach ($rows as $r) {
            $normNome = mb_strtolower(trim((string)$r->nome));
            if (!isset($seen[$normNome])) {
                $seen[$normNome] = true;
                $unique[] = $r;
            }
        }

        return $unique;
    }

    public function getById($id)
    {
        $this->db->where('idPermissao', $id);
        $this->db->limit(1);

        return $this->db->get('permissoes')->row();
    }

    public function add($table, $data)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1') {
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
}

/* End of file permissoes_model.php */
/* Location: ./application/models/permissoes_model.php */
