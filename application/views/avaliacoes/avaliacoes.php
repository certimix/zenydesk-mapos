<?php
/**
 * Avaliações de atendimento — resumo + respostas.
 * Variáveis: $filtros, $resumo, $results, $tecnicos
 */
$maxDist = max(1, max($resumo['distribuicao']));
?>
<style>
    .av-cards { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 12px; margin-bottom: 16px; }
    .av-card { border-radius: 10px; padding: 14px 16px; border: 2px solid var(--c); background: var(--b); }
    .av-card .v { font-size: 30px; font-weight: 800; color: var(--c); line-height: 1.1; }
    .av-card .r { font-size: 12.5px; color: #5d6676; margin-top: 4px; }
    .av-dist { display: grid; gap: 6px; margin-bottom: 18px; max-width: 520px; }
    .av-linha { display: grid; grid-template-columns: 70px 1fr 40px; align-items: center; gap: 8px; font-size: 12.5px; }
    .av-barra { height: 10px; border-radius: 6px; background: #e9eef4; overflow: hidden; }
    .av-barra span { display: block; height: 100%; background: #0284c7; border-radius: 6px; }
    .av-score-tag { font-weight: 700; color: #334155; }
    .av-filtros { display: flex; flex-wrap: wrap; gap: 8px; align-items: flex-end; margin-bottom: 14px; }
    .av-filtros label { font-size: 12px; margin: 0 0 3px; display: block; }
    .av-filtros input, .av-filtros select { margin: 0 !important; height: 32px; width: 150px; }
    .av-comentario { max-width: 420px; white-space: pre-wrap; }
    .badge-nota { display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; border-radius: 6px; font-weight: 700; font-size: 12px; }
    .badge-nota-5 { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .badge-nota-4 { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
    .badge-nota-3 { background: #fef9c3; color: #854d0e; border: 1px solid #fef08a; }
    .badge-nota-2 { background: #ffedd5; color: #9a3412; border: 1px solid #fed7aa; }
    .badge-nota-1 { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
</style>

<div class="cad-pagina new122">
    <div class="cad-cabecalho">
        <h1 class="cad-titulo">Avaliações de Chamados</h1>
    </div>

    <div class="av-cards">
        <div class="av-card" style="--c:#0284c7;--b:#f0f9ff">
            <div class="v"><?= $resumo['media'] !== null ? number_format($resumo['media'], 1, ',', '') : '—' ?></div>
            <div class="r">Nota média (de 5)</div>
        </div>
        <div class="av-card" style="--c:#16a34a;--b:#f0fdf4">
            <div class="v"><?= $resumo['satisfeitos'] !== null ? $resumo['satisfeitos'] . '%' : '—' ?></div>
            <div class="r">Satisfeitos (Notas 4 ou 5)</div>
        </div>
        <div class="av-card" style="--c:#3b82f6;--b:#eff6ff">
            <div class="v"><?= (int) $resumo['total'] ?></div>
            <div class="r">Avaliações respondidas</div>
        </div>
        <div class="av-card" style="--c:#8b5cf6;--b:#f5f3ff">
            <div class="v"><?= (int) $resumo['pendentes'] ?></div>
            <div class="r">Links enviados sem resposta</div>
        </div>
    </div>

    <div class="av-dist" aria-label="Distribuição das notas">
        <?php for ($n = 5; $n >= 1; $n--) {
            $q = $resumo['distribuicao'][$n]; ?>
            <div class="av-linha">
                <span class="av-score-tag">Nota <?= $n ?></span>
                <div class="av-barra"><span style="width: <?= round($q * 100 / $maxDist) ?>%"></span></div>
                <span><?= $q ?></span>
            </div>
        <?php } ?>
    </div>

    <form class="av-filtros" method="get" action="<?= site_url('avaliacoes') ?>">
        <div><label for="av-de">De</label><input type="date" id="av-de" name="de" value="<?= html_escape((string) $filtros['de']) ?>"></div>
        <div><label for="av-ate">Até</label><input type="date" id="av-ate" name="ate" value="<?= html_escape((string) $filtros['ate']) ?>"></div>
        <div>
            <label for="av-tecnico">Técnico</label>
            <select id="av-tecnico" name="tecnico">
                <option value="">Todos</option>
                <?php foreach ($tecnicos as $t) { ?>
                    <option value="<?= (int) $t->idUsuarios ?>" <?= (int) $filtros['tecnico'] === (int) $t->idUsuarios ? 'selected' : '' ?>><?= html_escape($t->nome) ?></option>
                <?php } ?>
            </select>
        </div>
        <div>
            <label for="av-nota">Nota</label>
            <select id="av-nota" name="nota">
                <option value="">Todas</option>
                <?php for ($n = 5; $n >= 1; $n--) { ?>
                    <option value="<?= $n ?>" <?= (int) $filtros['nota'] === $n ? 'selected' : '' ?>>Nota <?= $n ?> de 5</option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="cad-btn-novo"><i class="bx bx-filter-alt"></i> Filtrar</button>
        <a href="<?= site_url('avaliacoes') ?>" class="cad-btn-cancelar">Limpar</a>
    </form>

    <div class="cad-tabela-wrap">
        <table class="cad-tabela table table-bordered">
            <thead>
                <tr><th>OS</th><th>Cliente</th><th>Técnico</th><th>Nota</th><th>Comentário</th><th>Respondida em</th></tr>
            </thead>
            <tbody>
                <?php if (! $results) { ?>
                    <tr><td colspan="6" class="cad-sem-registro">Nenhuma avaliação respondida ainda. Os links são criados quando a OS é finalizada.</td></tr>
                <?php } ?>
                <?php foreach ($results as $r) {
                    $notaCls = 'badge-nota-' . min(5, max(1, (int) $r->nota));
                ?>
                    <tr>
                        <td><a href="<?= site_url('os/visualizar/' . (int) $r->idOs) ?>">#<?= (int) $r->idOs ?></a></td>
                        <td><?= html_escape($r->nomeCliente) ?></td>
                        <td><?= $r->tecnico ? html_escape($r->tecnico) : '<span class="cad-vazio">Sem técnico</span>' ?></td>
                        <td>
                            <span class="badge-nota <?= $notaCls ?>">
                                <i class="bx bx-check-circle"></i> Nota <?= (int) $r->nota ?> / 5
                            </span>
                        </td>
                        <td class="av-comentario"><?= $r->comentario !== null && $r->comentario !== '' ? html_escape($r->comentario) : '<span class="cad-vazio">—</span>' ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($r->respondido_em)) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="cad-rodape">
        <span><?= count($results) ?> de <?= (int) $resumo['total'] ?> avaliação(ões)</span>
        <?= $this->pagination->create_links() ?>
    </div>
</div>
