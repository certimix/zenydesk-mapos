<script src='<?= base_url(); ?>assets/js/fullcalendar.min.js'></script>
<script src='<?= base_url(); ?>assets/js/fullcalendar/locales/pt-br.js'></script>
<link href='<?= base_url(); ?>assets/css/fullcalendar.min.css' rel='stylesheet' />

<style>
    .agenda-topo { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; justify-content: space-between; margin: 10px 0 14px; }
    .agenda-legenda { display: flex; flex-wrap: wrap; gap: 14px; font-size: 12px; color: #5d6676; }
    .agenda-legenda span::before { content: ''; display: inline-block; width: 10px; height: 10px; border-radius: 3px; margin-right: 5px; background: var(--c); vertical-align: middle; }
    #agenda-calendario { background: #fff; padding: 12px; border-radius: 8px; }
    #agenda-calendario .fc-event { cursor: pointer; }
</style>

<div class="new122">
    <div class="widget-title" style="margin: -20px 0 0">
        <span class="icon"><i class="bx bx-calendar"></i></span>
        <h5>Agenda</h5>
    </div>

    <div class="agenda-topo">
        <div class="agenda-legenda">
            <?php if ($verOs) { ?><span style="--c:#436eee">Ordens de Serviço (pela data final)</span><?php } ?>
            <?php if ($verCadastros) { ?>
                <span style="--c:#17b8a6">Eventos</span>
                <span style="--c:#ff8a3d">Feriados</span>
                <span style="--c:#a78bfa">Afastamentos</span>
            <?php } ?>
        </div>
        <?php if ($podeAdicionarEvento) { ?>
            <a href="<?= site_url('cadastros/eventos/adicionar') ?>" class="button btn btn-mini btn-success" style="max-width: 160px">
                <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2">Novo evento</span>
            </a>
        <?php } ?>
    </div>

    <div id="agenda-calendario"></div>
</div>

<div id="agenda-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="agenda-modal-titulo"></h5>
    </div>
    <div class="modal-body" id="agenda-modal-corpo"></div>
    <div class="modal-footer" style="display:flex;justify-content:center;gap:8px">
        <a id="agenda-modal-link" class="button btn btn-primary" href="#">
            <span class="button__icon"><i class='bx bx-show'></i></span><span class="button__text2">Abrir</span>
        </a>
        <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true">
            <span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Fechar</span>
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var fontes = [];
        <?php if ($verOs) { ?>
        fontes.push({
            url: '<?= site_url('Zenydesk.OS/calendario') ?>',
            method: 'GET',
            failure: function () { console.warn('Falha ao buscar OS para a agenda.'); }
        });
        <?php } ?>
        <?php if ($verCadastros) { ?>
        fontes.push({
            url: '<?= site_url('agenda/eventos') ?>',
            method: 'GET',
            failure: function () { console.warn('Falha ao buscar eventos para a agenda.'); }
        });
        <?php } ?>

        var calendario = new FullCalendar.Calendar(document.getElementById('agenda-calendario'), {
            locale: 'pt-br',
            height: 'auto',
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listMonth'
            },
            dayMaxEvents: 4,
            eventSources: fontes,
            eventClick: function (info) {
                info.jsEvent.preventDefault();
                var ev = info.event;
                var p = ev.extendedProps || {};
                var link = ev.url;
                var corpo = '';

                if (p.id && !link) {
                    // OS vinda da mesma fonte do painel
                    link = '<?= site_url('os/visualizar') ?>/' + p.id;
                    corpo = [p.cliente, p.dataInicial, p.dataFinal, p.status, p.description].filter(Boolean).join('<br>');
                } else {
                    corpo = p.detalhes || '';
                }

                $('#agenda-modal-titulo').text(ev.title);
                $('#agenda-modal-corpo').html(corpo || '<span style="color:#7c8696">Sem detalhes.</span>');
                if (link) {
                    $('#agenda-modal-link').attr('href', link).show();
                } else {
                    $('#agenda-modal-link').hide();
                }
                $('#agenda-modal').modal();
            }
        });
        calendario.render();
    });
</script>
