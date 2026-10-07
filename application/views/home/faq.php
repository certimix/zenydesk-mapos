<?php
$faqs = [
  [
    'q' => 'O que é o Zenydesk OS?',
    'a' => 'É o módulo de ordens de serviço da plataforma Zenydesk: cadastro de clientes e produtos, abertura de OS, laudo com foto, termo de garantia, orçamento automático, financeiro e cobranças, com atendimento integrado ao WhatsApp.',
  ],
  [
    'q' => 'O Zenydesk OS funciona junto com o acesso remoto?',
    'a' => 'Sim. A plataforma Zenydesk integra acesso remoto (substituto do AnyDesk/TeamViewer), gestão de OS e módulo fiscal no mesmo ecossistema, com servidor próprio no Brasil.',
  ],
  [
    'q' => 'Como funciona o orçamento automático?',
    'a' => 'A partir do laudo preenchido pelo técnico, o sistema monta o orçamento e envia direto no WhatsApp do cliente, que aprova com um clique.',
  ],
  [
    'q' => 'Existe alerta de SLA e garantia?',
    'a' => 'Sim, cada tipo de chamado tem um SLA configurável com alerta antes de vencer, e o prazo de garantia fica vinculado à OS e ao termo emitido.',
  ],
  [
    'q' => 'Os dados ficam em servidor no Brasil?',
    'a' => 'Sim, toda a infraestrutura roda em servidor próprio no Brasil, em conformidade com a LGPD.',
  ],
  [
    'q' => 'Dá para acompanhar o financeiro das OS?',
    'a' => 'Sim, o painel de lançamentos mostra receitas, despesas e saldo por OS, além das cobranças em aberto por cliente.',
  ],
];
?>
<section id="faq" class="mx-auto max-w-5xl px-6 py-16 lg:py-24">
  <div class="text-center">
    <span class="badge badge-tint">Dúvidas</span>
    <h2 class="font-title mt-4 text-3xl font-extrabold text-ink sm:text-4xl">Perguntas frequentes</h2>
  </div>

  <div class="mt-10 grid gap-x-10 sm:grid-cols-2">
    <?php foreach ($faqs as $item): ?>
      <details class="faq-item">
        <summary>
          <?= htmlspecialchars($item['q']) ?>
          <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
        </summary>
        <p class="faq-answer"><?= htmlspecialchars($item['a']) ?></p>
      </details>
    <?php endforeach; ?>
  </div>
</section>
