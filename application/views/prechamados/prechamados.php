<?php
/**
 * Fila de pré-chamados (abertos pelo cliente no portal).
 * Variáveis: $results, $tecnicos, $slas, $podeEditar
 */
$csrf = '<input type="hidden" name="' . $this->security->get_csrf_token_name() . '" value="' . $this->security->get_csrf_hash() . '">';
?>
<div class="cad-pagina new122">
    <div class="cad-cabecalho">
        <h1 class="cad-titulo">Pré-Chamados</h1>
        <span class="cad-total" style="color:#8a94a0"><?= count($results) ?> aguardando aprovação</span>
    </div>
    <p style="color:#8a94a0;margin:-6px 0 14px">Chamados abertos pelos clientes no portal. Ao aprovar, viram OS normais (com o técnico e o SLA que você escolher).</p>

    <div class="cad-tabela-wrap">
        <table class="cad-tabela table table-bordered">
            <thead>
                <tr><th>OS</th><th>Cliente</th><th>Aberto em</th><th>Descrição</th><th>SLA</th><?php if ($podeEditar) { ?><th style="width:220px">Ações</th><?php } ?></tr>
            </thead>
            <tbody>
                <?php if (! $results) { ?>
                    <tr><td colspan="6" class="cad-sem-registro">Nenhum pré-chamado aguardando. 🎉</td></tr>
                <?php } ?>
                <?php foreach ($results as $r) {
                    $descricao = trim(strip_tags(html_entity_decode((string) $r->descricaoProduto)));
                    $defeito = trim(strip_tags(html_entity_decode((string) $r->defeito)));
                    $texto = $descricao . ($defeito ? ' — ' . $defeito : '');
                    ?>
                    <tr>
                        <td><a href="<?= site_url('os/visualizar/' . (int) $r->idOs) ?>">#<?= (int) $r->idOs ?></a></td>
                        <td><?= html_escape($r->nomeCliente) ?></td>
                        <td><?= $r->aberto_em ? date('d/m/Y H:i', strtotime($r->aberto_em)) : date('d/m/Y', strtotime($r->dataInicial)) ?></td>
                        <td style="max-width:380px"><?= html_escape(mb_strlen($texto) > 140 ? mb_substr($texto, 0, 140) . '…' : $texto) ?></td>
                        <td><?php
                            $slaNome = '';
                            foreach ($slas as $s) {
                                if ((int) $s->id === (int) $r->sla_id) {
                                    $slaNome = $s->nome;
                                }
                            }
                            echo $slaNome ? html_escape($slaNome) : '<span class="cad-vazio">—</span>';
                        ?></td>
                        <?php if ($podeEditar) { ?>
                            <td>
                                <a href="#modal-aprovar" data-toggle="modal" class="cad-btn-novo pc-aprovar" style="background:#8ec541;padding:5px 10px" data-id="<?= (int) $r->idOs ?>" data-sla="<?= (int) $r->sla_id ?>"><i class="bx bx-check"></i> Aprovar</a>
                                <a href="#modal-recusar" data-toggle="modal" class="cad-btn-novo pc-recusar" style="background:#e5484d;padding:5px 10px" data-id="<?= (int) $r->idOs ?>"><i class="bx bx-x"></i> Recusar</a>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php if ($podeEditar) { ?>
<div id="modal-aprovar" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="<?= site_url('prechamados/aprovar') ?>" method="post">
        <?= $csrf ?>
        <input type="hidden" name="idOs" id="pc-aprovar-id">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5>Aprovar pré-chamado</h5>
        </div>
        <div class="modal-body">
            <label for="pc-tecnico">Técnico responsável</label>
            <select name="usuarios_id" id="pc-tecnico" style="width:100%">
                <option value="">Sem técnico (vai para "Chamados Sem Técnico")</option>
                <?php foreach ($tecnicos as $t) { ?>
                    <option value="<?= (int) $t->idUsuarios ?>"><?= html_escape($t->nome) ?></option>
                <?php } ?>
            </select>
            <label for="pc-sla" style="margin-top:10px">SLA</label>
            <select name="sla_id" id="pc-sla" style="width:100%">
                <option value="">Sem SLA</option>
                <?php foreach ($slas as $s) { ?>
                    <option value="<?= (int) $s->id ?>"><?= html_escape($s->nome) ?> (<?= (int) $s->tempo_solucao ?>h)</option>
                <?php } ?>
            </select>
        </div>
        <div class="modal-footer" style="display:flex;justify-content:center;gap:8px">
            <button type="button" class="button btn btn-warning" data-dismiss="modal"><span class="button__text2">Cancelar</span></button>
            <button type="submit" class="button btn btn-success"><span class="button__icon"><i class="bx bx-check"></i></span><span class="button__text2">Aprovar</span></button>
        </div>
    </form>
</div>

<div id="modal-recusar" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="<?= site_url('prechamados/recusar') ?>" method="post">
        <?= $csrf ?>
        <input type="hidden" name="idOs" id="pc-recusar-id">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5>Recusar pré-chamado</h5>
        </div>
        <div class="modal-body">
            <label for="pc-motivo">Motivo (opcional)</label>
            <textarea name="motivo" id="pc-motivo" maxlength="255" style="width:100%;min-height:70px"></textarea>
        </div>
        <div class="modal-footer" style="display:flex;justify-content:center;gap:8px">
            <button type="button" class="button btn btn-warning" data-dismiss="modal"><span class="button__text2">Cancelar</span></button>
            <button type="submit" class="button btn btn-danger"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Recusar</span></button>
        </div>
    </form>
</div>
<script>
    $(document).on('click', '.pc-aprovar', function () {
        $('#pc-aprovar-id').val($(this).data('id'));
        $('#pc-sla').val(String($(this).data('sla') || ''));
    });
    $(document).on('click', '.pc-recusar', function () {
        $('#pc-recusar-id').val($(this).data('id'));
        $('#pc-motivo').val('');
    });
</script>
<?php } ?>
