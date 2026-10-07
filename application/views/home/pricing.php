<section id="precos" class="mx-auto max-w-7xl px-6 py-16 lg:py-24">
  <div class="relative overflow-hidden rounded-[var(--radius-lg)] px-8 py-14 text-white sm:px-14" style="background-color: var(--color-topbar);">
    <div class="pointer-events-none absolute inset-0" style="background: radial-gradient(circle at 80% 20%, rgba(245,158,11,0.18), transparent 45%), radial-gradient(circle at 10% 80%, rgba(15,122,222,0.3), transparent 45%);"></div>

    <div class="relative max-w-xl">
      <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-bold uppercase tracking-wide">
        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/></svg>
        Comece hoje
      </span>
      <h2 class="font-title mt-5 text-3xl font-extrabold leading-tight sm:text-4xl">Leve o Zenydesk OS para a sua operação</h2>
      <p class="mt-3 text-white/70">Parte da plataforma Zenydesk — fale com o time comercial para um plano sob medida para o número de técnicos da sua equipe.</p>

      <ul class="mt-6 flex flex-col gap-2">
        <?php foreach ([
          'WhatsApp integrado para orçamento e OS',
          'Servidor próprio no Brasil, 100% LGPD',
          'Suporte humano em português brasileiro',
        ] as $item): ?>
          <li class="flex items-center gap-2 text-sm">
            <svg class="size-4 text-signal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            <?= htmlspecialchars($item) ?>
          </li>
        <?php endforeach; ?>
      </ul>

      <div class="mt-8 flex flex-wrap gap-4">
        <a href="<?= htmlspecialchars($login_url) ?>" class="btn btn-signal btn-lg">
          Acessar Zenydesk OS
          <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
        </a>
        <a href="<?= htmlspecialchars($whatsapp_url) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-dark btn-lg">Falar com o comercial</a>
      </div>
    </div>
  </div>
</section>
