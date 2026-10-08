<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Cálculo do prazo de SLA das OS.
 *
 * - SLA com "horário comercial": conta só de segunda a sexta, dentro do
 *   expediente (padrão 08:00–18:00, ou o valor da configuração
 *   "sla_expediente" no formato HH:MM-HH:MM), pulando os feriados ativos
 *   (Cadastros > Feriados; os recorrentes valem todo ano).
 * - Sem horário comercial: horas corridas.
 */
class Sla
{
    private $CI;

    private $feriadosFixos = [];   // ['12-25' => true]

    private $feriadosData = [];    // ['2026-11-20' => true]

    private $inicioExpediente = '08:00';

    private $fimExpediente = '18:00';

    private $carregado = false;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    private function carregar()
    {
        if ($this->carregado) {
            return;
        }
        $this->carregado = true;

        if ($this->CI->db->table_exists('cad_feriados')) {
            foreach ($this->CI->db->where('ativo', 1)->get('cad_feriados')->result() as $f) {
                if ($f->recorrente) {
                    $this->feriadosFixos[substr($f->data, 5, 5)] = true;
                } else {
                    $this->feriadosData[$f->data] = true;
                }
            }
        }

        $cfg = $this->CI->db->where('config', 'sla_expediente')->get('configuracoes')->row();
        if ($cfg && preg_match('/^(\d{2}:\d{2})-(\d{2}:\d{2})$/', trim($cfg->valor), $m) && $m[1] < $m[2]) {
            $this->inicioExpediente = $m[1];
            $this->fimExpediente = $m[2];
        }
    }

    public function diaUtil(DateTime $d): bool
    {
        $this->carregar();
        if ((int) $d->format('N') >= 6) {
            return false;
        }

        return ! isset($this->feriadosFixos[$d->format('m-d')]) && ! isset($this->feriadosData[$d->format('Y-m-d')]);
    }

    /**
     * @param string $inicio    data/hora de abertura (Y-m-d H:i:s)
     * @param int    $horas     tempo de resolução do SLA
     * @param bool   $comercial contar só horário comercial
     *
     * @return string|null prazo (Y-m-d H:i:s)
     */
    public function calcularPrazo(?string $inicio, $horas, bool $comercial = true): ?string
    {
        $horas = (int) $horas;
        if (! $inicio || $horas <= 0) {
            return null;
        }

        try {
            $cursor = new DateTime($inicio);
        } catch (Exception $e) {
            return null;
        }

        if (! $comercial) {
            $cursor->modify("+{$horas} hours");

            return $cursor->format('Y-m-d H:i:s');
        }

        $this->carregar();
        [$hi, $mi] = array_map('intval', explode(':', $this->inicioExpediente));
        [$hf, $mf] = array_map('intval', explode(':', $this->fimExpediente));
        $restante = $horas * 60;

        for ($i = 0; $i < 3660 && $restante > 0; $i++) {
            $abre = (clone $cursor)->setTime($hi, $mi, 0);
            $fecha = (clone $cursor)->setTime($hf, $mf, 0);

            if (! $this->diaUtil($cursor) || $cursor >= $fecha) {
                $cursor = (clone $cursor)->modify('+1 day')->setTime($hi, $mi, 0);

                continue;
            }
            if ($cursor < $abre) {
                $cursor = $abre;
            }

            $disponivel = intdiv($fecha->getTimestamp() - $cursor->getTimestamp(), 60);
            if ($restante <= $disponivel) {
                $cursor->modify("+{$restante} minutes");
                $restante = 0;
            } else {
                $restante -= $disponivel;
                $cursor = (clone $cursor)->modify('+1 day')->setTime($hi, $mi, 0);
            }
        }

        return $cursor->format('Y-m-d H:i:s');
    }

    /**
     * Prazo de uma OS a partir do SLA escolhido.
     */
    public function prazoDaOs(?string $abertura, ?int $slaId): ?string
    {
        if (! $slaId || ! $this->CI->db->table_exists('cad_slas')) {
            return null;
        }
        $sla = $this->CI->db->where('id', $slaId)->get('cad_slas')->row();
        if (! $sla) {
            return null;
        }

        return $this->calcularPrazo($abertura ?: date('Y-m-d H:i:s'), (int) $sla->tempo_solucao, (bool) $sla->horario_comercial);
    }
}
