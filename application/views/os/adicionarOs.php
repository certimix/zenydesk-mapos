<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/trumbowyg/ui/trumbowyg.css">
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/trumbowyg.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/langs/pt_br.js"></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css" />

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon"><i class="fas fa-diagnoses"></i></span>
                <h5>Cadastro de Ordem de Serviço</h5>
            </div>
            <div class="widget-content nopadding tab-content">
                <div class="span12" id="divProdutosServicos" style="margin-left: 0">

                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Detalhes da OS</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="span12" id="divCadastrarOs">
                                <?php if ($custom_error == true) { ?>
                                    <div class="span12 alert alert-danger" id="divInfo" style="padding: 1%; margin-left: 0;">
                                        <strong>Dados incompletos:</strong> Verifique os campos com asterisco (*), certifique-se de clicar na sugestão da lista para selecionar o <strong>Cliente</strong> e confira se há termo de garantia selecionado.
                                    </div>
                                <?php } ?>
                                <form action="<?php echo current_url(); ?>" method="post" id="formOs">
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span6" style="margin-left: 0">
                                            <label for="cliente">Cliente <span class="required">*</span></label>
                                            <input id="cliente" class="span12" type="text" name="cliente" placeholder="Digite o nome ou CPF/CNPJ do cliente..." value="" autocomplete="off" />
                                            <input id="clientes_id" class="span12" type="hidden" name="clientes_id" value="" />
                                            <small id="cliente_aviso" style="color: #64748b; font-size: 11px;">Comece a digitar e selecione o cliente na lista de sugestões.</small>
                                        </div>
                                        <div class="span6">
                                            <label for="tecnico">Técnico / Responsável <small style="font-weight:normal;color:#8a94a0">(deixe em branco para "sem técnico")</small></label>
                                            <input id="tecnico" class="span12" type="text" name="tecnico" placeholder="Selecione o técnico ou deixe vazio..." value="<?= $this->session->userdata('nome_admin'); ?>" autocomplete="off" />
                                            <input id="usuarios_id" class="span12" type="hidden" name="usuarios_id" value="<?= $this->session->userdata('id_admin'); ?>" />
                                        </div>
                                    </div>

                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span3" style="margin-left: 0">
                                            <label for="status">Status <span class="required">*</span></label>
                                            <select class="span12" name="status" id="status">
                                                <option value="Aberto">Aberto</option>
                                                <option value="Orçamento">Orçamento</option>
                                                <option value="Negociação">Negociação</option>
                                                <option value="Aprovado">Aprovado</option>
                                                <option value="Aguardando Peças">Aguardando Peças</option>
                                                <option value="Em Andamento">Em Andamento</option>
                                                <option value="Finalizado">Finalizado</option>
                                                <option value="Faturado">Faturado</option>
                                                <option value="Cancelado">Cancelado</option>
                                            </select>
                                        </div>
                                        <div class="span3">
                                            <label for="dataInicial">Data Inicial <span class="required">*</span></label>
                                            <input id="dataInicial" autocomplete="off" class="span12 datepicker" type="text" name="dataInicial" value="<?php echo date('d/m/Y'); ?>" />
                                        </div>
                                        <div class="span3">
                                            <label for="dataFinal">Data Final / Previsão <span class="required">*</span></label>
                                            <input id="dataFinal" autocomplete="off" class="span12 datepicker" type="text" name="dataFinal" value="" placeholder="Calculado via SLA ou manual" />
                                        </div>
                                        <div class="span3">
                                            <label for="garantia">Garantia (dias)</label>
                                            <input id="garantia" type="number" placeholder="Status s/g inserir nº/0" min="0" max="9999" class="span12" name="garantia" value="" />
                                            <?php echo form_error('garantia'); ?>
                                            <label for="termoGarantia">Termo Garantia</label>
                                            <input id="termoGarantia" class="span12" type="text" name="termoGarantia" placeholder="Selecione o termo..." value="" autocomplete="off" />
                                            <input id="garantias_id" class="span12" type="hidden" name="garantias_id" value="" />
                                        </div>
                                    </div>

                                    <?php $this->load->view('os/_atendimento', ['atendimento' => $atendimento, 'atual' => null]); ?>

                                    <div class="span6" style="padding: 1%; margin-left: 0">
                                        <label for="descricaoProduto">
                                            <h4>Descrição Produto/Serviço</h4>
                                        </label>
                                        <textarea class="span12 editor" name="descricaoProduto" id="descricaoProduto" cols="30" rows="5"></textarea>
                                    </div>
                                    <div class="span6" style="padding: 1%; margin-left: 0">
                                        <label for="defeito">
                                            <h4>Defeito Reclamado</h4>
                                        </label>
                                        <textarea class="span12 editor" name="defeito" id="defeito" cols="30" rows="5"></textarea>
                                    </div>
                                    <div class="span6" style="padding: 1%; margin-left: 0">
                                        <label for="observacoes">
                                            <h4>Observações</h4>
                                        </label>
                                        <textarea class="span12 editor" name="observacoes" id="observacoes" cols="30" rows="5"></textarea>
                                    </div>
                                    <div class="span6" style="padding: 1%; margin-left: 0">
                                        <label for="laudoTecnico">
                                            <h4>Laudo Técnico</h4>
                                        </label>
                                        <textarea class="span12 editor" name="laudoTecnico" id="laudoTecnico" cols="30" rows="5"></textarea>
                                    </div>
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span12" style="display:flex; justify-content: center; gap: 8px;">
                                            <button class="button btn btn-success" id="btnContinuar" type="submit">
                                                <span class="button__icon"><i class='bx bx-chevrons-right'></i></span><span class="button__text2">Continuar</span>
                                            </button>
                                            <a href="<?php echo base_url() ?>index.php/os" class="button btn btn-warning" style="max-width: 160px">
                                                <span class="button__icon"><i class="bx bx-undo"></i></span><span class="button__text2">Voltar</span>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // Autocomplete Cliente
        $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteCliente",
            minLength: 1,
            select: function(event, ui) {
                $("#clientes_id").val(ui.item.id);
                $("#cliente_aviso").html('<span style="color:#16a34a;font-weight:600;"><i class="bx bx-check-circle"></i> Cliente vinculado com sucesso!</span>');
            }
        });

        // Limpa o ID do cliente se o usuário alterar o texto do input
        $("#cliente").on('input', function() {
            if (!this.value.trim()) {
                $("#clientes_id").val('');
                $("#cliente_aviso").text('Comece a digitar e selecione o cliente na lista de sugestões.');
            } else {
                $("#cliente_aviso").html('<span style="color:#f59e0b;"><i class="bx bx-info-circle"></i> Selecione na lista suspensa para vincular.</span>');
            }
        });

        // Autocomplete Técnico
        $("#tecnico").on('input', function() {
            if (!this.value.trim()) {
                $("#usuarios_id").val('');
            }
        });
        $("#tecnico").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteUsuario",
            minLength: 1,
            select: function(event, ui) {
                $("#usuarios_id").val(ui.item.id);
            }
        });

        // Autocomplete Termo de Garantia
        $("#termoGarantia").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteTermoGarantia",
            minLength: 1,
            select: function(event, ui) {
                $("#garantias_id").val(ui.item.id);
            }
        });

        // Validação com garantia de seleção do cliente
        $("#formOs").validate({
            rules: {
                cliente: {
                    required: true
                },
                dataInicial: {
                    required: true
                },
                dataFinal: {
                    required: true
                }
            },
            messages: {
                cliente: {
                    required: 'Campo obrigatório. Digite e selecione o cliente.'
                },
                dataInicial: {
                    required: 'Data Inicial obrigatória.'
                },
                dataFinal: {
                    required: 'Data Final obrigatória.'
                }
            },
            errorClass: "help-inline",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            },
            submitHandler: function(form) {
                if (!$("#clientes_id").val()) {
                    Swal.fire({
                        title: 'Cliente não selecionado',
                        text: 'Por favor, comece a digitar o nome do cliente e clique na sugestão exibida na lista para selecioná-lo.',
                        icon: 'warning',
                        confirmButtonText: 'Entendido'
                    });
                    $("#cliente").focus();
                    return false;
                }
                form.submit();
            }
        });

        $(".datepicker").datepicker({
            dateFormat: 'dd/mm/yy'
        });

        $('.editor').trumbowyg({
            lang: 'pt_br',
            semantic: { 'strikethrough': 's' }
        });
    });
</script>
