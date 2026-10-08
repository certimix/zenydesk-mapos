<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table-custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<style>
  select {
    width: 70px;
  }
  .btn-nwe-foto {
    background: #0284c7;
    color: #ffffff !important;
    border: none;
    padding: 6px 8px;
    border-radius: 4px;
    display: inline-block;
    line-height: 1;
    font-size: 14px;
    transition: all 0.2s;
  }
  .btn-nwe-foto:hover {
    background: #0369a1;
    color: #ffffff !important;
    transform: translateY(-1px);
  }
  .card-foto-os {
    position: relative;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    overflow: hidden;
    background: #ffffff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
    transition: transform 0.2s, box-shadow 0.2s;
  }
  .card-foto-os:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.12);
  }
  .card-foto-thumb {
    width: 100%;
    height: 110px;
    object-fit: cover;
    display: block;
    cursor: pointer;
  }
  .card-foto-body {
    padding: 6px 8px;
    font-size: 11px;
    background: #f8fafc;
    border-top: 1px solid #f1f5f9;
  }
  .badge-retencao {
    background: #e0f2fe;
    color: #0369a1;
    border: 1px solid #bae6fd;
    border-radius: 4px;
    padding: 2px 4px;
    font-size: 10px;
    font-weight: 600;
    display: inline-block;
  }
</style>
<div class="new122">
    <div class="widget-title" style="margin: -20px 0 0">
            <span class="icon">
                <i class="fas fa-diagnoses"></i>
            </span>
            <h5><?= ! empty($semTecnico) ? 'Chamados Sem Técnico' : ((! empty($minhas)) ? 'Central de Chamados — Minha Fila' : 'Ordens de Serviço') ?></h5>
        </div>
    <div class="span12" style="margin-left: 0">
        <form method="get" action="<?php echo base_url(); ?>index.php/os/gerenciar">
            <?php if (! empty($minhas)) { ?>
                <input type="hidden" name="minhas" value="1">
            <?php } ?>
            <?php if (! empty($semTecnico)) { ?>
                <input type="hidden" name="semtecnico" value="1">
            <?php } ?>
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aOs')) { ?>
                <div class="span3">
                    <a href="<?php echo base_url(); ?>index.php/os/adicionar" class="button btn btn-mini btn-success" style="max-width: 160px">
                        <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2">Ordem de Serviço</span></a>
                </div>
            <?php
            } ?>

            <div class="span3">
                <input type="text" name="pesquisa" id="pesquisa" placeholder="Nome do cliente a pesquisar" class="span12" value="<?=set_value('pesquisa')?>">
            </div>
            <div class="span2">
                <select name="status" id="" class="span12">
                    <option value="">Selecione status</option>
                    <option value="Aberto" <?=$this->input->get('status') == 'Aberto' ? 'selected' : ''?>>Aberto</option>
                    <option value="Faturado" <?=$this->input->get('status') == 'Faturado' ? 'selected' : ''?>>Faturado</option>
                    <option value="Negociação" <?=$this->input->get('status') == 'Negociação' ? 'selected' : ''?>>Negociação</option>
                    <option value="Em Andamento" <?=$this->input->get('status') == 'Em Andamento' ? 'selected' : ''?>>Em Andamento</option>
                    <option value="Orçamento" <?=$this->input->get('status') == 'Orçamento' ? 'selected' : ''?>>Orçamento</option>
                    <option value="Finalizado" <?=$this->input->get('status') == 'Finalizado' ? 'selected' : ''?>>Finalizado</option>
                    <option value="Cancelado" <?=$this->input->get('status') == 'Cancelado' ? 'selected' : ''?>>Cancelado</option>
                    <option value="Aguardando Peças" <?=$this->input->get('status') == 'Aguardando Peças' ? 'selected' : ''?>>Aguardando Peças</option>
                    <option value="Aprovado" <?=$this->input->get('status') == 'Aprovado' ? 'selected' : ''?>>Aprovado</option>
                </select>

            </div>

            <div class="span3">
                <input type="text" name="data" autocomplete="off" id="data" placeholder="Data Inicial" class="span6 datepicker" value="<?=html_escape($this->input->get('data'))?>">
                <input type="text" name="data2" autocomplete="off" id="data2" placeholder="Data Final" class="span6 datepicker" value="<?=html_escape($this->input->get('data2'))?>">
            </div>
            <div class="span1">
                <button class="button btn btn-mini btn-warning" style="min-width: 30px">
                    <span class="button__icon"><i class='bx bx-search-alt'></i></span></button>
            </div>
        </form>
    </div>

    <div class="widget-box" style="margin-top: 8px">
        <div class="widget-content nopadding">
            <div class="table-responsive">
                <table class="table table-bordered ">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Cliente</th>
                            <th class="ph1">Responsável</th>
                            <th>Data Inicial</th>
                            <th class="ph2">Data Final</th>
                            <th class="ph3">Venc. Garantia</th>
                            <th>Valor Total</th>
                            <th>Desconto</th>
                            <th>Valor com Desconto</th>
                            <th class="ph4">V.T (Faturado)</th>
                            <th>Status</th>
                            <th>SLA</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$results) {
                            echo '<tr>
                            <td colspan="13">' . (! empty($semTecnico) ? 'Nenhum chamado sem técnico. 🎉' : 'Nenhuma OS Cadastrada') . '</td>
                            </tr>';
                        }

$this->load->model('os_model');
$this->load->helper('sla');
$podeAssumir = ! empty($semTecnico) && $this->permission->checkPermission($this->session->userdata('permissao'), 'eOs');
foreach ($results as $r) {
    $dataInicial = date(('d/m/Y'), strtotime($r->dataInicial));
    if ($r->dataFinal != null) {
        $dataFinal = date(('d/m/Y'), strtotime($r->dataFinal));
    } else {
        $dataFinal = "";
    }
    if ($this->input->get('pesquisa') === null && is_array(json_decode($configuration['os_status_list']))) {
        if (in_array($r->status, json_decode($configuration['os_status_list'])) != true) {
            continue;
        }
    }

    switch ($r->status) {
        case 'Aberto':
            $cor = '#00cd00';
            break;
        case 'Em Andamento':
            $cor = '#436eee';
            break;
        case 'Orçamento':
            $cor = '#CDB380';
            break;
        case 'Negociação':
            $cor = '#AEB404';
            break;
        case 'Cancelado':
            $cor = '#CD0000';
            break;
        case 'Finalizado':
            $cor = '#256';
            break;
        case 'Faturado':
            $cor = '#B266FF';
            break;
        case 'Aguardando Peças':
            $cor = '#FF7F00';
            break;
        case 'Aprovado':
            $cor = '#808080';
            break;
        default:
            $cor = '#E0E4CC';
            break;
    }
    $vencGarantia = '';

    if ($r->garantia && is_numeric($r->garantia)) {
        $vencGarantia = dateInterval($r->dataFinal, $r->garantia);
    }
    $corGarantia = '';
    if (!empty($vencGarantia)) {
        $dataGarantia = explode('/', $vencGarantia);
        $dataGarantiaFormatada = $dataGarantia[2] . '-' . $dataGarantia[1] . '-' . $dataGarantia[0];
        if (strtotime($dataGarantiaFormatada) >= strtotime(date('d-m-Y'))) {
            $corGarantia = '#4d9c79';
        } else {
            $corGarantia = '#f24c6f';
        }
    } elseif ($r->garantia == "0") {
        $vencGarantia = 'Sem Garantia';
        $corGarantia = '';
    } else {
        $vencGarantia = '';
        $corGarantia = '';
    }

    echo '<tr>';
    echo '<td>' . $r->idOs . '</td>';
    echo '<td class="cli1"><a href="' . base_url() . 'index.php/clientes/visualizar/' . $r->idClientes . '" style="margin-right: 1%">' . $r->nomeCliente . '</a></td>';
    echo '<td class="ph1">' . ($r->nome ? html_escape($r->nome) : '<span class="os-sem-tecnico">Sem técnico</span>') . '</td>';
    echo '<td>' . $dataInicial . '</td>';
    echo '<td class="ph2">' . $dataFinal . '</td>';
    echo '<td class="ph3"><span class="badge" style="background-color: ' . $corGarantia . '; border-color: ' . $corGarantia . '">' . $vencGarantia . '</span> </td>';
    echo '<td>R$ ' . number_format($r->totalProdutos + $r->totalServicos, 2, ',', '.') . '</td>';
    echo '<td>R$ ' . number_format(floatval($r->desconto), 2, ',', '.') . '</td>';
    echo '<td>R$ ' . number_format(floatval($r->valor_desconto), 2, ',', '.') . '</td>';
    echo '<td class="ph4">R$ ' . number_format($r->faturado ? floatval($r->valor_desconto) : 0.00, 2, ',', '.') . '</td>';
    echo '<td><span class="badge" style="background-color: ' . $cor . '; border-color: ' . $cor . '">' . $r->status . '</span> </td>';
    echo '<td>' . sla_selo($r) . '</td>';
    echo '<td>';
    if ($podeAssumir && ! $r->usuarios_id) {
        echo '<form method="post" action="' . site_url('os/assumir') . '" style="display:inline;margin:0 4px 0 0">'
            . '<input type="hidden" name="' . $this->security->get_csrf_token_name() . '" value="' . $this->security->get_csrf_hash() . '">'
            . '<input type="hidden" name="idOs" value="' . (int) $r->idOs . '">'
            . '<button type="submit" class="os-btn-assumir" title="Assumir este chamado"><i class="bx bx-user-check"></i> Assumir</button></form>';
    }

    $editavel = $this->os_model->isEditable($r->idOs);

    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
        echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/os/visualizar/' . $r->idOs . '" class="btn-nwe" title="Ver mais detalhes"><i class="bx bx-show"></i></a>';
        echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/os/imprimir/' . $r->idOs . '" target="_blank" class="btn-nwe6" title="Imprimir A4"><i class="bx bx-printer bx-xs"></i></a>';
        echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/os/imprimirTermica/' . $r->idOs . '" target="_blank" class="btn-nwe6" title="Imprimir Não Fiscal"><i class="bx bx-printer bx-xs"></i></a>';
    }
    if ($editavel) {
        echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/os/editar/' . $r->idOs . '" class="btn-nwe3" title="Editar OS"><i class="bx bx-edit"></i></a>';
    }
    echo '<a style="margin-right: 1%" href="#modal-fotos" role="button" data-toggle="modal" os="' . $r->idOs . '" class="btn-nwe-foto btn-abrir-fotos" title="Fotos da OS (JPEG, PNG, JPG) - Retenção 5 Anos"><i class="bx bx-camera"></i></a>';
    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dOs') && $editavel) {
        echo '<a href="#modal-excluir" role="button" data-toggle="modal" os="' . $r->idOs . '" class="btn-nwe4" title="Excluir OS"><i class="bx bx-trash-alt"></i></a>  ';
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

    <!-- Modal -->
    <div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form action="<?php echo base_url() ?>index.php/os/excluir" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 id="myModalLabel">Excluir OS</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idOs" name="id" value="" />
                <h5 style="text-align: center">Deseja realmente excluir esta OS?</h5>
            </div>
            <div class="modal-footer" style="display:flex;justify-content: center">
                <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true">
                    <span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
                <button class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span> <span class="button__text2">Excluir</span></button>
            </div>
        </form>
    </div>
    <!-- Modal de Fotos da OS (Retenção 5 Anos) -->
    <div id="modal-fotos" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalFotosLabel" aria-hidden="true" style="width: 760px; margin-left: -380px;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 id="modalFotosLabel"><i class="bx bx-camera" style="color: #0284c7;"></i> Fotos da OS #<span id="modalFotoOsNum"></span></h4>
        </div>
        <div class="modal-body" style="max-height: 480px; overflow-y: auto;">
            <!-- Aviso da Política de Retenção de 5 Anos -->
            <div class="alert alert-info" style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                <i class="bx bx-shield-quarter" style="font-size: 26px; color: #0284c7; flex-shrink: 0;"></i>
                <div style="font-size: 12px; line-height: 1.4;">
                    <strong>Retenção de 5 Anos no Banco de Dados:</strong> As fotos anexadas (formatos <strong>JPEG, PNG e JPG</strong>) são guardadas por <strong>5 anos</strong> no banco de dados e possuem mecanismo automatizado de auto-exclusão após o término desse período.
                </div>
            </div>

            <!-- Formulário de Envio de Fotos -->
            <form id="formUploadFotos" enctype="multipart/form-data" method="post" action="<?= site_url('os/anexarFotos') ?>" style="margin-bottom: 15px;">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" id="modalFotoOsId" name="idOsServico" value="" />
                
                <div style="background: #f8fafc; border: 2px dashed #94a3b8; border-radius: 8px; padding: 14px 18px; text-align: center;">
                    <div style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                        <i class="bx bx-cloud-upload" style="font-size: 22px; vertical-align: middle; color: #0284c7;"></i>
                        Selecione as fotos da bancada/equipamento:
                    </div>
                    <input type="file" name="fotos[]" id="inputFotosOs" accept="image/jpeg,image/png,image/jpg,.jpg,.jpeg,.png" multiple="multiple" style="margin-bottom: 8px;" required />
                    <div style="font-size: 11px; color: #64748b; margin-bottom: 10px;">Formatos aceitos: <strong>JPEG, PNG e JPG</strong> (fotos individuais ou múltiplas).</div>
                    <button type="submit" id="btnEnviarFotos" class="button btn btn-primary">
                        <span class="button__icon"><i class="bx bx-upload"></i></span>
                        <span class="button__text2">Enviar Fotos</span>
                    </button>
                </div>
            </form>

            <div id="fotoUploadProgresso" style="display: none; margin-bottom: 15px;">
                <div class="progress progress-striped active" style="margin-bottom: 0;">
                    <div class="bar" style="width: 100%;">Enviando fotos e gerando miniaturas...</div>
                </div>
            </div>

            <!-- Galeria de Fotos -->
            <h5 style="border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; margin-top: 15px; font-weight: 600;">
                <i class="bx bx-images"></i> Fotos Armazenadas (<span id="totalFotosOs">0</span>)
            </h5>
            <div id="galeriaFotosOs" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 12px; margin-top: 10px;">
                <div style="grid-column: 1 / -1; text-align: center; color: #94a3b8; padding: 20px;">
                    Carregando fotos...
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true">
                <span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Fechar</span>
            </button>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', 'a', function(event) {
            var os = $(this).attr('os');
            if (os) {
                $('#idOs').val(os);
            }
        });

        function carregarFotosOs(idOs) {
            $('#galeriaFotosOs').html('<div style="grid-column: 1 / -1; text-align: center; color: #94a3b8; padding: 20px;"><i class="bx bx-loader-alt bx-spin" style="font-size: 24px;"></i><br>Carregando fotos da OS...</div>');
            $.ajax({
                url: '<?= site_url('os/getFotosOs') ?>',
                type: 'GET',
                data: { idOs: idOs },
                dataType: 'json'
            }).done(function(data) {
                if (data.result && data.fotos) {
                    $('#totalFotosOs').text(data.fotos.length);
                    if (data.fotos.length === 0) {
                        $('#galeriaFotosOs').html('<div style="grid-column: 1 / -1; text-align: center; color: #94a3b8; padding: 25px;"><i class="bx bx-image" style="font-size: 32px; color: #cbd5e1;"></i><br>Nenhuma foto anexada a esta OS até o momento.</div>');
                        return;
                    }
                    var html = '';
                    data.fotos.forEach(function(f) {
                        html += '<div class="card-foto-os">';
                        html += '<a href="' + f.url + '" target="_blank" title="Clique para ampliar">';
                        html += '<img src="' + f.thumb + '" class="card-foto-thumb" alt="' + f.nome + '">';
                        html += '</a>';
                        html += '<div class="card-foto-body">';
                        html += '<div style="font-weight: 600; color: #334155; margin-bottom: 2px;">Envio: ' + f.data_cadastro + '</div>';
                        html += '<div class="badge-retencao"><i class="bx bx-time-five"></i> Expira em: ' + f.data_expiracao + '</div>';
                        html += '<div style="margin-top: 6px; display: flex; justify-content: space-between; align-items: center;">';
                        html += '<a href="' + f.url + '" target="_blank" class="btn btn-mini btn-info" title="Ver foto em tamanho real"><i class="bx bx-zoom-in"></i></a>';
                        html += '<button type="button" class="btn btn-mini btn-danger btn-excluir-foto-os" data-id="' + f.id + '" data-os="' + idOs + '" title="Excluir Foto"><i class="bx bx-trash"></i></button>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                    });
                    $('#galeriaFotosOs').html(html);
                } else {
                    $('#galeriaFotosOs').html('<div style="grid-column: 1 / -1; text-align: center; color: #ef4444; padding: 20px;">Não foi possível carregar as fotos.</div>');
                }
            }).fail(function() {
                $('#galeriaFotosOs').html('<div style="grid-column: 1 / -1; text-align: center; color: #ef4444; padding: 20px;">Erro de conexão ao buscar fotos.</div>');
            });
        }

        $(document).on('click', '.btn-abrir-fotos', function() {
            var os = $(this).attr('os');
            $('#modalFotoOsId').val(os);
            $('#modalFotoOsNum').text(os);
            $('#inputFotosOs').val('');
            carregarFotosOs(os);
        });

        $('#formUploadFotos').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            var formData = new FormData(form);
            var idOs = $('#modalFotoOsId').val();

            $('#btnEnviarFotos').prop('disabled', true);
            $('#fotoUploadProgresso').show();

            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json'
            }).done(function(data) {
                $('#btnEnviarFotos').prop('disabled', false);
                $('#fotoUploadProgresso').hide();
                if (data.result) {
                    Swal.fire({
                        type: 'success',
                        title: 'Sucesso!',
                        text: data.mensagem
                    });
                    $('#inputFotosOs').val('');
                    carregarFotosOs(idOs);
                } else {
                    Swal.fire({
                        type: 'error',
                        title: 'Atenção',
                        text: data.mensagem
                    });
                }
            }).fail(function() {
                $('#btnEnviarFotos').prop('disabled', false);
                $('#fotoUploadProgresso').hide();
                Swal.fire({
                    type: 'error',
                    title: 'Erro',
                    text: 'Ocorreu um erro ao enviar as fotos. Verifique os formatos (JPEG, PNG, JPG).'
                });
            });
        });

        $(document).on('click', '.btn-excluir-foto-os', function(e) {
            e.preventDefault();
            var idFoto = $(this).data('id');
            var idOs = $(this).data('os');

            Swal.fire({
                title: 'Excluir Foto?',
                text: 'Deseja realmente remover esta foto da Ordem de Serviço?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: '<?= site_url('os/excluirAnexo') ?>',
                        type: 'POST',
                        data: { idAnexo: idFoto, idOs: idOs },
                        dataType: 'json'
                    }).done(function(res) {
                        if (res.result) {
                            Swal.fire({
                                type: 'success',
                                title: 'Excluída!',
                                text: 'Foto removida com sucesso.'
                            });
                            carregarFotosOs(idOs);
                        } else {
                            Swal.fire({
                                type: 'error',
                                title: 'Erro',
                                text: res.mensagem || 'Erro ao excluir.'
                            });
                        }
                    });
                }
            });
        });

        $(document).on('click', '#excluir-notificacao', function(event) {
            event.preventDefault();
            $.ajax({
                    url: '<?php echo site_url() ?>/os/excluir_notificacao',
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(data) {
                    if (data.result == true) {
                        Swal.fire({
                            type: "success",
                            title: "Sucesso",
                            text: "Notificação excluída com sucesso."
                        });
                        location.reload();
                    } else {
                        Swal.fire({
                            type: "success",
                            title: "Sucesso",
                            text: "Ocorreu um problema ao tentar exlcuir notificação."
                        });
                    }
                });
        });
        $(".datepicker").datepicker({
            dateFormat: 'dd/mm/yy'
        });
    });
</script>
