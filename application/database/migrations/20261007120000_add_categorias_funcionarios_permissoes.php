<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_add_categorias_funcionarios_permissoes extends CI_Migration
{
    public function up()
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
            $check = $this->db->get_where('permissoes', ['nome' => $cat])->row();
            if (!$check) {
                $this->db->insert('permissoes', [
                    'nome' => $cat,
                    'permissoes' => $defaultPerms,
                    'situacao' => 1,
                    'data' => date('Y-m-d'),
                ]);
            }
        }
    }

    public function down()
    {
        // No destruct needed
    }
}
