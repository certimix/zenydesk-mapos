<style>
    select {
        width: 70px;
    }
</style>

<div class="new122">
    <div class="widget-title" style="margin: -20px 0 0">
        <span class="icon">
            <i class="fas fa-cash-register"></i>
        </span>
        <h5>Vendas</h5>
    </div>
    <div class="span12" style="margin-left: 0">
        <form method="get" action="<?php echo base_url(); ?>index.php/vendas/gerenciar">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aVenda')) { ?>
                <div class="span3">
                    <a href="<?php echo base_url(); ?>index.php/vendas/adicionar" class="button btn btn-mini btn-success" style="max-width: 160px">
                        <span class="button__icon"><i class='bx bx-plus-circle'></i></span>
                        <span class="button__text2">Nova Venda</span>
                    </a>
                </div>
            <?php } ?>
            <div class="span3">
                <input type="text" name="pesquisa" id="pesquisa" placeholder="Nome do cliente a pesquisar" class="span12" value="">
            </div>
            <div class="span2">
                <select name="status" class="span12">
                    <option value="">Selecione status</option>
                    <option value="Aberto">Aberto</option>
                    <option value="Faturado">Faturado</option>
                    <option value="Negociação">Negociação</option>
                    <option value="Em Andamento">Em Andamento</option>
                    <option value="Orçamento">Orçamento</option>
                    <option value="Finalizado">Finalizado</option>
                    <option value="Cancelado">Cancelado</option>
                    <option value="Aguardando Peças">Aguardando Peças</option>
                    <option value="Aprovado">Aprovado</option>
                </select>
            </div>
            <div class="span3">
                <input type="date" name="data" id="data" placeholder="De" class="span6 datepicker" autocomplete="off" value="">
                <input type="date" name="data2" id="data2" placeholder="Até" class="span6 datepicker" autocomplete="off" value="">
            </div>
            <div class="span1">
                <button class="button btn btn-mini btn-warning" style="min-width: 30px">
                    <span class="button__icon"><i class='bx bx-search-alt'></i></span>
                </button>
            </div>
        </form>
    </div>

    <div class="widget-box">
        <div class="widget-content nopadding tab-content">
            <table id="tabela" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th>Data da Venda</th>
                        <th>Venc. da Garantia</th>
                        <th>Valor Total</th>
                        <th>Desconto</th>
                        <th>Valor com Desconto</th>
                        <th>V. T. (Faturado)</th>
                        <th>Status</th>
                        <th>Faturado</th>
                        <th style="text-align:center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (!$results) {
                            echo '<tr>
                                    <td colspan="12">Nenhuma Venda Cadastrada</td>
                                </tr>';
                        }
        foreach ($results as $r) {
            $dataVenda = date(('d/m/Y'), strtotime($r->dataVenda));
            $vencGarantia = '';
                            
            if ($r->garantia && is_numeric($r->garantia)) {
                $vencGarantia = dateInterval($r->dataVenda, $r->garantia);
            }
            $corGarantia = '';
            if (!empty($vencGarantia)) {
                $dataGarantia = explode('/', $vencGarantia);
                $dataGarantiaFormatada = $dataGarantia[2] . '-' . $dataGarantia[1] . '-' . $dataGarantia[0];
                $corGarantia = (strtotime($dataGarantiaFormatada) >= strtotime(date('d-m-Y'))) ? '#4d9c79' : '#f24c6f';
            } elseif ($r->garantia == "0") {
                $vencGarantia = 'Sem Garantia';
            }

            $faturado = ($r->faturado == 1) ? 'Sim' : 'Não';
            $corStatus = match($r->status) {
                'Aberto' => '#00cd00',
                'Em Andamento' => '#436eee',
                'Orçamento' => '#CDB380',
                'Negociação' => '#AEB404',
                'Cancelado' => '#CD0000',
                'Finalizado' => '#256',
                'Faturado' => '#B266FF',
                'Aguardando Peças' => '#FF7F00',
                'Aprovado' => '#808080',
                default => '#E0E4CC',
            };

            echo '<tr>';
            echo '<td>' . $r->idVendas . '</td>';
            echo '<td><a href="' . base_url() . 'index.php/clientes/visualizar/' . $r->idClientes . '">' . $r->nomeCliente . '</a></td>';
            echo '<td class="ph1">' . $r->nome . '</td>';
            echo '<td>' . $dataVenda . '</td>';
            echo '<td class="ph3"><span class="badge" style="background-color: ' . $corGarantia . '; border-color: ' . $corGarantia . '">' . $vencGarantia . '</span> </td>';

            if ($r->faturado == 1) {
                echo '<td>R$ ' . number_format($r->valorTotal, 2, ',', '.') . '</td>';
                echo '<td>R$ ' . number_format($r->desconto, 2, ',', '.') . '</td>';
                echo '<td>R$ ' . number_format($r->valor_desconto, 2, ',', '.') . '</td>';
                echo '<td>R$ ' . number_format($r->valor_desconto, 2, ',', '.') . '</td>';
            } else {
                $valorProdutos = isset($r->totalProdutos) ? $r->totalProdutos : 0.00;
                $desconto = isset($r->desconto) ? $r->desconto : 0.00;
                $valorComDesconto = $valorProdutos - $desconto;
                            
                echo '<td>R$ ' . number_format($valorProdutos, 2, ',', '.') . '</td>';
                echo '<td>R$ ' . number_format($desconto, 2, ',', '.') . '</td>';
                echo '<td>R$ ' . number_format($valorComDesconto, 2, ',', '.') . '</td>';
                echo '<td>R$ 0,00</td>';
            }

            echo '<td><span class="badge" style="background-color: ' . $corStatus . '; border-color: ' . $corStatus . '">' . $r->status . '</span> </td>';
            echo '<td>' . $faturado . '</td>';
            echo '<td style="text-align:left">';

            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) {
                echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/vendas/visualizar/' . $r->idVendas . '" class="btn-nwe" title="Ver mais detalhes"><i class="bx bx-show bx-xs"></i></a>';
                echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/vendas/imprimir/' . $r->idVendas . '" target="_blank" class="btn-nwe6" title="Imprimir A4"><i class="bx bx-printer bx-xs"></i></a>';
                echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/vendas/imprimirTermica/' . $r->idVendas . '" target="_blank" class="btn-nwe6" title="Imprimir Não Fiscal"><i class="bx bx-printer bx-xs"></i></a>';
            }

            $canDelete = $this->permission->checkPermission($this->session->userdata('permissao'), 'dVenda')
                || $this->session->userdata('permissao') == 1
                || in_array((string) $this->session->userdata('email_admin'), ['admin@zenydesk.com', 'certimixx@gmail.com', 'c.eduardo.j.s22@gmail.com', 'eduardo.suporte@certimix.com.br']);

            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda')) {
                echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/vendas/editar/' . $r->idVendas . '" class="btn-nwe3" title="Editar venda"><i class="bx bx-edit bx-xs"></i></a>';
            }
            if ($canDelete) {
                echo '<a href="javascript:void(0)" role="button" venda="' . $r->idVendas . '" class="btn-nwe4 btn-excluir-venda" title="Excluir Venda"><i class="bx bx-trash-alt bx-xs"></i></a>';
            }
            echo '</td>';
            echo '</tr>';
        } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php echo $this->pagination->create_links(); ?>
</div>

<!-- Form oculto para submissão segura de exclusão com CSRF -->
<form id="formExcluirVenda" action="<?php echo base_url() ?>index.php/vendas/excluir" method="post" style="display: none;">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
    <input type="hidden" id="idVendaExcluir" name="id" value="" />
</form>

<!-- Modal Fallback -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/vendas/excluir" method="post">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir Venda</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idVenda" name="id" value="" />
            <h5 style="text-align: center">Deseja realmente apagar esta Venda?</h5>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center; gap: 10px;">
            <button type="button" class="button btn btn-warning" data-dismiss="modal" aria-hidden="true">
              <span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Não</span></button>
            <button type="submit" class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span> <span class="button__text2">Sim</span></button>
        </div>
    </form>
</div>

<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.btn-excluir-venda', function(e) {
            e.preventDefault();
            var id = $(this).attr('venda');

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Excluir Venda',
                    text: 'Deseja realmente apagar a Venda #' + id + '?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não',
                    reverseButtons: false,
                    focusCancel: true
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $('#idVendaExcluir').val(id);
                        $('#formExcluirVenda').submit();
                    }
                });
            } else {
                $('#idVenda').val(id);
                $('#modal-excluir').modal('show');
            }
        });
    });
</script>
