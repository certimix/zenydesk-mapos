<style>
  select {
    width: 70px;
  }
</style>
<div class="new122">
    <div class="widget-title" style="margin: -20px 0 0">
        <span class="icon">
            <i class="fas fa-wrench"></i>
        </span>
        <h5>Serviços</h5>
    </div>
    <div class="span12" style="margin-left: 0">
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aServico')) : ?>
            <div class="span3 flexxn" style="display: flex;">
                <a href="<?= base_url() ?>index.php/servicos/adicionar" class="button btn btn-mini btn-success" style="max-width: 160px">
                    <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2"> Serviços</span>
                </a>
            </div>
        <?php endif; ?>
        <form class="span9" method="get" action="<?= base_url() ?>index.php/servicos" style="display: flex; justify-content: flex-end;">
            <div class="span3">
                <input type="text" name="pesquisa" id="pesquisa" placeholder="Buscar por Nome ou Descrição..." class="span12" value="<?=html_escape($this->input->get('pesquisa'))?>">
            </div>
            <div class="span1">
                <button class="button btn btn-mini btn-warning" style="min-width: 30px">
                    <span class="button__icon"><i class='bx bx-search-alt'></i></span></button>
            </div>
        </form>
    </div>
    <div class="widget-box">
        <h5 style="padding: 3px 0"></h5>
        <div class="widget-content nopadding tab-content">
            <table id="tabela" class="table table-bordered ">
                <thead>
                    <tr>
                        <th>Cod.</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (!$results) {
                            echo '<tr>
                                    <td colspan="5">Nenhum Serviço Cadastrado</td>
                                </tr>';
                        }
        foreach ($results as $r) {
            echo '<tr>';
            echo '<td>' . $r->idServicos . '</td>';
            echo '<td>' . $r->nome . '</td>';
            echo '<td>' . number_format($r->preco, 2, ',', '.') . '</td>';
            echo '<td>' . $r->descricao . '</td>';
            echo '<td>';
            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eServico')) {
                echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/servicos/editar/' . $r->idServicos . '" class="btn-nwe3" title="Editar Serviço"><i class="bx bx-edit bx-xs"></i></a>';
            }
            $canDelete = $this->permission->checkPermission($this->session->userdata('permissao'), 'dServico')
                || $this->session->userdata('permissao') == 1
                || in_array((string) $this->session->userdata('email_admin'), ['admin@zenydesk.com', 'certimixx@gmail.com', 'c.eduardo.j.s22@gmail.com', 'eduardo.suporte@certimix.com.br']);

            if ($canDelete) {
                echo '<a href="javascript:void(0)" role="button" servico="' . $r->idServicos . '" data-nome="' . html_escape($r->nome) . '" class="btn-nwe4 btn-excluir-servico" title="Excluir Serviço"><i class="bx bx-trash-alt bx-xs"></i></a>  ';
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
<form id="formExcluirServico" action="<?php echo base_url() ?>index.php/servicos/excluir" method="post" style="display: none;">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
    <input type="hidden" id="idServicoExcluir" name="id" value="" />
</form>

<!-- Modal Fallback -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/servicos/excluir" method="post">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir Serviço</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idServico" name="id" value="" />
            <h5 style="text-align: center">Deseja realmente apagar este serviço?</h5>
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
        $(document).on('click', '.btn-excluir-servico', function(e) {
            e.preventDefault();
            var id = $(this).attr('servico');
            var nome = $(this).data('nome') || 'este serviço';

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Excluir Serviço',
                    text: 'Deseja realmente apagar o serviço "' + nome + '"?',
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
                        $('#idServicoExcluir').val(id);
                        $('#formExcluirServico').submit();
                    }
                });
            } else {
                $('#idServico').val(id);
                $('#modal-excluir').modal('show');
            }
        });
    });
</script>
