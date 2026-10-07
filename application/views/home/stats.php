<?php
$stats = [
  [
    'icon' => '<path d="M13 2 3 14h9l-1 8 10-12h-9z"/>',
    'value' => '72%',
    'title' => 'querem atendimento imediato',
    'description' => 'A espera por retorno é o motivo nº 1 de desistência. Reduza o tempo de resposta com triagem e distribuição automáticas de chamados.',
  ],
  [
    'icon' => '<polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/>',
    'value' => '7x',
    'title' => 'mais chances de fechar o orçamento',
    'description' => 'Orçamentos enviados em até uma hora, direto no WhatsApp do cliente, multiplicam a taxa de aprovação da OS.',
  ],
  [
    'icon' => '<path d="M18 20V10"/><path d="M12 20V4"/><path d="M6 20v-6"/>',
    'value' => '80%',
    'title' => 'trocam de fornecedor após duas falhas',
    'description' => 'Histórico completo por cliente e prazos de SLA monitorados evitam que a mesma experiência ruim se repita.',
  ],
];
?>
<section class="mx-auto max-w-7xl px-6 py-16 lg:py-20">
  <div class="grid gap-6 md:grid-cols-3">
    <?php foreach ($stats as $s): ?>
      <div class="card gap-3">
        <div class="flex items-center justify-between">
          <span class="font-title text-4xl font-extrabold text-primary"><?= $s['value'] ?></span>
          <svg class="size-6 text-primary/60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?= $s['icon'] ?></svg>
        </div>
        <h3 class="text-lg font-bold text-ink"><?= htmlspecialchars($s['title']) ?></h3>
        <p class="text-sm leading-relaxed text-muted"><?= htmlspecialchars($s['description']) ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>
