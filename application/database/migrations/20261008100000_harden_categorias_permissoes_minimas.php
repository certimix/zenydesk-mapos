<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_harden_categorias_permissoes_minimas extends CI_Migration
{
    private function serializePerms(array $activeKeys): string
    {
        $allKeys = [
            'aCliente', 'eCliente', 'dCliente', 'vCliente',
            'aProduto', 'eProduto', 'dProduto', 'vProduto',
            'aServico', 'eServico', 'dServico', 'vServico',
            'aOs', 'eOs', 'dOs', 'vOs',
            'aVenda', 'eVenda', 'dVenda', 'vVenda',
            'aGarantia', 'eGarantia', 'dGarantia', 'vGarantia',
            'aArquivo', 'eArquivo', 'dArquivo', 'vArquivo',
            'aPagamento', 'ePagamento', 'dPagamento', 'vPagamento',
            'aLancamento', 'eLancamento', 'dLancamento', 'vLancamento',
            'cUsuario', 'cEmitente', 'cPermissao', 'cBackup', 'cAuditoria', 'cEmail', 'cSistema',
            'rCliente', 'rProduto', 'rServico', 'rOs', 'rVenda', 'rFinanceiro',
            'aCobranca', 'eCobranca', 'dCobranca', 'vCobranca',
        ];

        $data = [];
        foreach ($allKeys as $k) {
            $data[$k] = in_array($k, $activeKeys, true) ? '1' : '0';
        }

        return serialize($data);
    }

    public function up()
    {
        $roles = [
            'Suporte' => [
                'vCliente', 'aCliente', 'eCliente',
                'vOs', 'aOs', 'eOs',
                'vServico', 'vProduto', 'vGarantia',
                'vArquivo', 'aArquivo',
                'vCobranca',
                'rOs',
            ],
            'Secretária' => [
                'vCliente', 'aCliente', 'eCliente',
                'vOs', 'aOs', 'eOs',
                'vVenda', 'aVenda',
                'vGarantia',
                'vArquivo', 'aArquivo',
                'vPagamento', 'aPagamento',
                'vLancamento', 'aLancamento',
                'vCobranca', 'aCobranca',
                'rCliente', 'rOs', 'rVenda',
            ],
            'Menor Aprendiz' => [
                'vCliente', 'vProduto', 'vServico',
                'vOs', 'vGarantia', 'vArquivo',
            ],
            'Contribuinte Individual / Terceirizado (PJ)' => [
                'vOs', 'eOs',
                'vServico', 'vProduto',
                'vArquivo', 'aArquivo',
            ],
            'Trabalhador Intermitente' => [
                'vOs', 'eOs',
                'vServico', 'vProduto',
                'vArquivo', 'aArquivo',
            ],
            'Trabalhador Temporário' => [
                'vOs', 'eOs',
                'vServico', 'vProduto',
                'vArquivo', 'aArquivo',
            ],
            'Empregado Geral (CLT)' => [
                'vCliente', 'aCliente',
                'vOs', 'aOs', 'eOs',
                'vServico', 'vProduto', 'vGarantia',
                'vArquivo', 'aArquivo',
            ],
            'Desenvolvedor' => [
                'vCliente', 'aCliente', 'eCliente',
                'vProduto', 'aProduto', 'eProduto',
                'vServico', 'aServico', 'eServico',
                'vOs', 'aOs', 'eOs',
                'vGarantia', 'aGarantia', 'eGarantia',
                'vArquivo', 'aArquivo', 'eArquivo',
                'rCliente', 'rProduto', 'rServico', 'rOs',
            ],
        ];

        foreach ($roles as $roleName => $allowedKeys) {
            $serialized = $this->serializePerms($allowedKeys);
            $this->db->where('nome', $roleName)->update('permissoes', [
                'permissoes' => $serialized,
            ]);
        }
    }

    public function down()
    {
        // Reversao nao necessaria; mantem estado seguro por padrao
    }
}
