<?php
/**
 * Lista genérica de um cadastro auxiliar (padrão SNDesk:
 * Editar | ID | colunas... | Ativo (chave liga/desliga) | Excluir).
 * Variáveis: $chave, $ent, $busca, $total, $results, $podeAdicionar, $podeEditar, $podeExcluir
 */
$temAtivo = isset($ent['campos']['ativo']) && ! empty($ent['campos']['ativo']['lista']);
$colunas = array_filter($ent['campos'], function ($c) {
    return ! empty($c['lista']);
});
unset($colunas['ativo']);
$temBusca = (bool) array_filter($ent['campos'], function ($c) {
    return ! empty($c['busca']);
});
$totalColunas = count($colunas) + 1 + ($podeEditar ? 1 : 0) + ($temAtivo ? 1 : 0) + ($podeExcluir ? 1 : 0);

$vazio = '<span class="cad-vazio">—</span>';
$formatar = function ($r, $nome, $campo) use ($vazio) {
    $v = $r->{$nome} ?? null;
    switch ($campo['tipo']) {
        case 'relacao':
            $txt = $r->{$nome . '__exibir'} ?? null;

            return $txt !== null ? html_escape($txt) : $vazio;
        case 'booleano':
            return $v ? '<span class="cad-sim"><i class="bx bx-check"></i> Sim</span>' : '<span class="cad-nao">Não</span>';
        case 'data':
            return $v ? date('d/m/Y', strtotime($v)) : $vazio;
        case 'datahora':
            return $v ? date('d/m/Y H:i', strtotime($v)) : $vazio;
        case 'decimal':
            return $v !== null && $v !== '' ? 'R$ ' . number_format((float) $v, 2, ',', '.') : $vazio;
        case 'cor':
            return $v ? '<span class="cad-cor" style="background:' . html_escape($v) . '" title="' . html_escape($v) . '"></span>' : $vazio;
        case 'textarea':
            if ($v === null || $v === '') {
                return $vazio;
            }

            return html_escape(mb_strlen($v) > 80 ? mb_substr($v, 0, 80) . '…' : $v);
        default:
            return ($v === null || $v === '') ? $vazio : html_escape($v);
    }
};
?>
<div class="cad-pagina new122">
    <div class="cad-cabecalho">
        <h1 class="cad-titulo"><?= html_escape($ent['titulo']) ?></h1>
        <a href="<?= site_url('cadastros') ?>" class="cad-voltar"><i class="bx bx-undo"></i> Voltar</a>
    </div>

    <div class="cad-corpo">
        <div class="cad-barra">
            <?php if ($temBusca) { ?>
                <form class="cad-busca" method="get" action="<?= site_url("cadastros/{$chave}") ?>">
                    <input type="text" name="pesquisa" placeholder="Pesquisar..." value="<?= html_escape($busca) ?>" aria-label="Pesquisar">
                    <button type="submit" title="Pesquisar"><i class="bx bx-search"></i></button>
                    <?php if ($busca !== '') { ?>
                        <a href="<?= site_url("cadastros/{$chave}") ?>" class="cad-limpar" title="Limpar pesquisa"><i class="bx bx-x"></i></a>
                    <?php } ?>
                </form>
            <?php } else { ?>
                <span></span>
            <?php } ?>
            <?php if ($podeAdicionar) { ?>
                <a href="<?= site_url("cadastros/{$chave}/adicionar") ?>" class="cad-btn-novo">
                    <i class="bx bx-plus-circle"></i> Novo(a) <?= html_escape($ent['singular']) ?>
                </a>
            <?php } ?>
        </div>

        <div class="cad-tabela-wrap">
            <table class="cad-tabela table table-bordered">
                <thead>
                    <tr>
                        <?php if ($podeEditar) { ?><th class="cad-col-acao">Editar</th><?php } ?>
                        <th class="cad-col-id">ID</th>
                        <?php foreach ($colunas as $campo) { ?>
                            <th><?= html_escape($campo['coluna'] ?? $campo['rotulo']) ?></th>
                        <?php } ?>
                        <?php if ($temAtivo) { ?><th class="cad-col-acao">Ativo</th><?php } ?>
                        <?php if ($podeExcluir) { ?><th class="cad-col-acao">Excluir</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (! $results) { ?>
                        <tr>
                            <td colspan="<?= $totalColunas ?>" class="cad-sem-registro">
                                <?= $busca !== '' ? 'Nenhum resultado para a pesquisa.' : 'Nenhum registro cadastrado ainda.' ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php foreach ($results as $r) { ?>
                        <tr>
                            <?php if ($podeEditar) { ?>
                                <td class="cad-col-acao">
                                    <a href="<?= site_url("cadastros/{$chave}/editar/{$r->id}") ?>" class="cad-icone" title="Editar"><i class="bx bx-edit"></i></a>
                                </td>
                            <?php } ?>
                            <td class="cad-col-id"><?= (int) $r->id ?></td>
                            <?php foreach ($colunas as $nome => $campo) { ?>
                                <td><?= $formatar($r, $nome, $campo) ?></td>
                            <?php } ?>
                            <?php if ($temAtivo) { ?>
                                <td class="cad-col-acao">
                                    <label class="cad-switch" title="<?= $podeEditar ? 'Ativar / desativar' : '' ?>">
                                        <input type="checkbox" class="cad-alternar" data-id="<?= (int) $r->id ?>" <?= $r->ativo ? 'checked' : '' ?> <?= $podeEditar ? '' : 'disabled' ?>>
                                        <span></span>
                                    </label>
                                </td>
                            <?php } ?>
                            <?php if ($podeExcluir) { ?>
                                <td class="cad-col-acao">
                                    <a href="#modal-excluir-cad" role="button" data-toggle="modal" data-id="<?= (int) $r->id ?>" class="cad-icone cad-icone-perigo cad-excluir" title="Excluir"><i class="bx bx-trash-alt"></i></a>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="cad-rodape">
            <span>Mostrando <?= count($results) ?> de <?= (int) $total ?> registro(s)</span>
            <?= $this->pagination->create_links() ?>
        </div>
    </div>
</div>

<?php if ($podeExcluir) { ?>
<div id="modal-excluir-cad" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="<?= site_url("cadastros/{$chave}/excluir") ?>" method="post">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5>Excluir <?= html_escape($ent['singular']) ?></h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="cad-excluir-id" name="id" value="">
            <h5 style="text-align: center">Deseja realmente excluir este registro?</h5>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
            <button type="button" class="button btn btn-warning" data-dismiss="modal" aria-hidden="true">
                <span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span>
            </button>
            <button type="submit" class="button btn btn-danger">
                <span class="button__icon"><i class='bx bx-trash'></i></span><span class="button__text2">Excluir</span>
            </button>
        </div>
    </form>
</div>
<?php } ?>

<script>
    $(document).on('click', '.cad-excluir', function () {
        $('#cad-excluir-id').val($(this).data('id'));
    });

    $(document).on('change', '.cad-alternar', function () {
        var caixa = $(this);
        var dados = { id: caixa.data('id') };
        if (typeof getCsrfTokenName === 'function') {
            dados[getCsrfTokenName()] = getCsrfToken();
        }
        caixa.prop('disabled', true);
        $.post('<?= site_url("cadastros/{$chave}/alternar") ?>', dados, null, 'json')
            .done(function (r) {
                if (!r || r.result !== true) {
                    caixa.prop('checked', !caixa.prop('checked'));
                    swal('Atenção', (r && r.mensagem) || 'Não foi possível alterar.', 'error');
                }
            })
            .fail(function () {
                caixa.prop('checked', !caixa.prop('checked'));
                swal('Atenção', 'Erro de conexão ao alterar.', 'error');
            })
            .always(function () { caixa.prop('disabled', false); });
    });
</script>
