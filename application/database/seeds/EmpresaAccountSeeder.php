<?php

defined('BASEPATH') or exit('No direct script access allowed');

class EmpresaAccountSeeder
{
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->database();
    }

    public function run(array $params = [])
    {
        $nome = $params['nome'] ?? ($_ENV['APP_DEFAULT_EMITENTE_NOME'] ?? 'ZenyDesk OS');
        $cnpj = $params['cnpj'] ?? ($_ENV['APP_DEFAULT_EMITENTE_CNPJ'] ?? '');
        $email = $params['email'] ?? ($_ENV['APP_DEFAULT_EMITENTE_EMAIL'] ?? 'admin@zenydesk.com');

        if (empty($cnpj)) {
            echo "Seeder ignorado: CNPJ não informado." . PHP_EOL;
            return false;
        }

        $dataEmitente = [
            'nome' => $nome,
            'cnpj' => $cnpj,
            'ie' => $params['ie'] ?? ($_ENV['APP_DEFAULT_EMITENTE_IE'] ?? 'ISENTO'),
            'cep' => $params['cep'] ?? ($_ENV['APP_DEFAULT_EMITENTE_CEP'] ?? ''),
            'logradouro' => $params['logradouro'] ?? ($_ENV['APP_DEFAULT_EMITENTE_LOGRADOURO'] ?? ''),
            'numero' => $params['numero'] ?? ($_ENV['APP_DEFAULT_EMITENTE_NUMERO'] ?? ''),
            'bairro' => $params['bairro'] ?? ($_ENV['APP_DEFAULT_EMITENTE_BAIRRO'] ?? ''),
            'cidade' => $params['cidade'] ?? ($_ENV['APP_DEFAULT_EMITENTE_CIDADE'] ?? ''),
            'uf' => $params['uf'] ?? ($_ENV['APP_DEFAULT_EMITENTE_UF'] ?? ''),
            'telefone' => $params['telefone'] ?? ($_ENV['APP_DEFAULT_EMITENTE_TELEFONE'] ?? ''),
            'email' => $email,
        ];

        $emitente = $this->CI->db->get('emitente')->row();
        if ($emitente) {
            $this->CI->db->where('id', $emitente->id)->update('emitente', $dataEmitente);
        } else {
            $this->CI->db->insert('emitente', $dataEmitente);
        }

        $user = $this->CI->db->get_where('usuarios', ['cnpj' => $cnpj])->row();
        if ($user) {
            $this->CI->db->where('idUsuarios', $user->idUsuarios)->update('usuarios', [
                'nome' => $nome,
                'email' => $email,
                'permissoes_id' => 1,
                'situacao' => 1,
            ]);
        }

        echo "Seeder EmpresaAccountSeeder executado com sucesso." . PHP_EOL;
        return true;
    }
}
