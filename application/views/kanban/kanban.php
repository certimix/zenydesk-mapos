<script src="<?php echo base_url(); ?>assets/js/sortablejs/Sortable.min.js"></script>
<?php $this->load->helper('sla'); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css" />

<style>
    .kanban-wrap {
        display: flex;
        gap: 14px;
        overflow-x: auto;
        padding-bottom: 10px;
        align-items: flex-start;
    }

    .kanban-coluna {
        background: #f4f5f7;
        border-radius: 6px;
        min-width: 260px;
        max-width: 260px;
        flex-shrink: 0;
    }

    .kanban-coluna-titulo {
        padding: 10px 12px;
        font-weight: bold;
        border-radius: 6px 6px 0 0;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .kanban-lista {
        min-height: 60px;
        padding: 8px;
    }

    .kanban-card {
        background: #fff;
        border: 1px solid #ddd;
        border-left: 4px solid #999;
        border-radius: 4px;
        padding: 8px 10px;
        margin-bottom: 8px;
        cursor: grab;
        font-size: 12px;
    }

    .kanban-card:active {
        cursor: grabbing;
    }

    .kanban-card .numero-os {
        font-weight: bold;
    }

    .kanban-card a {
        color: inherit;
    }

    .kanban-card.sortable-ghost {
        opacity: 0.4;
    }

    .kanban-sem-permissao .kanban-card {
        cursor: default;
    }
</style>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon"><i class="bx bx-columns"></i></span>
                <h5>Kanban de Ordens de Serviço<?php echo $minhas ? ' — Minha Fila' : ''; ?></h5>
                <div class="buttons">
                    <a title="Ver como lista" class="button btn btn-mini btn-inverse" href="<?php echo site_url('os' . ($minhas ? '?minhas=1' : '')); ?>">
                        <span class="button__icon"><i class='bx bx-list-ul'></i></span> <span class="button__text">Ver como lista</span>
                    </a>
                </div>
            </div>
            <div class="widget-content nopadding" style="padding: 14px;">
                <?php if (! $podeEditar) { ?>
                    <p style="color:#888; font-size: 12px;">Você pode visualizar o quadro, mas não tem permissão para mover OS entre colunas.</p>
                <?php } ?>

                <div class="kanban-wrap <?php echo $podeEditar ? '' : 'kanban-sem-permissao'; ?>">
                    <?php
                    $cores = [
                        'Aberto' => '#00a65a',
                        'Orçamento' => '#CDB380',
                        'Negociação' => '#AEB404',
                        'Aprovado' => '#808080',
                        'Aguardando Peças' => '#FF7F00',
                        'Em Andamento' => '#436eee',
                        'Finalizado' => '#2a6d4e',
                        'Faturado' => '#B266FF',
                        'Cancelado' => '#CD0000',
                    ];

                    foreach ($quadro as $status => $itens) {
                        $cor = $cores[$status] ?? '#666';
                        ?>
                        <div class="kanban-coluna">
                            <div class="kanban-coluna-titulo" style="--cor: <?php echo $cor; ?>; background-color: <?php echo $cor; ?>">
                                <span><?php echo html_escape($status); ?></span>
                                <span><?php echo count($itens); ?></span>
                            </div>
                            <div class="kanban-lista" data-status="<?php echo html_escape($status); ?>">
                                <?php foreach ($itens as $os) { ?>
                                    <div class="kanban-card" style="--cor: <?php echo $cor; ?>; border-left-color: <?php echo $cor; ?>" data-id-os="<?php echo $os->idOs; ?>">
                                        <div class="numero-os">
                                            <a href="<?php echo site_url('os/visualizar/') . $os->idOs; ?>">OS #<?php echo $os->idOs; ?></a>
                                        </div>
                                        <div><?php echo html_escape($os->nomeCliente); ?></div>
                                        <div style="color:#777">Técnico: <?php echo $os->nomeUsuario ? html_escape($os->nomeUsuario) : '<span class="os-sem-tecnico">Sem técnico</span>'; ?></div>
                                        <?php if (! empty($os->sla_prazo)) { ?><div style="margin-top:3px"><?php echo sla_selo($os); ?></div><?php } ?>
                                        <div style="color:#aaa">Prazo: <?php echo $os->dataFinal ? date('d/m/Y', strtotime($os->dataFinal)) : '-'; ?></div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($podeEditar) { ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var listas = document.querySelectorAll('.kanban-lista');

        listas.forEach(function (lista) {
            new Sortable(lista, {
                group: 'kanban-os',
                animation: 150,
                // Usa o fallback por eventos de mouse/touch em vez da API nativa
                // HTML5 de drag-and-drop: mais consistente entre navegadores e
                // em telas touch (técnicos usando celular/tablet em campo).
                forceFallback: true,
                onEnd: function (evt) {
                    var idOs = evt.item.getAttribute('data-id-os');
                    var novoStatus = evt.to.getAttribute('data-status');
                    var statusAnterior = evt.from.getAttribute('data-status');

                    if (novoStatus === statusAnterior) {
                        return;
                    }

                    jQuery.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>index.php/kanban/moverStatus',
                        data: { idOs: idOs, status: novoStatus },
                        dataType: 'json',
                        success: function (data) {
                            if (data.result !== true) {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Atenção',
                                    text: data.mensagem || 'Não foi possível mover a OS.'
                                });
                                // Desfaz visualmente movendo o card de volta.
                                evt.from.appendChild(evt.item);
                            }
                        },
                        error: function () {
                            Swal.fire({
                                type: 'error',
                                title: 'Atenção',
                                text: 'Ocorreu um erro de conexão ao mover a OS.'
                            });
                            evt.from.appendChild(evt.item);
                        }
                    });
                }
            });
        });
    });
</script>
<?php } ?>
