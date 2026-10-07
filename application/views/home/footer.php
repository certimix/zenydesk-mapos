
</main>

<footer class="text-white" style="background-color: var(--color-topbar);">
  <div class="h-1" style="background-image: var(--gradient-signal);"></div>
  <div class="mx-auto grid max-w-7xl gap-10 px-6 py-16 sm:grid-cols-2 lg:grid-cols-4">
    <div>
      <img src="<?= base_url('assets/img/logo-zenydesk.png') ?>" alt="Zenydesk" class="h-7 w-auto" />
      <p class="mt-4 text-sm text-white/60">Plataforma corporativa de acesso remoto dual, service desk e gestão de TI com infraestrutura própria.</p>
    </div>

    <div>
      <h4 class="font-title text-sm font-bold">Ecossistema Zenydesk</h4>
      <ul class="mt-3 flex flex-col gap-2 text-sm text-white/60">
        <li><a href="https://zenydesk.com/" class="hover:text-white">Acesso remoto</a></li>
        <li><a href="<?= base_url() ?>" class="hover:text-white">Zenydesk OS (ordens de serviço)</a></li>
        <li><a href="https://zenydesk.com/#modulo-fiscal" class="hover:text-white">ZD-Supermercado ERP &amp; PDV</a></li>
        <li><a href="https://zenydesk.com/#zdnostr" class="hover:text-white">ZDNostr Chat E2EE</a></li>
      </ul>
    </div>

    <div>
      <h4 class="font-title text-sm font-bold">Endereço &amp; sede</h4>
      <p class="mt-3 flex items-start gap-2 text-sm text-white/60">
        <svg class="mt-0.5 size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
        R. Salustiano Domingos de Santana, 268 — Centro, Paripiranga - BA, CEP 48430-033
      </p>
    </div>

    <div>
      <h4 class="font-title text-sm font-bold">Contato comercial</h4>
      <p class="mt-3 flex items-center gap-2 text-sm text-white/60">
        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        (75) 99862-6311
      </p>
      <p class="mt-2 flex items-center gap-2 text-sm text-white/60">
        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 5L2 7"/></svg>
        atendimento@certimix.com.br
      </p>
    </div>
  </div>

  <div class="border-t border-white/10 px-6 py-6 text-center text-xs text-white/40">
    © <?= date('Y') ?> CERTIMIX (CHL COMPANHIA DIGITAL LTDA). CNPJ 35.624.635/0001-44. Conforme a LGPD (Lei nº 13.709/2018).
  </div>
</footer>

<a href="<?= htmlspecialchars($whatsapp_url) ?>" target="_blank" rel="noopener noreferrer"
   class="fixed bottom-6 right-6 z-50 flex size-14 items-center justify-center rounded-full bg-online text-white transition-transform hover:scale-105"
   style="box-shadow: var(--shadow-lg);" aria-label="Falar no WhatsApp">
  <svg class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
</a>

<script src="<?= base_url('assets/landing/js/main.js') ?>"></script>
</body>
</html>
