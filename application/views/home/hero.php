<section class="relative overflow-hidden text-white" style="background-color: var(--color-topbar);">
  <div class="pointer-events-none absolute inset-0 opacity-50" style="background: radial-gradient(circle at 15% 10%, rgba(15,122,222,0.35), transparent 45%), radial-gradient(circle at 85% 30%, rgba(245,158,11,0.18), transparent 40%);"></div>
  <div class="relative mx-auto grid max-w-7xl gap-12 px-6 py-20 lg:grid-cols-2 lg:items-center lg:py-28">
    <div>
      <span class="badge badge-dark">Zenydesk OS · Ordens de serviço &amp; atendimento</span>

      <h1 class="font-title mt-6 text-4xl font-extrabold leading-[1.08] sm:text-5xl lg:text-[3.1rem]">
        Atenda mais rápido, feche mais ordens de serviço e não perca mais cliente
      </h1>

      <p class="mt-6 max-w-lg text-lg text-white/70">
        Clientes, produtos, serviços, orçamento e garantia em um só lugar
        — com atendimento por WhatsApp integrado ao Zenydesk OS.
      </p>

      <div class="mt-8 flex flex-wrap items-center gap-4">
        <a href="<?= htmlspecialchars($login_url) ?>" class="btn btn-signal btn-lg">
          Acessar Zenydesk OS
          <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
        </a>
        <a href="#faq" class="btn btn-outline-dark btn-lg">Ver demonstração</a>
      </div>

      <p class="mt-10 text-sm text-white/50">
        Parte da plataforma Zenydesk — acesso remoto, service desk e
        gestão de TI com infraestrutura própria no Brasil.
      </p>
    </div>

    <div class="relative hidden lg:block">
      <div class="relative mx-auto aspect-square w-full max-w-md rounded-[var(--radius-lg)] bg-white/[0.06] ring-1 ring-white/10" style="backdrop-filter: blur(4px);">
        <div class="absolute inset-6 flex flex-col justify-center gap-4">
          <div class="flex items-start gap-3 rounded-2xl bg-white p-4 text-ink" style="box-shadow: var(--shadow-lg);">
            <span class="flex size-8 shrink-0 items-center justify-center rounded-full text-white bg-online">
              <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </span>
            <div>
              <p class="text-sm font-medium leading-snug">Olá! Preciso abrir um chamado técnico.</p>
              <span class="text-xs text-muted">10:24</span>
            </div>
          </div>
          <div class="flex items-start gap-3 rounded-2xl bg-white p-4 text-ink ml-8" style="box-shadow: var(--shadow-lg);">
            <span class="flex size-8 shrink-0 items-center justify-center rounded-full text-white bg-primary">
              <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
            </span>
            <div>
              <p class="text-sm font-medium leading-snug">O orçamento já foi enviado no WhatsApp.</p>
              <span class="text-xs text-muted">11:03</span>
            </div>
          </div>
          <div class="flex items-start gap-3 rounded-2xl bg-white p-4 text-ink" style="box-shadow: var(--shadow-lg);">
            <span class="flex size-8 shrink-0 items-center justify-center rounded-full text-white bg-signal">
              <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3Z"/><circle cx="12" cy="13" r="3"/></svg>
            </span>
            <div>
              <p class="text-sm font-medium leading-snug">Segue o laudo com foto da manutenção.</p>
              <span class="text-xs text-muted">11:27</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
