<style>
  select {
    width: 70px;
  }
</style>
<div class="new122">
    <div class="widget-title"  style="margin: -20px 0 0">
        <span class="icon">
            <i class="fas fa-book"></i>
        </span>
        <h5>Termo de Garantia</h5>
    </div>
    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aGarantia')) { ?>
    <a href="<?php echo base_url(); ?>index.php/garantias/adicionar" class="button btn btn-mini btn-success" style="max-width: 160px">
      <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2">Termo Garantia</span></a>
<?php } ?>

<div class="widget-box">
    <div class="widget-content nopadding tab-content">
        <table id="tabela" class="table table-bordered ">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Data</th>
                    <th>Ref. Garantia</th>
                    <th>Termo de Garantia</th>
                    <th>Usuario</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (!$results) {
                        echo '<tr>
                                <td colspan="6">Nenhum Termo de Garantia Cadastrada</td>
                                </tr>';
                    }
    foreach ($results as $r) {
        $dataGarantia = date(('d/m/Y'), strtotime($r->dataGarantia));
        $textoGarantiaShort = mb_strimwidth(strip_tags($r->textoGarantia), 0, 50, "...");

        echo '<tr>';
        echo '<td>' . $r->idGarantias . '</td>';
        echo '<td>' . $dataGarantia . '</td>';
        echo '<td>' . $r->refGarantia . '</td>';
        echo '<td>' . $textoGarantiaShort . '</td>';
        echo '<td><a href="' . base_url() . 'index.php/usuarios/editar/' . $r->idUsuarios . '">' . $r->nome . '</a></td>';
        echo '<td>';
        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vGarantia')) {
            echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/garantias/visualizar/' . $r->idGarantias . '" class="btn-nwe" title="Ver mais detalhes"><i class="bx bx-show bx-xs"></i></a>';
            echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/garantias/imprimir/' . $r->idGarantias . '" target="_blank" class="btn-nwe6" title="Imprimir"><i class="bx bx-printer bx-xs"></i></a>';
        }
        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eGarantia')) {
            echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/garantias/editar/' . $r->idGarantias . '" class="btn-nwe3" title="Editar"><i class="bx bx-edit bx-xs"></i></a>';
        }
        $canDelete = $this->permission->checkPermission($this->session->userdata('permissao'), 'dGarantia')
            || $this->session->userdata('permissao') == 1
            || in_array((string) $this->session->userdata('email_admin'), ['admin@zenydesk.com', 'certimixx@gmail.com', 'c.eduardo.j.s22@gmail.com', 'eduardo.suporte@certimix.com.br']);

        if ($canDelete) {
            echo '<a href="javascript:void(0)" role="button" garantia="' . $r->idGarantias . '" data-ref="' . html_escape($r->refGarantia) . '" class="btn-nwe4 btn-excluir-garantia" title="Excluir"><i class="bx bx-trash-alt bx-xs"></i></a>';
        }
        echo '</td>';
        echo '</tr>';
    } ?>
            </tbody>
        </table>
    </div>
</div>
</div>
<?php echo $this->pagination->create_links(); ?>

<!-- Form oculto para submissão segura de exclusão com CSRF -->
<form id="formExcluirGarantia" action="<?php echo base_url() ?>index.php/garantias/excluir" method="post" style="display: none;">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
    <input type="hidden" id="idGarantiaExcluir" name="idGarantias" value="" />
</form>

<!-- Modal Fallback -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/garantias/excluir" method="post">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir Termo de Garantia</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idGarantias" name="idGarantias" value="" />
            <h5 style="text-align: center">Deseja realmente apagar este termo de garantia?</h5>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center; gap: 10px;">
          <button type="button" class="button btn btn-warning" data-dismiss="modal" aria-hidden="true"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Não</span></button>
          <button type="submit" class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span> <span class="button__text2">Sim</span></button>
        </div>
    </form>
</div>

<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.btn-excluir-garantia', function(e) {
            e.preventDefault();
            var id = $(this).attr('garantia');
            var ref = $(this).data('ref') || 'este termo de garantia';

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Excluir Garantia',
                    text: 'Deseja realmente apagar o termo de garantia "' + ref + '"?',
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
                        $('#idGarantiaExcluir').val(id);
                        $('#formExcluirGarantia').submit();
                    }
                });
            } else {
                $('#idGarantias').val(id);
                $('#modal-excluir').modal('show');
            }
        });
    });
</script>
