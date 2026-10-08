<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (! function_exists('os_status_encerrado')) {
    /** Status em que a OS está concluída (o SLA para de contar). */
    function os_status_encerrado(?string $status): bool
    {
        return in_array($status, ['Finalizado', 'Faturado', 'Cancelado'], true);
    }
}

if (! function_exists('sla_situacao')) {
    /**
     * Situação do SLA de uma OS.
     *
     * @return array|null ['classe' => ..., 'texto' => ..., 'detalhe' => ...] ou null se a OS não tem SLA
     */
    function sla_situacao($os): ?array
    {
        $prazo = $os->sla_prazo ?? null;
        if (! $prazo) {
            return null;
        }

        $tPrazo = strtotime($prazo);
        $detalhe = 'Prazo: ' . date('d/m/Y H:i', $tPrazo);

        if (os_status_encerrado($os->status ?? null)) {
            if (($os->status ?? '') === 'Cancelado') {
                return ['classe' => 'sla-neutro', 'texto' => 'SLA —', 'detalhe' => $detalhe];
            }
            $fim = ! empty($os->encerrado_em) ? strtotime($os->encerrado_em) : null;
            if ($fim && $fim > $tPrazo) {
                return ['classe' => 'sla-atrasado', 'texto' => 'Fora do prazo', 'detalhe' => $detalhe . ' · Encerrada em ' . date('d/m/Y H:i', $fim)];
            }

            return ['classe' => 'sla-ok', 'texto' => 'Cumprido', 'detalhe' => $detalhe];
        }

        $faltam = $tPrazo - time();
        if ($faltam < 0) {
            $h = (int) ceil(-$faltam / 3600);

            return ['classe' => 'sla-estourado', 'texto' => 'Estourado' . ($h > 0 ? " há {$h}h" : ''), 'detalhe' => $detalhe];
        }
        if ($faltam <= 2 * 3600) {
            $m = (int) ceil($faltam / 60);

            return ['classe' => 'sla-alerta', 'texto' => $m >= 60 ? 'Vence em ' . ceil($m / 60) . 'h' : "Vence em {$m}min", 'detalhe' => $detalhe];
        }

        return ['classe' => 'sla-ok', 'texto' => 'No prazo', 'detalhe' => $detalhe];
    }
}

if (! function_exists('sla_selo')) {
    /** Selo HTML do SLA para listas e telas da OS. */
    function sla_selo($os): string
    {
        $s = sla_situacao($os);
        if (! $s) {
            return '<span class="sla-selo sla-sem">Sem SLA</span>';
        }

        return '<span class="sla-selo ' . $s['classe'] . '" title="' . html_escape($s['detalhe']) . '"><i class="bx bx-alarm"></i> '
            . html_escape($s['texto']) . '</span>';
    }
}
