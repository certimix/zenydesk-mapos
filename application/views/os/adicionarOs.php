<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/trumbowyg/ui/trumbowyg.css">
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/trumbowyg.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/langs/pt_br.js"></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css" />

<style>
/* =========================================================================
   Estilização do Painel Unificado de Diagnóstico e Laudo (4 Blocos)
   ========================================================================= */
.painel-detalhes-container {
    margin-top: 15px !important;
}
.grid-detalhes-os {
    display: grid !important;
    grid-template-columns: 1fr 1fr !important;
    gap: 16px !important;
    width: 100% !important;
    box-sizing: border-box !important;
}
@media (max-width: 900px) {
    .grid-detalhes-os {
        grid-template-columns: 1fr !important;
    }
}
.card-detalhe-os {
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: 8px !important;
    padding: 14px !important;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03) !important;
    transition: all 0.2s ease !important;
    display: flex !important;
    flex-direction: column !important;
    box-sizing: border-box !important;
}
.card-detalhe-os:hover {
    border-color: #cbd5e1 !important;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
}
.card-detalhe-os:focus-within {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12) !important;
}
.card-detalhe-header {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    margin-bottom: 6px !important;
    padding-bottom: 8px !important;
    border-bottom: 1px solid #f1f5f9 !important;
}
.card-detalhe-title {
    margin: 0 !important;
    cursor: pointer !important;
    display: flex !important;
    align-items: center !important;
    gap: 6px !important;
    font-weight: 700 !important;
    color: #1e293b !important;
    font-size: 13px !important;
}
.card-detalhe-subtitle {
    color: #64748b !important;
    font-size: 11px !important;
    margin-bottom: 8px !important;
    display: block !important;
    line-height: 1.3 !important;
}
.card-detalhe-os .trumbowyg-box {
    margin: 0 !important;
    border: 1px solid #cbd5e1 !important;
    border-radius: 6px !important;
    background: #ffffff !important;
    overflow: hidden !important;
}
.card-detalhe-os .trumbowyg-editor {
    min-height: 120px !important;
    max-height: 220px !important;
    overflow-y: auto !important;
    padding: 8px 12px !important;
    font-size: 13px !important;
    line-height: 1.5 !important;
    color: #1e293b !important;
}
.card-detalhe-os .trumbowyg-button-pane {
    background: #f8fafc !important;
    border-bottom: 1px solid #e2e8f0 !important;
    padding: 2px 4px !important;
}
.card-detalhe-os .trumbowyg-button-pane button {
    height: 26px !important;
    line-height: 26px !important;
}
.pill-detalhe {
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    font-size: 12px !important;
    font-weight: 600 !important;
    border-radius: 6px !important;
    padding: 6px 12px !important;
    cursor: pointer !important;
}
.grid-detalhes-os.modo-abas {
    display: block !important;
}
.grid-detalhes-os.modo-abas .card-detalhe-os {
    display: none !important;
}
.grid-detalhes-os.modo-abas .card-detalhe-os.aba-ativa {
    display: flex !important;
}

/* =========================================================================
   Grid dos Campos Principais da OS (Status, Datas, Garantia, Fotos)
   Elimina sobreposições e descompassos causados por floats legados
   ========================================================================= */
.os-campos-principais-grid {
    display: grid !important;
    grid-template-columns: repeat(4, 1fr) !important;
    gap: 16px !important;
    width: 100% !important;
    box-sizing: border-box !important;
    margin-left: 0 !important;
    padding: 1% 1% 0 1% !important;
    align-items: start !important;
}
@media (max-width: 980px) {
    .os-campos-principais-grid {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}
@media (max-width: 580px) {
    .os-campos-principais-grid {
        grid-template-columns: 1fr !important;
    }
}
.os-campo-col {
    display: flex !important;
    flex-direction: column !important;
    width: 100% !important;
    box-sizing: border-box !important;
    float: none !important;
    margin: 0 !important;
}
.os-campo-col label {
    font-size: 13px !important;
    font-weight: 600 !important;
    color: #334155 !important;
    margin-bottom: 6px !important;
    display: block !important;
}
.os-campo-col input,
.os-campo-col select {
    width: 100% !important;
    max-width: 100% !important;
    box-sizing: border-box !important;
    height: 36px !important;
    border: 1px solid #cbd5e1 !important;
    border-radius: 6px !important;
    padding: 6px 10px !important;
    font-size: 13px !important;
    color: #1e293b !important;
    background-color: #ffffff !important;
    margin: 0 0 10px 0 !important;
    float: none !important;
}
.os-campo-col select {
    line-height: 24px !important;
}
.os-campo-col input:focus,
.os-campo-col select:focus {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
    outline: none !important;
}
.card-box-fotos {
    background: #f8fafc !important;
    border: 1px dashed #cbd5e1 !important;
    border-radius: 8px !important;
    padding: 10px !important;
    box-sizing: border-box !important;
    width: 100% !important;
    margin-top: 4px !important;
    clear: both !important;
}
.card-box-fotos-header {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    margin-bottom: 6px !important;
    width: 100% !important;
}
.card-box-fotos-title {
    font-size: 11px !important;
    font-weight: 700 !important;
    color: #334155 !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 4px !important;
    margin: 0 !important;
}
.card-box-fotos-badge {
    font-size: 9px !important;
    padding: 2px 6px !important;
    font-weight: 700 !important;
    background-color: #10b981 !important;
    color: #ffffff !important;
    border-radius: 4px !important;
}
.card-box-fotos-btn {
    width: 100% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 6px !important;
    padding: 7px 10px !important;
    font-weight: 600 !important;
    font-size: 12px !important;
    border-radius: 6px !important;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
    cursor: pointer !important;
    box-sizing: border-box !important;
    margin: 0 !important;
}
.card-box-fotos-info {
    display: block !important;
    margin-top: 6px !important;
    font-size: 10px !important;
    color: #64748b !important;
    line-height: 1.2 !important;
    text-align: center !important;
}
</style>

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

                                    <div class="os-campos-principais-grid">
                                        <!-- 1. Status + Fotos do Atendimento -->
                                        <div class="os-campo-col">
                                            <label for="status">Status <span class="required">*</span></label>
                                            <select name="status" id="status">
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

                                            <div class="card-box-fotos">
                                                <div class="card-box-fotos-header">
                                                    <span class="card-box-fotos-title">
                                                        <i class="bx bx-camera" style="color: #0284c7; font-size: 14px;"></i> Fotos Atendimento
                                                    </span>
                                                    <span class="card-box-fotos-badge">5 Anos</span>
                                                </div>
                                                <button type="button" class="btn btn-info card-box-fotos-btn" id="btnAdicionarFotos">
                                                    <i class="bx bx-camera" style="font-size: 15px;"></i>
                                                    <span id="btnFotosTexto">Adicionar Fotos</span>
                                                </button>
                                                <input type="file" name="fotos_atendimento[]" id="inputFotosAtendimento" multiple="multiple" accept="image/jpeg,image/png,image/jpg" style="display: none !important;" />
                                                <small id="fotosInfo" class="card-box-fotos-info">
                                                    <i class="bx bx-shield-quarter" style="color: #16a34a;"></i> Retenção 5 anos (auto-limpeza)
                                                </small>
                                            </div>
                                        </div>

                                        <!-- 2. Data Inicial -->
                                        <div class="os-campo-col">
                                            <label for="dataInicial">Data Inicial <span class="required">*</span></label>
                                            <input id="dataInicial" autocomplete="off" class="datepicker" type="text" name="dataInicial" value="<?php echo date('d/m/Y'); ?>" />
                                        </div>

                                        <!-- 3. Data Final / Previsão -->
                                        <div class="os-campo-col">
                                            <label for="dataFinal">Data Final / Previsão <span class="required">*</span></label>
                                            <input id="dataFinal" autocomplete="off" class="datepicker" type="text" name="dataFinal" value="" placeholder="Calculado via SLA ou manual" />
                                        </div>

                                        <!-- 4. Garantia & Termo -->
                                        <div class="os-campo-col">
                                            <label for="garantia">Garantia (dias)</label>
                                            <input id="garantia" type="number" placeholder="Status s/g inserir nº/0" min="0" max="9999" name="garantia" value="" />
                                            <?php echo form_error('garantia'); ?>
                                            <label for="termoGarantia">Termo Garantia</label>
                                            <input id="termoGarantia" type="text" name="termoGarantia" placeholder="Selecione o termo..." value="" autocomplete="off" />
                                            <input id="garantias_id" type="hidden" name="garantias_id" value="" />
                                        </div>
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

                                    <!-- ========================================================================= -->
                                    <!-- PAINEL UNIFICADO DE DIAGNÓSTICO, DEFEITO E LAUDO (4 BLOCOS INTEGRADOS)    -->
                                    <!-- ========================================================================= -->
                                    <div class="span12 painel-detalhes-container" style="padding: 1%; margin-left: 0;">
                                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden;">
                                            
                                            <!-- Cabeçalho do Painel Unificado -->
                                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 18px; background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%); border-bottom: 1px solid #e2e8f0;">
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                    <div style="width: 32px; height: 32px; border-radius: 6px; background: #eff6ff; border: 1px solid #bfdbfe; display: flex; align-items: center; justify-content: center;">
                                                        <i class="bx bx-layer" style="color: #2563eb; font-size: 18px;"></i>
                                                    </div>
                                                    <div>
                                                        <h5 style="margin: 0; font-size: 14px; font-weight: 700; color: #1e293b; line-height: 1.2;">
                                                            Diagnóstico, Defeito & Procedimentos Técnicos
                                                        </h5>
                                                        <small style="color: #64748b; font-size: 11px;">
                                                            Detalhamento do equipamento, relato do cliente, observações e laudo técnico
                                                        </small>
                                                    </div>
                                                </div>
                                                <!-- Alternador de Visualização (Grade 2x2 vs Abas Focadas) -->
                                                <div class="btn-group" data-toggle="buttons-radio" style="margin: 0;">
                                                    <button type="button" class="btn btn-mini active" id="btnModoGrid" style="display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 4px 0 0 4px;">
                                                        <i class="bx bx-grid-alt"></i> Grade 2x2
                                                    </button>
                                                    <button type="button" class="btn btn-mini" id="btnModoTabs" style="display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 0 4px 4px 0;">
                                                        <i class="bx bx-window"></i> Abas Focadas
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Seletor de Abas (visível no modo Abas) -->
                                            <div id="navTabsDetalhes" style="display: none; padding: 10px 18px 0 18px; background: #ffffff; border-bottom: 1px solid #e2e8f0;">
                                                <ul class="nav nav-pills" style="margin-bottom: 10px; display: flex; flex-wrap: wrap; gap: 6px;">
                                                    <li class="active"><a href="javascript:void(0)" class="pill-detalhe" data-target="blocoDescricao"><i class="bx bx-package" style="color:#0284c7"></i> Descrição Produto/Serviço</a></li>
                                                    <li><a href="javascript:void(0)" class="pill-detalhe" data-target="blocoDefeito"><i class="bx bx-error-alt" style="color:#ea580c"></i> Defeito Reclamado</a></li>
                                                    <li><a href="javascript:void(0)" class="pill-detalhe" data-target="blocoObservacoes"><i class="bx bx-notepad" style="color:#475569"></i> Observações</a></li>
                                                    <li><a href="javascript:void(0)" class="pill-detalhe" data-target="blocoLaudo"><i class="bx bx-wrench" style="color:#2563eb"></i> Laudo Técnico</a></li>
                                                </ul>
                                            </div>

                                            <!-- Container do Conteúdo (Suporta Modo Grid 2x2 e Modo Abas) -->
                                            <div id="conteudoDetalhesOs" style="padding: 16px; background: #f8fafc;">
                                                <div class="grid-detalhes-os">
                                                    
                                                    <!-- 1. Descrição Produto/Serviço -->
                                                    <div class="card-detalhe-os" id="blocoDescricao">
                                                        <div class="card-detalhe-header">
                                                            <label for="descricaoProduto" class="card-detalhe-title">
                                                                <i class="bx bx-package" style="font-size: 17px; color: #0284c7;"></i>
                                                                Descrição Produto/Serviço
                                                            </label>
                                                            <span class="badge" style="background: #e0f2fe; color: #0369a1; font-weight: 600; font-size: 10px; padding: 2px 8px; border-radius: 10px; border: 1px solid #bae6fd;">Item / Ativo</span>
                                                        </div>
                                                        <small class="card-detalhe-subtitle">
                                                            Identificação do equipamento, marca, modelo, cor ou número de série.
                                                        </small>
                                                        <textarea class="span12 editor-compacto" name="descricaoProduto" id="descricaoProduto" placeholder="Ex: Notebook Dell Inspiron 15, Serial: ABC1234, com fonte..." cols="30" rows="4"></textarea>
                                                    </div>

                                                    <!-- 2. Defeito Reclamado -->
                                                    <div class="card-detalhe-os" id="blocoDefeito">
                                                        <div class="card-detalhe-header">
                                                            <label for="defeito" class="card-detalhe-title">
                                                                <i class="bx bx-error-alt" style="font-size: 17px; color: #ea580c;"></i>
                                                                Defeito Reclamado
                                                            </label>
                                                            <span class="badge" style="background: #ffedd5; color: #c2410c; font-weight: 600; font-size: 10px; padding: 2px 8px; border-radius: 10px; border: 1px solid #fed7aa;">Reclamação</span>
                                                        </div>
                                                        <small class="card-detalhe-subtitle">
                                                            Sintoma ou falha informada pelo cliente na abertura do chamado.
                                                        </small>
                                                        <textarea class="span12 editor-compacto" name="defeito" id="defeito" placeholder="Ex: Não liga, desliga sozinho após 10 minutos ou tela azul..." cols="30" rows="4"></textarea>
                                                    </div>

                                                    <!-- 3. Observações -->
                                                    <div class="card-detalhe-os" id="blocoObservacoes">
                                                        <div class="card-detalhe-header">
                                                            <label for="observacoes" class="card-detalhe-title">
                                                                <i class="bx bx-notepad" style="font-size: 17px; color: #475569;"></i>
                                                                Observações
                                                            </label>
                                                            <span class="badge" style="background: #f1f5f9; color: #475569; font-weight: 600; font-size: 10px; padding: 2px 8px; border-radius: 10px; border: 1px solid #e2e8f0;">Geral</span>
                                                        </div>
                                                        <small class="card-detalhe-subtitle">
                                                            Estado físico de entrada (marcas, arranhões) ou notas adicionais.
                                                        </small>
                                                        <textarea class="span12 editor-compacto" name="observacoes" id="observacoes" placeholder="Ex: Equipamento com marcas de uso na carcaça, acompanha carregador original..." cols="30" rows="4"></textarea>
                                                    </div>

                                                    <!-- 4. Laudo Técnico -->
                                                    <div class="card-detalhe-os" id="blocoLaudo">
                                                        <div class="card-detalhe-header">
                                                            <label for="laudoTecnico" class="card-detalhe-title">
                                                                <i class="bx bx-wrench" style="font-size: 17px; color: #2563eb;"></i>
                                                                Laudo Técnico
                                                            </label>
                                                            <span class="badge" style="background: #dbeafe; color: #1d4ed8; font-weight: 600; font-size: 10px; padding: 2px 8px; border-radius: 10px; border: 1px solid #bfdbfe;">Técnico</span>
                                                        </div>
                                                        <small class="card-detalhe-subtitle">
                                                            Diagnóstico do técnico, procedimentos executados e o que foi feito.
                                                        </small>
                                                        <textarea class="span12 editor-compacto" name="laudoTecnico" id="laudoTecnico" placeholder="Ex: Constatado curto no circuito de entrada. Substituído componente e realizados testes..." cols="30" rows="4"></textarea>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
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

        // Editor Compacto Trumbowyg para os 4 campos técnicos (layout organizado)
        var trumboConfigCompacto = {
            lang: 'pt_br',
            semantic: { 'strikethrough': 's' },
            autogrow: false,
            btns: [
                ['undo', 'redo'],
                ['formatting'],
                ['strong', 'em', 'underline'],
                ['unorderedList', 'orderedList'],
                ['link'],
                ['removeformat'],
                ['fullscreen']
            ]
        };
        $('.editor-compacto').trumbowyg(trumboConfigCompacto);

        $('.editor').trumbowyg({
            lang: 'pt_br',
            semantic: { 'strikethrough': 's' }
        });

        // Alternância de Visualização: Grade 2x2 vs Abas Focadas
        function aplicarModoVisualizacao(modo) {
            if (modo === 'tabs') {
                $("#btnModoTabs").addClass('active btn-primary').removeClass('btn-default');
                $("#btnModoGrid").removeClass('active btn-primary');
                $("#navTabsDetalhes").slideDown(150);
                $(".grid-detalhes-os").addClass('modo-abas');
                var activeTarget = $("#navTabsDetalhes li.active a").data('target') || 'blocoDescricao';
                $(".card-detalhe-os").removeClass('aba-ativa');
                $("#" + activeTarget).addClass('aba-ativa');
            } else {
                $("#btnModoGrid").addClass('active btn-primary').removeClass('btn-default');
                $("#btnModoTabs").removeClass('active btn-primary');
                $("#navTabsDetalhes").slideUp(150);
                $(".grid-detalhes-os").removeClass('modo-abas');
                $(".card-detalhe-os").removeClass('aba-ativa');
            }
            try {
                localStorage.setItem('zenydesk_os_detalhes_view', modo);
            } catch(e) {}
        }

        $("#btnModoGrid").on('click', function(e) {
            e.preventDefault();
            aplicarModoVisualizacao('grid');
        });

        $("#btnModoTabs").on('click', function(e) {
            e.preventDefault();
            aplicarModoVisualizacao('tabs');
        });

        $("#navTabsDetalhes a.pill-detalhe").on('click', function(e) {
            e.preventDefault();
            $("#navTabsDetalhes li").removeClass('active');
            $(this).parent('li').addClass('active');
            var targetId = $(this).data('target');
            $(".card-detalhe-os").removeClass('aba-ativa');
            $("#" + targetId).addClass('aba-ativa');
            $("#" + targetId).find('.editor-compacto').trigger('tbwresize');
        });

        // Restaura preferência salva (padrão Grade 2x2)
        try {
            var modoSalvo = localStorage.getItem('zenydesk_os_detalhes_view');
            if (modoSalvo === 'tabs') {
                aplicarModoVisualizacao('tabs');
            } else {
                aplicarModoVisualizacao('grid');
            }
        } catch(e) {
            aplicarModoVisualizacao('grid');
        }

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
