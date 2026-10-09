<script src="<?php echo base_url(); ?>assets/js/sortablejs/Sortable.min.js"></script>
<?php $this->load->helper('sla'); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css" />

<?php
// Mapeamento semântico de cores, gradientes e ícones ilustrativos funcionais para cada status
$statusConfig = [
    'Aberto' => [
        'cor' => '#10b981',
        'gradiente' => 'linear-gradient(135deg, #10b981 0%, #059669 100%)',
        'icone' => 'bx bx-bell',
        'classe' => 'status-aberto',
        'descricao' => 'Nova O.S'
    ],
    'Orçamento' => [
        'cor' => '#d97706',
        'gradiente' => 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)',
        'icone' => 'bx bx-calculator',
        'classe' => 'status-orcamento',
        'descricao' => 'Levantamento de custos'
    ],
    'Negociação' => [
        'cor' => '#ca8a04',
        'gradiente' => 'linear-gradient(135deg, #eab308 0%, #ca8a04 100%)',
        'icone' => 'bx bx-conversation',
        'classe' => 'status-negociacao',
        'descricao' => 'Em proposta com cliente'
    ],
    'Aprovado' => [
        'cor' => '#0284c7',
        'gradiente' => 'linear-gradient(135deg, #0284c7 0%, #0369a1 100%)',
        'icone' => 'bx bx-check-circle',
        'classe' => 'status-aprovado',
        'descricao' => 'Serviço autorizado'
    ],
    'Aguardando Peças' => [
        'cor' => '#ea580c',
        'gradiente' => 'linear-gradient(135deg, #f97316 0%, #ea580c 100%)',
        'icone' => 'bx bx-package',
        'classe' => 'status-aguardando-pecas',
        'descricao' => 'Peça em encomenda'
    ],
    'Em Andamento' => [
        'cor' => '#2563eb',
        'gradiente' => 'linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%)',
        'icone' => 'bx bx-wrench',
        'classe' => 'status-em-andamento',
        'descricao' => 'Em bancada técnica'
    ],
    'Finalizado' => [
        'cor' => '#15803d',
        'gradiente' => 'linear-gradient(135deg, #16a34a 0%, #15803d 100%)',
        'icone' => 'bx bx-check-double',
        'classe' => 'status-finalizado',
        'descricao' => 'Reparo concluído'
    ],
    'Faturado' => [
        'cor' => '#7c3aed',
        'gradiente' => 'linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%)',
        'icone' => 'bx bx-receipt',
        'classe' => 'status-faturado',
        'descricao' => 'Financeiro liquidado'
    ],
    'Cancelado' => [
        'cor' => '#dc2626',
        'gradiente' => 'linear-gradient(135deg, #ef4444 0%, #b91c1c 100%)',
        'icone' => 'bx bx-x-circle',
        'classe' => 'status-cancelado',
        'descricao' => 'O.S cancelada'
    ],
];
?>

<style>
    /* Otimização para uso total da tela */
    #content:has(.kanban-widget-box),
    body.kanban-view-active #content {
        padding-left: 14px !important;
        padding-right: 14px !important;
        margin-right: 0 !important;
    }

    body.kanban-view-active .container-flu {
        padding-top: 4px !important;
        padding-bottom: 8px !important;
    }

    /* Modo Tela Toda / Fullscreen de Alta Produtividade */
    body.kanban-tela-toda #sidebar {
        display: none !important;
    }
    body.kanban-tela-toda #content {
        margin-left: 0 !important;
        padding-left: 16px !important;
        padding-right: 16px !important;
    }
    body.kanban-tela-toda #content-header {
        display: none !important;
    }
    body.kanban-tela-toda .navebarn {
        display: none !important;
    }

    .kanban-widget-box {
        margin: 0 0 16px 0 !important;
        border-radius: 8px !important;
        border: 1px solid #e2e8f0 !important;
        background: #ffffff !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04), 0 2px 4px -2px rgba(0, 0, 0, 0.04) !important;
    }

    .kanban-header-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        padding: 10px 16px;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
        border-radius: 8px 8px 0 0;
    }

    .kanban-header-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .kanban-header-title i {
        font-size: 20px;
        color: #0284c7;
    }

    .kanban-header-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-kanban-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 6px;
        text-decoration: none !important;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        cursor: pointer;
    }

    .btn-kanban-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
    }

    .btn-kanban-action i {
        font-size: 15px;
    }

    .btn-kanban-lista {
        background: #1e293b;
        color: #ffffff !important;
        border-color: #0f172a;
    }
    .btn-kanban-lista:hover {
        background: #0f172a;
        color: #ffffff !important;
    }

    .btn-kanban-tela-toda {
        background: #0284c7;
        color: #ffffff !important;
        border-color: #0369a1;
    }
    .btn-kanban-tela-toda:hover {
        background: #0369a1;
        color: #ffffff !important;
    }

    .btn-kanban-filtro {
        background: #ffffff;
        color: #334155 !important;
        border-color: #cbd5e1;
    }
    .btn-kanban-filtro:hover {
        background: #f1f5f9;
        color: #1e293b !important;
    }

    .btn-kanban-filtro.ativo {
        background: #e0f2fe;
        color: #0369a1 !important;
        border-color: #7dd3fc;
    }

    /* Container do Quadro Kanban Horizontal */
    .kanban-wrap {
        display: flex;
        gap: 14px;
        overflow-x: auto;
        overflow-y: hidden;
        padding: 14px 10px 18px 10px;
        align-items: stretch;
        min-height: calc(100vh - 200px);
        box-sizing: border-box;
        scroll-behavior: smooth;
    }

    /* Scrollbar Horizontal Personalizada e Fluida */
    .kanban-wrap::-webkit-scrollbar {
        height: 10px;
    }
    .kanban-wrap::-webkit-scrollbar-track {
        background: #e2e8f0;
        border-radius: 6px;
    }
    .kanban-wrap::-webkit-scrollbar-thumb {
        background: #94a3b8;
        border-radius: 6px;
        border: 2px solid #e2e8f0;
    }
    .kanban-wrap::-webkit-scrollbar-thumb:hover {
        background: #64748b;
    }

    /* Colunas do Kanban */
    .kanban-coluna {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        min-width: 275px;
        max-width: 320px;
        flex: 1 0 275px;
        display: flex;
        flex-direction: column;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .kanban-coluna:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.06);
    }

    .kanban-coluna-titulo {
        padding: 10px 12px;
        font-weight: 700;
        font-size: 13px;
        border-radius: 7px 7px 0 0;
        color: #ffffff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        letter-spacing: 0.2px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .kanban-coluna-titulo .titulo-com-icone {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .kanban-coluna-titulo .titulo-com-icone i {
        font-size: 17px;
        line-height: 1;
    }

    .kanban-badge-contador {
        background: rgba(255, 255, 255, 0.28);
        color: #ffffff;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 12px;
        min-width: 18px;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.35);
    }

    /* Lista Interna dos Cards */
    .kanban-lista {
        min-height: 150px;
        max-height: calc(100vh - 275px);
        overflow-y: auto;
        padding: 10px;
        flex: 1;
    }

    .kanban-lista::-webkit-scrollbar {
        width: 6px;
    }
    .kanban-lista::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    /* Cards */
    .kanban-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #94a3b8;
        border-radius: 6px;
        padding: 10px 12px;
        margin-bottom: 10px;
        cursor: grab;
        font-size: 12px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
    }

    .kanban-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.06);
        border-color: #cbd5e1;
    }

    .kanban-card:active {
        cursor: grabbing;
    }

    .kanban-card.sortable-ghost {
        opacity: 0.35;
        background: #f1f5f9;
        border: 2px dashed #94a3b8;
    }

    .kanban-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
    }

    .kanban-card-numero {
        font-weight: 700;
        font-size: 12px;
    }

    .kanban-card-numero a {
        color: #0284c7;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .kanban-card-numero a:hover {
        color: #0369a1;
        text-decoration: underline;
    }

    .kanban-card-prazo {
        font-size: 11px;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }

    .kanban-card-cliente {
        font-weight: 600;
        color: #1e293b;
        font-size: 12.5px;
        line-height: 1.35;
        margin-bottom: 5px;
        word-break: break-word;
    }

    .kanban-card-meta {
        display: flex;
        flex-direction: column;
        gap: 3px;
        color: #64748b;
        font-size: 11px;
    }

    .kanban-card-linha {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .kanban-card-linha i {
        font-size: 13px;
        color: #94a3b8;
    }

    .os-sem-tecnico {
        color: #94a3b8;
        font-style: italic;
    }

    /* Estado vazio da coluna */
    .kanban-coluna-vazia {
        text-align: center;
        padding: 24px 10px;
        color: #94a3b8;
        font-size: 11px;
        border: 1px dashed #cbd5e1;
        border-radius: 6px;
        margin-top: 6px;
        display: none;
    }

    .kanban-lista:empty + .kanban-coluna-vazia,
    .kanban-lista:has(> :empty) + .kanban-coluna-vazia {
        display: block;
    }

    .kanban-sem-permissao .kanban-card {
        cursor: default;
    }
</style>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box kanban-widget-box">
            <!-- Barra Superior do Kanban com Ações -->
            <div class="kanban-header-toolbar">
                <div class="kanban-header-title">
                    <i class="bx bx-columns"></i>
                    <span>Kanban de Ordens de Serviço<?php echo $minhas ? ' — Minha Fila' : ''; ?></span>
                </div>
                <div class="kanban-header-actions">
                    <!-- Botão Usar Toda a Tela / Fullscreen -->
                    <button type="button" id="btnToggleTelaToda" class="btn-kanban-action btn-kanban-tela-toda" title="Expandir quadro e usar 100% da largura da tela">
                        <i class="bx bx-fullscreen" id="iconeTelaToda"></i>
                        <span id="txtBtnTelaToda">Usar toda tela</span>
                    </button>

                    <!-- Filtro Minha Fila / Todas as OS -->
                    <a title="Alternar filtro" class="btn-kanban-action btn-kanban-filtro <?php echo $minhas ? 'ativo' : ''; ?>" href="<?php echo site_url('kanban' . ($minhas ? '' : '?minhas=1')); ?>">
                        <i class="bx <?php echo $minhas ? 'bx-user-check' : 'bx-layer'; ?>"></i>
                        <span><?php echo $minhas ? 'Minha Fila' : 'Todas as O.S'; ?></span>
                    </a>

                    <!-- Botão [Ver como lista] com ícone ilustrativo -->
                    <a title="Ver como lista" class="btn-kanban-action btn-kanban-lista" href="<?php echo site_url('os' . ($minhas ? '?minhas=1' : '')); ?>">
                        <i class='bx bx-list-ul'></i>
                        <span>Ver como lista</span>
                    </a>
                </div>
            </div>

            <!-- Conteúdo do Quadro -->
            <div class="widget-content nopadding" style="padding: 0;">
                <?php if (! $podeEditar) { ?>
                    <div style="background: #fffbeb; color: #b45309; padding: 8px 14px; font-size: 12px; border-bottom: 1px solid #fef3c7; display: flex; align-items: center; gap: 6px;">
                        <i class="bx bx-info-circle" style="font-size: 16px;"></i>
                        <span>Você está visualizando o quadro em modo de leitura (sem permissão para mover OS entre status).</span>
                    </div>
                <?php } ?>

                <div class="kanban-wrap <?php echo $podeEditar ? '' : 'kanban-sem-permissao'; ?>">
                    <?php
                    foreach ($quadro as $status => $itens) {
                        $cfg = $statusConfig[$status] ?? [
                            'cor' => '#64748b',
                            'gradiente' => 'linear-gradient(135deg, #64748b 0%, #475569 100%)',
                            'icone' => 'bx bx-layer',
                            'classe' => 'status-generico',
                            'descricao' => 'Status O.S'
                        ];
                        $cor = $cfg['cor'];
                        $gradiente = $cfg['gradiente'];
                        $icone = $cfg['icone'];
                        $qtdItens = count($itens);
                    ?>
                        <div class="kanban-coluna <?php echo $cfg['classe']; ?>" data-status="<?php echo html_escape($status); ?>">
                            <div class="kanban-coluna-titulo" style="background: <?php echo $gradiente; ?>;" title="<?php echo html_escape($cfg['descricao']); ?>">
                                <div class="titulo-com-icone">
                                    <i class="<?php echo $icone; ?>"></i>
                                    <span><?php echo html_escape($status); ?></span>
                                </div>
                                <span class="kanban-badge-contador count-<?php echo preg_replace('/[^a-z0-9]/', '', strtolower($status)); ?>"><?php echo $qtdItens; ?></span>
                            </div>

                            <div class="kanban-lista" data-status="<?php echo html_escape($status); ?>">
                                <?php foreach ($itens as $os) { ?>
                                    <div class="kanban-card" style="border-left-color: <?php echo $cor; ?>" data-id-os="<?php echo $os->idOs; ?>">
                                        <div class="kanban-card-header">
                                            <div class="kanban-card-numero">
                                                <a href="<?php echo site_url('os/visualizar/') . $os->idOs; ?>">
                                                    <i class="bx bx-hash"></i>OS #<?php echo $os->idOs; ?>
                                                </a>
                                            </div>
                                            <div class="kanban-card-prazo" title="Data limite / Prazo final">
                                                <i class="bx bx-calendar-event"></i>
                                                <span><?php echo $os->dataFinal ? date('d/m/Y', strtotime($os->dataFinal)) : '-'; ?></span>
                                            </div>
                                        </div>

                                        <div class="kanban-card-cliente">
                                            <?php echo html_escape($os->nomeCliente); ?>
                                        </div>

                                        <div class="kanban-card-meta">
                                            <div class="kanban-card-linha">
                                                <i class="bx bx-user"></i>
                                                <span>Técnico: <?php echo $os->nomeUsuario ? html_escape($os->nomeUsuario) : '<span class="os-sem-tecnico">Sem técnico</span>'; ?></span>
                                            </div>
                                            <?php if (! empty($os->sla_prazo)) { ?>
                                                <div style="margin-top: 3px;">
                                                    <?php echo sla_selo($os); ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php if ($qtdItens === 0) { ?>
                                <div class="kanban-coluna-vazia">Nenhuma O.S neste status</div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Ativar layout fluido na página Kanban
        document.body.classList.add('kanban-view-active');

        // Alternância de Tela Toda (Fullscreen / Ocultar Sidebar)
        var btnTelaToda = document.getElementById('btnToggleTelaToda');
        var iconeTelaToda = document.getElementById('iconeTelaToda');
        var txtBtnTelaToda = document.getElementById('txtBtnTelaToda');

        // Restaurar preferência anterior do usuário se existir
        var telaTodaAtiva = localStorage.getItem('zd_kanban_tela_toda') === '1';
        if (telaTodaAtiva) {
            aplicarModoTelaToda(true);
        }

        if (btnTelaToda) {
            btnTelaToda.addEventListener('click', function () {
                var ativo = document.body.classList.contains('kanban-tela-toda');
                aplicarModoTelaToda(!ativo);
            });
        }

        function aplicarModoTelaToda(habilitar) {
            if (habilitar) {
                document.body.classList.add('kanban-tela-toda');
                if (iconeTelaToda) iconeTelaToda.className = 'bx bx-exit-fullscreen';
                if (txtBtnTelaToda) txtBtnTelaToda.textContent = 'Restaurar Menu';
                localStorage.setItem('zd_kanban_tela_toda', '1');
            } else {
                document.body.classList.remove('kanban-tela-toda');
                if (iconeTelaToda) iconeTelaToda.className = 'bx bx-fullscreen';
                if (txtBtnTelaToda) txtBtnTelaToda.textContent = 'Usar toda tela';
                localStorage.setItem('zd_kanban_tela_toda', '0');
            }
        }

        <?php if ($podeEditar) { ?>
        // Configuração Drag-and-Drop SortableJS
        var listas = document.querySelectorAll('.kanban-lista');

        listas.forEach(function (lista) {
            new Sortable(lista, {
                group: 'kanban-os',
                animation: 180,
                ghostClass: 'sortable-ghost',
                forceFallback: true,
                onEnd: function (evt) {
                    var idOs = evt.item.getAttribute('data-id-os');
                    var novoStatus = evt.to.getAttribute('data-status');
                    var statusAnterior = evt.from.getAttribute('data-status');

                    if (novoStatus === statusAnterior) {
                        return;
                    }

                    // Atualizar contadores visuais nas colunas
                    atualizarContadores();

                    // Ajustar borda do card para a nova cor
                    var novaColuna = evt.to.closest('.kanban-coluna');
                    if (novaColuna) {
                        var novoTitulo = novaColuna.querySelector('.kanban-coluna-titulo');
                        if (novoTitulo) {
                            var novaCor = window.getComputedStyle(novoTitulo).backgroundColor;
                            evt.item.style.borderLeftColor = novaCor;
                        }
                    }

                    jQuery.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>index.php/kanban/moverStatus',
                        data: {
                            idOs: idOs,
                            status: novoStatus,
                            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                        dataType: 'json',
                        success: function (data) {
                            if (data.result !== true) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Atenção',
                                    text: data.mensagem || 'Não foi possível mover a OS.'
                                });
                                evt.from.appendChild(evt.item);
                                atualizarContadores();
                            }
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Atenção',
                                text: 'Ocorreu um erro de conexão ao mover a OS.'
                            });
                            evt.from.appendChild(evt.item);
                            atualizarContadores();
                        }
                    });
                }
            });
        });

        function atualizarContadores() {
            document.querySelectorAll('.kanban-coluna').forEach(function (col) {
                var total = col.querySelectorAll('.kanban-card').length;
                var badge = col.querySelector('.kanban-badge-contador');
                if (badge) {
                    badge.textContent = total;
                }
                var vazia = col.querySelector('.kanban-coluna-vazia');
                if (vazia) {
                    vazia.style.display = (total === 0) ? 'block' : 'none';
                }
            });
        }
        <?php } ?>
    });
</script>
