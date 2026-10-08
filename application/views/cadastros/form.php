<?php
/**
 * Formulário genérico (adicionar/editar) de um cadastro auxiliar, em grade.
 * Variáveis: $chave, $ent, $id, $valores, $erros, $opcoesRelacao
 */
?>
<div class="cad-pagina new122">
    <div class="cad-cabecalho">
        <h1 class="cad-titulo"><?= $id ? 'Editar' : 'Novo(a)' ?> <?= html_escape($ent['singular']) ?></h1>
        <a href="<?= site_url("cadastros/{$chave}") ?>" class="cad-voltar"><i class="bx bx-undo"></i> Voltar</a>
    </div>

    <div class="cad-corpo">
        <?php if ($erros) { ?>
            <div class="cad-erros">
                <strong>Corrija os itens abaixo:</strong>
                <ul>
                    <?php foreach ($erros as $e) { ?>
                        <li><?= html_escape($e) ?></li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>

        <form method="post" action="<?= current_url() ?>" class="cad-form" novalidate>
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

            <div class="cad-grade-form">
                <?php
                $booleanos = [];
                foreach ($ent['campos'] as $nome => $campo) {
                    if ($campo['tipo'] === 'booleano') {
                        $booleanos[$nome] = $campo;

                        continue;
                    }
                    $v = $valores[$nome] ?? '';
                    $idCampo = 'cad_' . $nome;
                    $obrig = ! empty($campo['obrigatorio']) && ! ($campo['tipo'] === 'senha' && $id);
                    $largo = ! empty($campo['largo']) || $campo['tipo'] === 'textarea';
                    ?>
                    <div class="cad-campo<?= $largo ? ' cad-largo' : '' ?>">
                        <label for="<?= $idCampo ?>">
                            <?= html_escape($campo['rotulo']) ?><?= $obrig ? ' <span class="cad-obrig">*</span>' : '' ?>
                        </label>
                        <?php switch ($campo['tipo']) {
                            case 'textarea': ?>
                                <textarea id="<?= $idCampo ?>" name="<?= $nome ?>"><?= html_escape((string) $v) ?></textarea>
                                <?php break;

                            case 'opcoes': ?>
                                <select id="<?= $idCampo ?>" name="<?= $nome ?>">
                                    <option value="">Selecione</option>
                                    <?php foreach ($campo['opcoes'] as $op) { ?>
                                        <option value="<?= html_escape($op) ?>" <?= (string) $v === (string) $op ? 'selected' : '' ?>><?= html_escape($op) ?></option>
                                    <?php } ?>
                                </select>
                                <?php break;

                            case 'relacao': ?>
                                <select id="<?= $idCampo ?>" name="<?= $nome ?>">
                                    <option value="">Selecione</option>
                                    <?php foreach ($opcoesRelacao[$nome] as $k => $texto) { ?>
                                        <option value="<?= (int) $k ?>" <?= (string) $v === (string) $k ? 'selected' : '' ?>><?= html_escape($texto) ?></option>
                                    <?php } ?>
                                </select>
                                <?php if (! $opcoesRelacao[$nome]) { ?>
                                    <span class="cad-ajuda">Nenhuma opção cadastrada ainda.</span>
                                <?php } ?>
                                <?php break;

                            case 'cor': ?>
                                <div class="cad-cor-campo">
                                    <input type="color" id="<?= $idCampo ?>" name="<?= $nome ?>" value="<?= html_escape((string) ($v ?: '#3c94e6')) ?>">
                                    <span class="cad-cor-hex"><?= html_escape((string) ($v ?: '#3c94e6')) ?></span>
                                </div>
                                <?php break;

                            case 'senha': ?>
                                <input type="password" id="<?= $idCampo ?>" name="<?= $nome ?>" value="" autocomplete="new-password" minlength="6"
                                    placeholder="<?= $id ? 'Deixe em branco para manter a senha atual' : 'Mínimo de 6 caracteres' ?>">
                                <?php break;

                            default:
                                $tipoHtml = [
                                    'email' => 'email', 'numero' => 'number', 'data' => 'date',
                                    'datahora' => 'datetime-local', 'telefone' => 'tel', 'decimal' => 'text',
                                ][$campo['tipo']] ?? 'text';
                                $extra = $campo['tipo'] === 'numero' ? ' min="0" step="1"' : '';
                                $extra .= $campo['tipo'] === 'decimal' ? ' inputmode="decimal" placeholder="0,00"' : '';
                                $extra .= isset($campo['max']) ? ' maxlength="' . (int) $campo['max'] . '"' : '';
                                $mostra = $v;
                                if ($campo['tipo'] === 'decimal' && $v !== '' && $v !== null && is_numeric($v)) {
                                    $mostra = number_format((float) $v, 2, ',', '');
                                }
                                ?>
                                <input type="<?= $tipoHtml ?>" id="<?= $idCampo ?>" name="<?= $nome ?>" value="<?= html_escape((string) $mostra) ?>"<?= $extra ?>>
                        <?php } ?>
                        <?php if (! empty($campo['ajuda'])) { ?>
                            <span class="cad-ajuda"><?= html_escape($campo['ajuda']) ?></span>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>

            <?php if ($booleanos) { ?>
                <div class="cad-opcoes-bool">
                    <?php foreach ($booleanos as $nome => $campo) { ?>
                        <label class="cad-switch-rotulo">
                            <span class="cad-switch">
                                <input type="checkbox" id="cad_<?= $nome ?>" name="<?= $nome ?>" value="1" <?= ! empty($valores[$nome]) ? 'checked' : '' ?>>
                                <span></span>
                            </span>
                            <?= html_escape($campo['rotulo']) ?>
                        </label>
                    <?php } ?>
                </div>
            <?php } ?>

            <div class="cad-acoes">
                <a href="<?= site_url("cadastros/{$chave}") ?>" class="cad-btn-cancelar">Cancelar</a>
                <button type="submit" class="cad-btn-salvar"><i class="bx bx-check"></i> Salvar</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).on('input', '.cad-cor-campo input[type=color]', function () {
        $(this).siblings('.cad-cor-hex').text(this.value);
    });
</script>
