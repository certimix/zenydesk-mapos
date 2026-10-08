<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Cadastros auxiliares no estilo do SNDesk (Departamentos, Equipes, SLAs...).
 *
 * Um só controller atende todos os cadastros definidos em
 * application/config/cadastros.php:
 *
 *   /cadastros                         → índice com todos os cadastros
 *   /cadastros/<chave>                 → lista (com ?pesquisa= e paginação)
 *   /cadastros/<chave>/adicionar       → formulário de inclusão
 *   /cadastros/<chave>/editar/<id>     → formulário de edição
 *   /cadastros/<chave>/excluir         → POST id
 *
 * Permissões: vCadastro, aCadastro, eCadastro, dCadastro
 * (Perfis de Acesso > grupo "Cadastros").
 */
class Cadastros extends MY_Controller
{
    private $entidades = [];

    public function __construct()
    {
        parent::__construct();
        $this->config->load('cadastros', true);
        $this->entidades = $this->config->item('cadastros_entidades', 'cadastros');
        $this->load->model('cadastros_model');
        $this->data['menuCadastros'] = true;
    }

    public function _remap($chave, $params = [])
    {
        if (! $this->pode('vCadastro')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar cadastros.');
            redirect(base_url());
        }

        if ($chave === 'index') {
            return $this->indice();
        }

        if (! isset($this->entidades[$chave])) {
            show_404();
        }

        $acao = $params[0] ?? 'listar';
        $id = isset($params[1]) ? (int) $params[1] : 0;

        switch ($acao) {
            case 'listar':
                return $this->listar($chave);
            case 'adicionar':
                return $this->formulario($chave, 0);
            case 'editar':
                return $id > 0 ? $this->formulario($chave, $id) : show_404();
            case 'excluir':
                return $this->excluir($chave);
            case 'alternar':
                return $this->alternarAtivo($chave);
            default:
                // /cadastros/<chave>/<offset> vindo da paginação
                return ctype_digit((string) $acao) ? $this->listar($chave, (int) $acao) : show_404();
        }
    }

    private function pode(string $flag): bool
    {
        return $this->permission->checkPermission($this->session->userdata('permissao'), $flag);
    }

    private function indice()
    {
        $this->data['entidades'] = $this->entidades;
        $this->data['view'] = 'cadastros/indice';

        return $this->layout();
    }

    private function listar(string $chave, int $offset = 0)
    {
        $ent = $this->entidades[$chave];
        $busca = (string) $this->input->get('pesquisa', true);

        $this->load->library('pagination');
        $cfg = $this->data['configuration'];
        $cfg['base_url'] = site_url("cadastros/{$chave}");
        $cfg['total_rows'] = $this->cadastros_model->contar($ent, $busca);
        $cfg['uri_segment'] = 3;
        $cfg['reuse_query_string'] = true;
        $this->pagination->initialize($cfg);

        $this->data['chave'] = $chave;
        $this->data['ent'] = $ent;
        $this->data['busca'] = $busca;
        $this->data['total'] = $cfg['total_rows'];
        $this->data['results'] = $this->cadastros_model->listar($ent, $busca, (int) $cfg['per_page'], $offset);
        $this->data['podeAdicionar'] = $this->pode('aCadastro');
        $this->data['podeEditar'] = $this->pode('eCadastro');
        $this->data['podeExcluir'] = $this->pode('dCadastro');
        $this->data['view'] = 'cadastros/listar';

        return $this->layout();
    }

    private function formulario(string $chave, int $id)
    {
        $ent = $this->entidades[$chave];
        $flag = $id ? 'eCadastro' : 'aCadastro';
        if (! $this->pode($flag)) {
            $this->session->set_flashdata('error', 'Você não tem permissão para ' . ($id ? 'editar' : 'adicionar') . ' cadastros.');
            redirect(site_url("cadastros/{$chave}"));
        }

        $registro = null;
        if ($id) {
            $registro = $this->cadastros_model->obter($ent, $id);
            if (! $registro) {
                $this->session->set_flashdata('error', 'Registro não encontrado.');
                redirect(site_url("cadastros/{$chave}"));
            }
        }

        $erros = [];
        $valores = $this->valoresIniciais($ent, $registro);

        if ($this->input->method() === 'post') {
            [$dados, $erros, $valores] = $this->validar($ent, $id);

            if (! $erros) {
                if ($id) {
                    $ok = $this->cadastros_model->atualizar($ent, $id, $dados);
                    $msg = "{$ent['singular']} atualizado(a) com sucesso!";
                    log_info("Editou {$ent['singular']} #{$id}");
                } else {
                    $ok = (bool) $this->cadastros_model->inserir($ent, $dados);
                    $msg = "{$ent['singular']} adicionado(a) com sucesso!";
                    log_info("Adicionou {$ent['singular']}");
                }

                if ($ok) {
                    $this->session->set_flashdata('success', $msg);
                    redirect(site_url("cadastros/{$chave}"));
                }
                $erros[] = 'Ocorreu um erro ao salvar. Tente novamente.';
            }
        }

        $opcoesRelacao = [];
        foreach ($ent['campos'] as $nome => $campo) {
            if ($campo['tipo'] === 'relacao') {
                $opcoesRelacao[$nome] = $this->cadastros_model->opcoesRelacao($campo);
            }
        }

        $this->data['chave'] = $chave;
        $this->data['ent'] = $ent;
        $this->data['id'] = $id;
        $this->data['valores'] = $valores;
        $this->data['erros'] = $erros;
        $this->data['opcoesRelacao'] = $opcoesRelacao;
        $this->data['view'] = 'cadastros/form';

        return $this->layout();
    }

    private function excluir(string $chave)
    {
        $ent = $this->entidades[$chave];
        if (! $this->pode('dCadastro')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir cadastros.');
            redirect(site_url("cadastros/{$chave}"));
        }
        if ($this->input->method() !== 'post') {
            redirect(site_url("cadastros/{$chave}"));
        }

        $id = (int) $this->input->post('id');
        if ($id <= 0 || ! $this->cadastros_model->obter($ent, $id)) {
            $this->session->set_flashdata('error', 'Registro não encontrado.');
            redirect(site_url("cadastros/{$chave}"));
        }

        $resultado = $this->cadastros_model->excluir($ent, $id);
        if ($resultado === true) {
            log_info("Excluiu {$ent['singular']} #{$id}");
            $this->session->set_flashdata('success', "{$ent['singular']} excluído(a) com sucesso!");
        } else {
            $this->session->set_flashdata('error', $resultado);
        }

        redirect(site_url("cadastros/{$chave}"));
    }

    /**
     * Chave liga/desliga da coluna "Ativo" na lista (AJAX, POST id).
     */
    private function alternarAtivo(string $chave)
    {
        $ent = $this->entidades[$chave];
        $responder = function ($ok, $extra = []) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['result' => $ok] + $extra));
        };

        if ($this->input->method() !== 'post' || ! isset($ent['campos']['ativo'])) {
            return $responder(false, ['mensagem' => 'Requisição inválida.']);
        }
        if (! $this->pode('eCadastro')) {
            return $responder(false, ['mensagem' => 'Você não tem permissão para editar cadastros.']);
        }

        $id = (int) $this->input->post('id');
        $registro = $id > 0 ? $this->cadastros_model->obter($ent, $id) : null;
        if (! $registro) {
            return $responder(false, ['mensagem' => 'Registro não encontrado.']);
        }

        $novo = $registro->ativo ? 0 : 1;
        $ok = $this->cadastros_model->atualizar($ent, $id, ['ativo' => $novo]);
        if ($ok) {
            log_info(($novo ? 'Ativou' : 'Desativou') . " {$ent['singular']} #{$id}");
        }

        return $responder($ok, ['ativo' => $novo]);
    }

    /**
     * Valores para o formulário: os do registro (edição) ou os padrões.
     */
    private function valoresIniciais(array $ent, $registro): array
    {
        $valores = [];
        foreach ($ent['campos'] as $nome => $campo) {
            if ($campo['tipo'] === 'senha') {
                $valores[$nome] = '';

                continue;
            }
            if ($registro) {
                $v = $registro->{$nome};
                if ($campo['tipo'] === 'datahora' && $v) {
                    $v = date('Y-m-d\TH:i', strtotime($v));
                }
                $valores[$nome] = $v;
            } else {
                $valores[$nome] = $campo['padrao'] ?? '';
            }
        }

        return $valores;
    }

    /**
     * Lê e valida o POST conforme a definição dos campos.
     *
     * @return array [dados para o banco, lista de erros, valores para reexibir]
     */
    private function validar(array $ent, int $id = 0): array
    {
        $dados = [];
        $erros = [];
        $valores = [];

        foreach ($ent['campos'] as $nome => $campo) {
            $rotulo = $campo['rotulo'];
            $obrigatorio = ! empty($campo['obrigatorio']);
            $bruto = $this->input->post($nome);
            $v = is_string($bruto) ? trim($bruto) : '';
            $valores[$nome] = $v;

            // Senha: guardada só como hash; em branco na edição = mantém a atual
            if ($campo['tipo'] === 'senha') {
                $valores[$nome] = '';
                $bruto = is_string($bruto) ? $bruto : '';
                if ($bruto === '') {
                    if (! $id && $obrigatorio) {
                        $erros[] = "O campo \"{$rotulo}\" é obrigatório.";
                    }

                    continue;
                }
                if (mb_strlen($bruto) < 6) {
                    $erros[] = "A senha precisa ter pelo menos 6 caracteres.";
                }
                $dados[$nome] = password_hash($bruto, PASSWORD_DEFAULT);

                continue;
            }

            if ($campo['tipo'] === 'booleano') {
                $dados[$nome] = $bruto ? 1 : 0;
                $valores[$nome] = $dados[$nome];

                continue;
            }

            if ($v === '') {
                if ($obrigatorio) {
                    $erros[] = "O campo \"{$rotulo}\" é obrigatório.";
                }
                $dados[$nome] = null;

                continue;
            }

            switch ($campo['tipo']) {
                case 'texto':
                case 'textarea':
                case 'telefone':
                    $max = $campo['max'] ?? ($campo['tipo'] === 'textarea' ? 5000 : 255);
                    if (mb_strlen($v) > $max) {
                        $erros[] = "O campo \"{$rotulo}\" aceita no máximo {$max} caracteres.";
                    }
                    $dados[$nome] = $v;

                    break;

                case 'email':
                    if (! filter_var($v, FILTER_VALIDATE_EMAIL)) {
                        $erros[] = "O campo \"{$rotulo}\" precisa ser um e-mail válido.";
                    }
                    $dados[$nome] = $v;

                    break;

                case 'numero':
                    if (! preg_match('/^\d{1,9}$/', $v)) {
                        $erros[] = "O campo \"{$rotulo}\" precisa ser um número inteiro (0 ou maior).";
                    }
                    $dados[$nome] = (int) $v;

                    break;

                case 'decimal':
                    // aceita 1234,56 / 1.234,56 / 1234.56
                    $n = str_replace(' ', '', $v);
                    if (preg_match('/^\d{1,3}(\.\d{3})*,\d{1,2}$|^\d+,\d{1,2}$/', $n)) {
                        $n = str_replace(['.', ','], ['', '.'], $n);
                    }
                    if (! preg_match('/^\d{1,8}(\.\d{1,2})?$/', $n)) {
                        $erros[] = "O campo \"{$rotulo}\" precisa ser um valor em reais (ex.: 150,00).";
                        $dados[$nome] = null;
                    } else {
                        $dados[$nome] = $n;
                        $valores[$nome] = $n;
                    }

                    break;

                case 'data':
                    $d = DateTime::createFromFormat('!Y-m-d', $v);
                    if (! $d || $d->format('Y-m-d') !== $v) {
                        $erros[] = "O campo \"{$rotulo}\" precisa ser uma data válida.";
                    }
                    $dados[$nome] = $v;

                    break;

                case 'datahora':
                    $d = DateTime::createFromFormat('!Y-m-d\TH:i', $v);
                    if (! $d || $d->format('Y-m-d\TH:i') !== $v) {
                        $erros[] = "O campo \"{$rotulo}\" precisa ser uma data e hora válidas.";
                        $dados[$nome] = null;
                    } else {
                        $dados[$nome] = $d->format('Y-m-d H:i:s');
                    }

                    break;

                case 'cor':
                    if (! preg_match('/^#[0-9a-fA-F]{6}$/', $v)) {
                        $erros[] = "O campo \"{$rotulo}\" precisa ser uma cor válida.";
                    }
                    $dados[$nome] = $v;

                    break;

                case 'opcoes':
                    if (! in_array($v, $campo['opcoes'], true)) {
                        $erros[] = "Escolha uma opção válida em \"{$rotulo}\".";
                    }
                    $dados[$nome] = $v;

                    break;

                case 'relacao':
                    $opcoes = $this->cadastros_model->opcoesRelacao($campo);
                    if (! ctype_digit($v) || ! array_key_exists((int) $v, $opcoes)) {
                        $erros[] = "Escolha uma opção válida em \"{$rotulo}\".";
                    }
                    $dados[$nome] = (int) $v;

                    break;

                default:
                    $dados[$nome] = $v;
            }
        }

        // Campos que não podem se repetir (ex.: e-mail de login)
        foreach ($ent['campos'] as $nome => $campo) {
            if (! empty($campo['unico']) && isset($dados[$nome]) && $dados[$nome] !== null
                && $this->cadastros_model->existeOutro($ent, $nome, $dados[$nome], $id)) {
                $erros[] = "Já existe um cadastro com este \"{$campo['rotulo']}\".";
            }
        }

        // Regras de "data final não pode ser antes da inicial".
        foreach ($ent['campos'] as $nome => $campo) {
            $ref = $campo['depois_de'] ?? null;
            if ($ref && ! empty($dados[$nome]) && ! empty($dados[$ref]) && $dados[$nome] < $dados[$ref]) {
                $erros[] = "\"{$campo['rotulo']}\" não pode ser antes de \"{$ent['campos'][$ref]['rotulo']}\".";
            }
        }

        return [$dados, $erros, $valores];
    }
}
