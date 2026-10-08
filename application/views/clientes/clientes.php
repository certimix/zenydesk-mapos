<style>
    select {
        width: 70px;
    }
</style>
<div class="new122">
    <div class="widget-title" style="margin: -20px 0 0">
        <span class="icon">
            <i class="fas fa-user"></i>
        </span>
        <h5>Clientes</h5>
    </div>
    <div class="span12" style="margin-left: 0">
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')) { ?>
            <div class="span3">
                <a href="<?= base_url() ?>index.php/clientes/adicionar" class="button btn btn-mini btn-success"
                    style="max-width: 165px">
                    <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2">
                        Cliente / Fornecedor
                    </span>
                </a>
            </div>
        <?php } ?>
        <form class="span9" method="get" action="<?= base_url() ?>index.php/clientes"
            style="display: flex; justify-content: flex-end;">
            <div class="span3">
                <input type="text" name="pesquisa" id="pesquisa"
                    placeholder="Buscar por Nome, Doc, Email ou Telefone..." class="span12"
                    value="<?= html_escape($this->input->get('pesquisa')) ?>">
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
                        <th>Contato</th>
                        <th>CPF/CNPJ</th>
                        <th>Telefone</th>
                        <th>Celular</th>
                        <th>Email</th>
                        <th>Tipo</th> <!-- Nova coluna para Fornecedor/Cliente -->
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!$results) {
                        echo '<tr>
                    <td colspan="9">Nenhum Cliente Cadastrado</td>
                  </tr>';
                    }
        foreach ($results as $r) {
            echo '<tr>';
            echo '<td>' . $r->idClientes . '</td>';
            echo '<td><a href="' . base_url() . 'index.php/clientes/visualizar/' . $r->idClientes . '" style="margin-right: 1%">' . $r->nomeCliente . '</a></td>';
            echo '<td>' . $r->contato . '</td>';
            echo '<td>' . $r->documento . '</td>';
            echo '<td>' . $r->telefone . '</td>';
            echo '<td>' . $r->celular . '</td>';
            echo '<td>' . $r->email . '</td>';

            // Verifica se é Fornecedor ou Cliente
            if ($r->fornecedor == 1) {
                echo '<td><span class="label label-primary">Fornecedor</span></td>';
            } else {
                echo '<td><span class="label label-success">Cliente</span></td>';
            }

            $podeExcluir = $this->permission->checkPermission($this->session->userdata('permissao'), 'dCliente')
                || $this->session->userdata('permissao') == 1
                || (isset($this->session->userdata('email_admin')) && in_array($this->session->userdata('email_admin'), ['admin@zenydesk.com', 'certimixx@gmail.com', 'c.eduardo.j.s22@gmail.com', 'eduardo.suporte@certimix.com.br']));

            echo '<td>';
            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
                echo '<a href="' . base_url() . 'index.php/clientes/visualizar/' . $r->idClientes . '" style="margin-right: 1%" class="btn-nwe" title="Ver mais detalhes"><i class="bx bx-show bx-xs"></i></a>';
                echo '<a href="' . base_url() . 'index.php/mine?e=' . $r->email . '" target="new" style="margin-right: 1%" class="btn-nwe2" title="Área do cliente"><i class="bx bx-key bx-xs"></i></a>';
            }
            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
                echo '<a href="' . base_url() . 'index.php/clientes/editar/' . $r->idClientes . '" style="margin-right: 1%" class="btn-nwe3" title="Editar Cliente"><i class="bx bx-edit bx-xs"></i></a>';
            }
            if ($podeExcluir) {
                echo '<a href="javascript:void(0)" role="button" cliente="' . $r->idClientes . '" data-nome="' . html_escape($r->nomeCliente) . '" style="margin-right: 1%" class="btn-nwe4 btn-excluir-cliente" title="Excluir Cliente"><i class="bx bx-trash-alt bx-xs"></i></a>';
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
<form id="formExcluirCliente" action="<?php echo base_url() ?>index.php/clientes/excluir" method="post" style="display: none;">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
    <input type="hidden" id="idCliente" name="id" value="" />
</form>

<!-- Modal Fallback -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/clientes/excluir" method="post">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir Cliente</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idClienteModal" name="id" value="" />
            <h5 style="text-align: center">Deseja realmente apagar este cliente?</h5>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center; gap: 10px;">
            <button type="button" class="button btn btn-warning" data-dismiss="modal" aria-hidden="true"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Não</span></button>
            <button type="submit" class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span> <span class="button__text2">Sim</span></button>
        </div>
    </form>
</div>

<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '.btn-excluir-cliente', function (e) {
            e.preventDefault();
            var id = $(this).attr('cliente');
            var nome = $(this).data('nome') || 'este cliente';

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Excluir Cliente',
                    text: 'Deseja realmente apagar o cliente "' + nome + '"?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não',
                    reverseButtons: false,
                    focusCancel: true
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $('#idCliente').val(id);
                        $('#formExcluirCliente').submit();
                    }
                });
            } else {
                $('#idClienteModal').val(id);
                $('#modal-excluir').modal('show');
            }
        });
    });
</script>
