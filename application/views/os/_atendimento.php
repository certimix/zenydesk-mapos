<?php
/**
 * Campos de atendimento da OS no estilo SNDesk (usado em adicionarOs e editarOs).
 * Variáveis: $atendimento (opções de Os_model::opcoesAtendimento), $atual (OS ou null)
 *
 * O SLA é sugerido automaticamente pela Sub Categoria, depois Categoria, depois
 * Departamento — até a pessoa escolher um SLA manualmente.
 */
$atual = $atual ?? null;
$sel = function ($campo) use ($atual) {
    return $atual ? (int) ($atual->{$campo} ?? 0) : 0;
};
$opt = function ($itens, $campo, $attrs = null) use ($sel) {
    foreach ($itens as $i) {
        $extra = $attrs ? $attrs($i) : '';
        echo '<option value="' . (int) $i->id . '"' . $extra . ($sel($campo) === (int) $i->id ? ' selected' : '') . '>' . html_escape($i->nome) . '</option>';
    }
};
$this->load->helper('sla');
?>
<style>
    .os-atendimento-container {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 14px;
        margin: 10px 0 16px;
        clear: both;
    }
    .os-atendimento-titulo {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #0369a1;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .os-atendimento-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 12px;
    }
    .os-atendimento-col {
        display: flex;
        flex-direction: column;
    }
    .os-atendimento-col label {
        font-weight: 600;
        font-size: 12.5px;
        color: #334155;
        margin-bottom: 4px;
    }
    .os-atendimento-col select {
        width: 100% !important;
        margin: 0 !important;
        height: 34px !important;
        border-radius: 6px !important;
        border: 1px solid #cbd5e1 !important;
        background-color: #ffffff !important;
        color: #1e293b !important;
        font-size: 13px !important;
    }
    .os-atendimento-col select:focus {
        border-color: #0284c7 !important;
        box-shadow: 0 0 0 2px rgba(2, 132, 199, 0.2) !important;
        outline: none !important;
    }
    .os-sla-info {
        font-size: 11.5px;
        color: #0369a1;
        margin-top: 5px;
        min-height: 18px;
        font-weight: 500;
    }
    .os-sla-badge-preview {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 600;
    }
</style>

<div class="os-atendimento-container span12" style="margin-left: 0;">
    <div class="os-atendimento-titulo"><i class="bx bx-headphone"></i> Atendimento & SLA Conectados</div>
    <div class="os-atendimento-grid">
        <div class="os-atendimento-col">
            <label for="departamento_id">Departamento</label>
            <select name="departamento_id" id="departamento_id">
                <option value="">Selecione</option>
                <?php $opt($atendimento['departamentos'], 'departamento_id', function ($i) {
                    return ' data-sla="' . (int) $i->sla_id . '"';
                }); ?>
            </select>
        </div>
        <div class="os-atendimento-col">
            <label for="equipe_id">Equipe</label>
            <select name="equipe_id" id="equipe_id">
                <option value="">Selecione</option>
                <?php $opt($atendimento['equipes'], 'equipe_id', function ($i) {
                    return ' data-departamento="' . (int) $i->departamento_id . '"';
                }); ?>
            </select>
        </div>
        <div class="os-atendimento-col">
            <label for="categoria_id">Categoria</label>
            <select name="categoria_id" id="categoria_id">
                <option value="">Selecione</option>
                <?php $opt($atendimento['categorias'], 'categoria_id', function ($i) {
                    return ' data-sla="' . (int) $i->sla_id . '" data-departamento="' . (int) $i->departamento_id . '"';
                }); ?>
            </select>
        </div>
        <div class="os-atendimento-col">
            <label for="subcategoria_id">Sub Categoria</label>
            <select name="subcategoria_id" id="subcategoria_id">
                <option value="">Selecione</option>
                <?php $opt($atendimento['subcategorias'], 'subcategoria_id', function ($i) {
                    return ' data-sla="' . (int) $i->sla_id . '" data-categoria="' . (int) $i->categoria_id . '"';
                }); ?>
            </select>
        </div>
        <div class="os-atendimento-col">
            <label for="sla_id">SLA (Prazo de Atendimento)</label>
            <select name="sla_id" id="sla_id" data-manual="<?= $sel('sla_id') ? '1' : '0' ?>">
                <option value="">Sem SLA</option>
                <?php $opt($atendimento['slas'], 'sla_id', function ($i) {
                    return ' data-horas="' . (int) $i->tempo_solucao . '" data-comercial="' . (int) $i->horario_comercial . '"';
                }); ?>
            </select>
            <div class="os-sla-info" id="os-sla-info">
                <?php if ($atual && ! empty($atual->sla_prazo)) { ?>
                    <?= sla_selo($atual) ?> Prazo: <?= date('d/m/Y H:i', strtotime($atual->sla_prazo)) ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var $dep = $('#departamento_id');
        var $eq  = $('#equipe_id');
        var $cat = $('#categoria_id');
        var $sub = $('#subcategoria_id');
        var $sla = $('#sla_id');
        var $info = $('#os-sla-info');
        var infoOriginal = $info.html();

        // Armazenamos as opções originais para reconstrução confiável em qualquer navegador
        var cacheEquipes = [];
        $eq.find('option').each(function () {
            cacheEquipes.push({
                val: $(this).val(),
                text: $(this).text(),
                dep: String($(this).data('departamento') || '0')
            });
        });

        var cacheCategorias = [];
        $cat.find('option').each(function () {
            cacheCategorias.push({
                val: $(this).val(),
                text: $(this).text(),
                dep: String($(this).data('departamento') || '0'),
                sla: String($(this).data('sla') || '0')
            });
        });

        var cacheSubcategorias = [];
        $sub.find('option').each(function () {
            cacheSubcategorias.push({
                val: $(this).val(),
                text: $(this).text(),
                cat: String($(this).data('categoria') || '0'),
                sla: String($(this).data('sla') || '0')
            });
        });

        function reconstruirSelect($select, itens, valorAtual) {
            $select.empty();
            var matched = false;
            $.each(itens, function (idx, item) {
                var $opt = $('<option></option>').val(item.val).text(item.text);
                if (item.dep) $opt.attr('data-departamento', item.dep);
                if (item.cat) $opt.attr('data-categoria', item.cat);
                if (item.sla) $opt.attr('data-sla', item.sla);
                if (String(item.val) === String(valorAtual) && item.val !== '') {
                    $opt.prop('selected', true);
                    matched = true;
                }
                $select.append($opt);
            });
            if (!matched && valorAtual !== '') {
                $select.val('');
            }
        }

        function filtrarEquipes(depId) {
            var valAtual = $eq.val();
            var filtrados = cacheEquipes.filter(function (item) {
                if (!item.val) return true; // opção "Selecione"
                if (!depId) return true;
                return item.dep === '0' || item.dep === String(depId);
            });
            reconstruirSelect($eq, filtrados, valAtual);
        }

        function filtrarCategorias(depId) {
            var valAtual = $cat.val();
            var filtrados = cacheCategorias.filter(function (item) {
                if (!item.val) return true;
                if (!depId) return true;
                return item.dep === '0' || item.dep === String(depId);
            });
            reconstruirSelect($cat, filtrados, valAtual);
            filtrarSubcategorias($cat.val());
        }

        function filtrarSubcategorias(catId) {
            var valAtual = $sub.val();
            var filtrados = cacheSubcategorias.filter(function (item) {
                if (!item.val) return true;
                if (!catId) return true;
                return item.cat === '0' || item.cat === String(catId);
            });
            reconstruirSelect($sub, filtrados, valAtual);
        }

        function sugerirSla() {
            if ($sla.data('manual') === 1 || $sla.attr('data-manual') === '1') {
                mostrarInfo();
                return;
            }
            var subSla = $sub.find(':selected').attr('data-sla');
            var catSla = $cat.find(':selected').attr('data-sla');
            var depSla = $dep.find(':selected').attr('data-sla');
            var sugerido = (subSla && subSla !== '0') ? subSla : ((catSla && catSla !== '0') ? catSla : ((depSla && depSla !== '0') ? depSla : ''));

            if (sugerido && $sla.find('option[value="' + sugerido + '"]').length) {
                $sla.val(String(sugerido));
            }
            mostrarInfo();
        }

        function calcularPrevisaoHoras(horas, comercial) {
            var d = new Date();
            var partesData = $('#dataInicial').val() ? $('#dataInicial').val().split('/') : null;
            if (partesData && partesData.length === 3) {
                d = new Date(parseInt(partesData[2], 10), parseInt(partesData[1], 10) - 1, parseInt(partesData[0], 10), 9, 0, 0);
            }
            if (comercial) {
                // Cálculo de horas comerciais (08:00 às 18:00 = 10h/dia útil, seg a sex)
                var horasRestantes = horas;
                while (horasRestantes > 0) {
                    var diaSem = d.getDay();
                    if (diaSem !== 0 && diaSem !== 6) { // dia útil
                        var horasDia = Math.min(horasRestantes, 10);
                        horasRestantes -= horasDia;
                        if (horasRestantes > 0) {
                            d.setDate(d.getDate() + 1);
                        }
                    } else {
                        d.setDate(d.getDate() + 1);
                    }
                }
            } else {
                d.setHours(d.getHours() + horas);
            }
            var dia = String(d.getDate()).padStart(2, '0');
            var mes = String(d.getMonth() + 1).padStart(2, '0');
            var ano = d.getFullYear();
            return dia + '/' + mes + '/' + ano;
        }

        function mostrarInfo() {
            var $opt = $sla.find(':selected');
            if (!$opt.val()) {
                $info.text('');
                return;
            }
            if ($opt.val() === $sla.data('original')) {
                $info.html(infoOriginal);
                return;
            }
            var horas = parseInt($opt.attr('data-horas') || 0, 10);
            var comercial = String($opt.attr('data-comercial')) === '1';
            var tipo = comercial ? 'úteis (seg-sex)' : 'corridas';
            var previsao = calcularPrevisaoHoras(horas, comercial);

            $info.html('<span class="os-sla-badge-preview"><i class="bx bx-time-five"></i> ' + horas + 'h ' + tipo + '</span> Previsão: <strong>' + previsao + '</strong>');

            // Se o campo dataFinal estiver vazio ou na tela de adicionar, sugere a data calculada
            var $df = $('#dataFinal');
            if ($df.length && (!$df.val() || $df.attr('data-auto-sla') === '1')) {
                $df.val(previsao).attr('data-auto-sla', '1');
            }
        }

        $sla.data('original', $sla.val());

        // Eventos de comunicação bidirecional
        $dep.on('change', function () {
            filtrarEquipes(this.value);
            filtrarCategorias(this.value);
            sugerirSla();
        });

        $eq.on('change', function () {
            var depRef = $(this).find(':selected').attr('data-departamento');
            if (depRef && depRef !== '0' && !$dep.val()) {
                $dep.val(depRef);
                filtrarEquipes(depRef);
                filtrarCategorias(depRef);
            }
        });

        $cat.on('change', function () {
            var depRef = $(this).find(':selected').attr('data-departamento');
            if (depRef && depRef !== '0' && !$dep.val()) {
                $dep.val(depRef);
                filtrarEquipes(depRef);
            }
            filtrarSubcategorias(this.value);
            sugerirSla();
        });

        $sub.on('change', function () {
            var catRef = $(this).find(':selected').attr('data-categoria');
            if (catRef && catRef !== '0' && !$cat.val()) {
                $cat.val(catRef);
                var depRef = $cat.find(':selected').attr('data-departamento');
                if (depRef && depRef !== '0' && !$dep.val()) {
                    $dep.val(depRef);
                    filtrarEquipes(depRef);
                }
            }
            sugerirSla();
        });

        $sla.on('change', function () {
            $sla.attr('data-manual', '1').data('manual', 1);
            mostrarInfo();
        });

        // Inicialização com valores já preenchidos (se houver)
        if ($dep.val()) {
            filtrarEquipes($dep.val());
            filtrarCategorias($dep.val());
        }
        if ($cat.val()) {
            filtrarSubcategorias($cat.val());
        }
    })();
</script>
