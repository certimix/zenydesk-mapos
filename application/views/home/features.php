<?php
$features = [
  [
    'icon' => '<rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M9 14h.01"/><path d="M9 18h.01"/><path d="M13 14h2"/><path d="M13 18h2"/>',
    'title' => 'Clientes, produtos e serviços',
    'description' => 'Cadastro único de clientes/fornecedores, produtos e serviços, com todo o histórico de OS e vendas à mão.',
  ],
  [
    'icon' => '<path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3Z"/><circle cx="12" cy="13" r="3"/>',
    'title' => 'Laudo com foto e termo de garantia',
    'description' => 'Técnico registra o laudo com fotos direto do campo e emite o termo de garantia automaticamente.',
  ],
  [
    'icon' => '<rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/>',
    'title' => 'Financeiro e cobranças',
    'description' => 'Lançamentos, cobranças e saldo em tempo real, com OS em orçamento, aberto, aprovada ou finalizada num painel só.',
  ],
];
?>
<section id="funcionalidades" class="mx-auto max-w-7xl px-6 py-16 lg:py-24">
  <div class="mx-auto max-w-2xl text-center">
    <span class="badge badge-default">Zenydesk OS</span>
    <h2 class="font-title mt-4 text-3xl font-extrabold text-ink sm:text-4xl">Você no controle de cada ordem de serviço</h2>
    <p class="mt-4 text-muted">Veja o que está em aberto, atrasado ou perto de vencer a garantia — tudo em um só lugar.</p>
  </div>

  <div class="mt-12 grid gap-6 md:grid-cols-3">
    <?php foreach ($features as $f): ?>
      <div class="card">
        <span class="flex size-12 items-center justify-center rounded-[var(--radius-md)] bg-tint text-primary">
          <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?= $f['icon'] ?></svg>
        </span>
        <h3 class="font-title text-lg font-bold text-ink"><?= htmlspecialchars($f['title']) ?></h3>
        <p class="text-sm leading-relaxed text-muted"><?= htmlspecialchars($f['description']) ?></p>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="card mt-6 grid gap-10 overflow-hidden p-0 lg:grid-cols-2">
    <div class="flex flex-col justify-center gap-5 p-8 lg:p-12">
      <div class="flex items-center gap-3">
        <span class="flex size-10 items-center justify-center rounded-[var(--radius-md)] bg-tint text-primary">
          <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </span>
        <span class="badge badge-signal">Orçamento automático</span>
      </div>
      <h3 class="font-title text-2xl font-extrabold leading-tight text-ink sm:text-3xl">Mais ordens de serviço fechadas por dia, sem ligação nem papel</h3>
      <ul class="flex flex-col gap-3">
        <li class="flex items-center gap-3 text-sm font-medium text-ink">
          <svg class="size-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 4-3 1-3-1-3 1v15l3-1 3 1 3-1 3 1V5l-3 1z"/></svg>
          Orçamento gerado automaticamente a partir do laudo
        </li>
        <li class="flex items-center gap-3 text-sm font-medium text-ink">
          <svg class="size-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
          Envio do orçamento e da OS direto pelo WhatsApp
        </li>
        <li class="flex items-center gap-3 text-sm font-medium text-ink">
          <svg class="size-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11H5a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2h-4"/><path d="m9 11 3-7 3 7"/><path d="M9 11h6"/></svg>
          Aprovação do cliente com um clique, sem ligação
        </li>
      </ul>
      <a href="<?= htmlspecialchars($login_url) ?>" class="btn btn-primary mt-2 w-fit">
        Acessar Zenydesk OS
        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
      </a>
    </div>
    <div class="relative hidden min-h-[320px] lg:flex lg:items-center lg:justify-center" style="background: linear-gradient(160deg, var(--color-paper) 0%, var(--color-tint) 100%);">
      <div class="flex size-44 items-center justify-center rounded-full text-white" style="background-image: var(--gradient-primary); box-shadow: var(--shadow-lg);">
        <svg class="size-20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/></svg>
      </div>
    </div>
  </div>
</section>
