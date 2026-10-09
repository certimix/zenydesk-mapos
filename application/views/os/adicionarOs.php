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
                                <form action="<?php echo current_url(); ?>" method="post" id="formOs" enctype="multipart/form-data">
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

                                            <!-- CAIXA VERMELHA SUPERIOR: Botão Registro de Fotos do Atendimento -->
                                            <div style="margin-top: 10px;">
                                                <label style="font-size: 11px; font-weight: 600; color: #475569; display: flex; align-items: center; justify-content: space-between; margin-bottom: 4px;">
                                                    <span>Fotos do Atendimento</span>
                                                    <span class="badge badge-success" style="font-size: 9px; padding: 2px 6px; font-weight: 600; background-color: #10b981; border-radius: 4px;">5 Anos</span>
                                                </label>
                                                <button type="button" class="btn btn-info" id="btnAdicionarFotos" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 6px 10px; font-weight: 600; font-size: 12px; border-radius: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); cursor: pointer;">
                                                    <i class="bx bx-camera" style="font-size: 16px;"></i>
                                                    <span id="btnFotosTexto">Adicionar Fotos</span>
                                                </button>
                                                <input type="file" name="fotos_atendimento[]" id="inputFotosAtendimento" multiple="multiple" accept="image/jpeg,image/png,image/jpg" style="display: none;" />
                                                <small id="fotosInfo" style="display: block; margin-top: 4px; font-size: 10px; color: #64748b; line-height: 1.2;">
                                                    <i class="bx bx-shield-quarter" style="color: #16a34a;"></i> Retenção 5 anos (auto-limpeza)
                                                </small>
                                            </div>
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

                                    <!-- CAIXA VERMELHA INFERIOR: Campo para Descrever o Que Foi Feito -->
                                    <div class="span12" style="padding: 1%; margin-left: 0; margin-top: -5px;">
                                        <label for="laudoTecnico" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                                            <span style="font-size: 13px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 6px;">
                                                <i class="bx bx-wrench" style="color: #2563eb; font-size: 17px;"></i>
                                                Descrição do que foi feito
                                                <small style="color: #64748b; font-weight: normal; font-size: 11px;">(Procedimentos realizados / Relato do atendimento)</small>
                                            </span>
                                            <span style="font-size: 11px; color: #64748b; font-weight: normal;">
                                                <i class="bx bx-info-circle"></i> Ficará gravado no laudo técnico e visível no histórico do cliente
                                            </span>
                                        </label>
                                        <textarea class="span12 editor" name="laudoTecnico" id="laudoTecnico" placeholder="Descreva aqui detalhadamente o que foi feito no atendimento, procedimentos realizados, testes e diagnósticos..." rows="4"></textarea>
                                    </div>

                                    <!-- Painel de Pré-visualização de Fotos Selecionadas -->
                                    <div class="span12" id="previewFotosContainer" style="display: none; padding: 0 1% 1% 1%; margin-left: 0;">
                                        <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 12px;">
                                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                                                <div style="font-size: 12px; font-weight: 600; color: #334155; display: flex; align-items: center; gap: 6px;">
                                                    <i class="bx bx-images" style="color: #0284c7; font-size: 16px;"></i>
                                                    <span id="previewFotosTitulo">Fotos Selecionadas (0)</span>
                                                </div>
                                                <div style="font-size: 11px; color: #166534; background: #dcfce7; border: 1px solid #bbf7d0; padding: 2px 8px; border-radius: 12px; font-weight: 500;">
                                                    <i class="bx bx-time-five"></i> Retenção de 5 anos até: <?= date('d/m/Y', strtotime('+5 years')); ?>
                                                </div>
                                            </div>
                                            <div id="previewFotosGaleria" style="display: flex; flex-wrap: wrap; gap: 10px;"></div>
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
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <label for="observacoes">
                                            <h4>Observações Adicionais</h4>
                                        </label>
                                        <textarea class="span12 editor" name="observacoes" id="observacoes" cols="30" rows="4"></textarea>
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

        // =========================================================================
        // Gerenciamento de Fotos do Atendimento com Retenção de 5 Anos
        // =========================================================================
        var dtFotos = (typeof DataTransfer !== 'undefined') ? new DataTransfer() : null;

        $("#btnAdicionarFotos").on('click', function(e) {
            e.preventDefault();
            $("#inputFotosAtendimento").trigger('click');
        });

        $("#inputFotosAtendimento").on('change', function() {
            var inputEl = this;
            var files = inputEl.files;
            if (!files || files.length === 0) return;

            if (dtFotos) {
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    var ext = file.name.split('.').pop().toLowerCase();
                    if (['jpg', 'jpeg', 'png'].indexOf(ext) !== -1) {
                        // Evita duplicatas pelo nome e tamanho
                        var existe = false;
                        for (var j = 0; j < dtFotos.items.length; j++) {
                            var itemFile = dtFotos.items[j].getAsFile();
                            if (itemFile && itemFile.name === file.name && itemFile.size === file.size) {
                                existe = true;
                                break;
                            }
                        }
                        if (!existe) {
                            dtFotos.items.add(file);
                        }
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Formato não suportado',
                            text: 'Apenas fotos JPEG, JPG e PNG são permitidas para retenção de 5 anos.',
                            confirmButtonText: 'Entendido'
                        });
                    }
                }
                inputEl.files = dtFotos.files;
            }

            renderizarFotosPreview();
        });

        function renderizarFotosPreview() {
            var galeria = $("#previewFotosGaleria");
            galeria.empty();

            var inputEl = $("#inputFotosAtendimento")[0];
            var files = dtFotos ? dtFotos.files : (inputEl ? inputEl.files : []);
            var total = files ? files.length : 0;

            if (total === 0) {
                $("#previewFotosContainer").slideUp(200);
                $("#btnFotosTexto").text("Adicionar Fotos");
                $("#fotosInfo").html('<i class="bx bx-shield-quarter" style="color: #16a34a;"></i> Retenção 5 anos (auto-limpeza)');
                return;
            }

            $("#previewFotosContainer").slideDown(200);
            $("#previewFotosTitulo").text("Fotos Selecionadas (" + total + ")");
            $("#btnFotosTexto").text(total + " Foto(s) Adicionada(s)");
            $("#fotosInfo").html('<span style="color:#16a34a;font-weight:600;"><i class="bx bx-check-circle"></i> ' + total + ' foto(s) pronta(s) para envio</span>');

            Array.from(files).forEach(function(file, index) {
                var reader = new FileReader();
                var cardId = "foto_card_" + index;
                var kb = (file.size / 1024).toFixed(0);

                var cardHtml = $(
                    '<div id="' + cardId + '" style="position: relative; width: 110px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); text-align: center;">' +
                        '<div style="height: 80px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 4px; background: #0f172a;">' +
                            '<img id="img_' + cardId + '" src="" alt="' + file.name + '" style="max-height: 100%; max-width: 100%; object-fit: contain;">' +
                        '</div>' +
                        '<div style="font-size: 10px; color: #475569; margin-top: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="' + file.name + '">' +
                            file.name +
                        '</div>' +
                        '<div style="font-size: 9px; color: #94a3b8;">' +
                            kb + ' KB' +
                        '</div>' +
                        '<button type="button" class="btn-remover-foto" data-index="' + index + '" title="Remover esta foto" style="position: absolute; top: -6px; right: -6px; width: 20px; height: 20px; background: #ef4444; color: #fff; border: none; border-radius: 50%; font-size: 11px; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 2px rgba(0,0,0,0.2);">' +
                            '<i class="bx bx-x"></i>' +
                        '</button>' +
                    '</div>'
                );

                reader.onload = function(e) {
                    $("#img_" + cardId).attr('src', e.target.result);
                };
                reader.readAsDataURL(file);

                galeria.append(cardHtml);
            });
        }

        $(document).on('click', '.btn-remover-foto', function(e) {
            e.preventDefault();
            var idx = parseInt($(this).data('index'), 10);
            if (dtFotos && dtFotos.items) {
                dtFotos.items.remove(idx);
                var inputEl = $("#inputFotosAtendimento")[0];
                if (inputEl) {
                    inputEl.files = dtFotos.files;
                }
                renderizarFotosPreview();
            }
        });
    });
</script>
