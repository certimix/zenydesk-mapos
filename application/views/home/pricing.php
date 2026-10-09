<section id="precos" class="mx-auto max-w-7xl px-6 py-16 lg:py-24">
  <div class="mx-auto max-w-3xl text-center">
    <span class="badge badge-signal">Planos &amp; Investimento</span>
    <h2 class="font-title mt-4 text-3xl font-extrabold text-ink sm:text-4xl">Planos Claros e Escaláveis para a Sua Empresa</h2>
    <p class="mt-4 text-muted">
      Ordens de serviço ilimitadas, laudo fotográfico em conformidade legal (CDC Art. 27), banco de dados 100% isolado por cliente e ativação imediata via Pix oficial.
    </p>

    <!-- Seletor de Ciclo Mensal / Anual -->
    <div class="mt-8 inline-flex items-center gap-3 rounded-full border border-slate-200 bg-white p-1.5 shadow-sm">
      <button type="button" id="btn-ciclo-mensal" class="cycle-toggle active-cycle rounded-full px-5 py-2 text-xs font-bold transition-all" onclick="setCycle('mensal')">
        Mensal
      </button>
      <button type="button" id="btn-ciclo-anual" class="cycle-toggle rounded-full px-5 py-2 text-xs font-bold transition-all text-slate-600 hover:text-slate-900" onclick="setCycle('anual')">
        Anual
        <span class="ml-1.5 rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-800">Economize até 20%</span>
      </button>
    </div>
  </div>

  <!-- Grid de 4 Planos Oficiais ZenyDesk OS (Modelo SMDesk Adaptado) -->
  <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4 items-stretch">
    
    <!-- 1. Básico -->
    <div class="card flex flex-col justify-between border border-slate-200 bg-white p-6 shadow-sm transition-all hover:shadow-md">
      <div>
        <div class="flex items-center justify-between">
          <span class="badge badge-tint">Básico</span>
          <span class="text-xs font-semibold text-muted">Até 4 usuários</span>
        </div>
        <h3 class="font-title mt-4 text-xl font-bold text-ink">Básico</h3>
        <p class="mt-1 text-xs text-muted">Para organizar a rotina inicial de atendimento e OS da equipe.</p>
        
        <div class="mt-6 border-y border-slate-100 py-4">
          <div class="flex items-baseline gap-1">
            <span class="text-xs font-bold text-muted">R$</span>
            <span class="font-title text-3xl font-extrabold text-ink price-val" data-mensal="247" data-anual="197">247</span>
            <span class="text-xs font-semibold text-muted">/mês</span>
          </div>
          <p class="mt-1 text-[11px] text-muted cycle-subtext" data-mensal="Cobrança mensal recorrente" data-anual="Faturado R$ 2.364/ano no Pix">Cobrança mensal recorrente</p>
        </div>

        <ul class="mt-6 flex flex-col gap-2.5 text-xs text-ink/80">
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span><strong>Até 4 usuários</strong> simultâneos</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span><strong>3 GB</strong> de armazenamento em nuvem</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Ordens de Serviço digitais ilimitadas</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Busca automática de CNPJ na Receita</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Fotos com guarda de 5 anos (CDC Art. 27)</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Impressão térmica 80mm e relatório A4</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Portal do cliente com QR Code</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Suporte prioritário via tickets</span>
          </li>
        </ul>
      </div>

      <div class="mt-8 pt-4">
        <button type="button" onclick="abrirCheckout('basico', 'Básico (até 4 usuários)', 247, 2364)" class="btn btn-outline w-full text-xs font-bold py-2.5">
          Assinar Básico
        </button>
      </div>
    </div>

    <!-- 2. Profissional (Destaque Mais Escolhido) -->
    <div class="card relative flex flex-col justify-between rounded-2xl border-2 border-amber-500 bg-white p-6 shadow-xl ring-2 ring-amber-500/10">
      <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 rounded-full bg-gradient-to-r from-amber-500 to-orange-500 px-3.5 py-1 text-[10px] font-extrabold uppercase tracking-wider text-white shadow-md flex items-center gap-1.5">
        <svg class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
        Mais Escolhido
      </div>

      <div>
        <div class="flex items-center justify-between">
          <span class="badge badge-signal">Profissional</span>
          <span class="text-xs font-semibold text-amber-700">Até 10 usuários</span>
        </div>
        <h3 class="font-title mt-4 text-xl font-bold text-ink">Profissional</h3>
        <p class="mt-1 text-xs text-muted">Para equipes em crescimento que precisam de velocidade e controle.</p>
        
        <div class="mt-6 border-y border-slate-100 py-4">
          <div class="flex items-baseline gap-1">
            <span class="text-xs font-bold text-amber-600">R$</span>
            <span class="font-title text-3xl font-extrabold text-ink price-val" data-mensal="497" data-anual="397">497</span>
            <span class="text-xs font-semibold text-muted">/mês</span>
          </div>
          <p class="mt-1 text-[11px] text-muted cycle-subtext" data-mensal="Cobrança mensal recorrente" data-anual="Faturado R$ 4.764/ano no Pix">Cobrança mensal recorrente</p>
        </div>

        <ul class="mt-6 flex flex-col gap-2.5 text-xs text-ink/80">
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span><strong>Até 10 usuários</strong> simultâneos</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span><strong>5 GB</strong> de armazenamento em nuvem</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Tudo incluído no plano Básico</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Controle financeiro e fluxo de caixa</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Gestão de estoque com alerta mínimo</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Múltiplos técnicos atribuídos por O.S</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Termos de garantia personalizados</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Suporte humano prioritário via WhatsApp</span>
          </li>
        </ul>
      </div>

      <div class="mt-8 pt-4">
        <button type="button" onclick="abrirCheckout('profissional', 'Profissional (até 10 usuários)', 497, 4764)" class="btn btn-signal w-full text-xs font-bold py-2.5 shadow-md">
          Assinar Profissional
        </button>
      </div>
    </div>

    <!-- 3. Avançado -->
    <div class="card flex flex-col justify-between border border-slate-200 bg-white p-6 shadow-sm transition-all hover:shadow-md">
      <div>
        <div class="flex items-center justify-between">
          <span class="badge badge-default">Avançado</span>
          <span class="text-xs font-semibold text-muted">Até 25 usuários</span>
        </div>
        <h3 class="font-title mt-4 text-xl font-bold text-ink">Avançado</h3>
        <p class="mt-1 text-xs text-muted">Para operações maiores com campo, acompanhamento e escala.</p>
        
        <div class="mt-6 border-y border-slate-100 py-4">
          <div class="flex items-baseline gap-1">
            <span class="text-xs font-bold text-muted">R$</span>
            <span class="font-title text-3xl font-extrabold text-ink price-val" data-mensal="897" data-anual="797">897</span>
            <span class="text-xs font-semibold text-muted">/mês</span>
          </div>
          <p class="mt-1 text-[11px] text-muted cycle-subtext" data-mensal="Cobrança mensal recorrente" data-anual="Faturado R$ 9.564/ano no Pix">Cobrança mensal recorrente</p>
        </div>

        <ul class="mt-6 flex flex-col gap-2.5 text-xs text-ink/80">
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span><strong>Até 25 usuários</strong> simultâneos</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span><strong>15 GB</strong> de armazenamento em nuvem</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Tudo incluído no plano Profissional</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Faturamento em lote e NFS-e</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Relatórios avançados de rentabilidade</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Auditoria detalhada e logs de técnicos</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Histórico completo de equipamentos</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>SLA prioritário e onboarding assistido</span>
          </li>
        </ul>
      </div>

      <div class="mt-8 pt-4">
        <button type="button" onclick="abrirCheckout('avancado', 'Avançado (até 25 usuários)', 897, 9564)" class="btn btn-outline w-full text-xs font-bold py-2.5">
          Assinar Avançado
        </button>
      </div>
    </div>

    <!-- 4. Enterprise -->
    <div class="card flex flex-col justify-between border border-slate-200 bg-slate-900 text-white p-6 shadow-sm">
      <div>
        <div class="flex items-center justify-between">
          <span class="badge badge-dark">Enterprise</span>
          <span class="text-xs font-semibold text-slate-300">50 a 100+ usuários</span>
        </div>
        <h3 class="font-title mt-4 text-xl font-bold text-white">Enterprise</h3>
        <p class="mt-1 text-xs text-slate-400">Para redes, franquias e grandes operações corporativas.</p>
        
        <div class="mt-6 border-y border-slate-800 py-4">
          <div class="flex items-baseline gap-1">
            <span class="font-title text-2xl font-extrabold text-white">Sob Consulta</span>
          </div>
          <p class="mt-1 text-[11px] text-slate-400">Projetos customizados com contrato e SLA</p>
        </div>

        <ul class="mt-6 flex flex-col gap-2.5 text-xs text-slate-300">
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span><strong>50 a 100+ usuários</strong> liberados</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span><strong>50 GB+</strong> de armazenamento dedicado</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Domínio próprio personalizado</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Servidor e banco de dados dedicados</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Treinamento e migração de dados assistida</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>SLA contratual de 99.9% de uptime</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Gerente de contas dedicado</span>
          </li>
        </ul>
      </div>

      <div class="mt-8 pt-4">
        <a href="<?= htmlspecialchars($whatsapp_url) ?>&text=Ol%C3%A1!+Gostaria+de+um+or%C3%A7amento+para+o+plano+Enterprise+do+ZenyDesk+OS" target="_blank" rel="noopener noreferrer" class="btn btn-outline-dark w-full text-xs font-bold py-2.5">
          Falar com Especialista
        </a>
      </div>
    </div>

  </div>

  <!-- Modal de Checkout Direto (Totalmente Real e Operacional) -->
  <div id="checkout-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm transition-opacity">
    <div class="relative w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl max-h-[92vh] overflow-y-auto">
      
      <!-- Botão Fechar -->
      <button type="button" onclick="fecharCheckout()" class="absolute right-4 top-4 rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-700">
        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>

      <!-- Etapa 1: Formulário de Contratação -->
      <div id="checkout-etapa-form">
        <div class="flex items-center gap-2">
          <span class="badge badge-signal">Contratação Direta</span>
          <span class="text-xs font-semibold text-emerald-600 flex items-center gap-1">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Ativação Imediata
          </span>
        </div>
        
        <h3 class="font-title mt-2 text-2xl font-extrabold text-ink" id="modal-plano-nome">Assinar Plano</h3>
        <p class="text-xs text-muted">Informe os dados da sua empresa para reservar o seu subdomínio exclusivo e gerar o Pix.</p>

        <!-- Resumo do Valor -->
        <div class="mt-4 flex items-center justify-between rounded-xl bg-slate-50 p-3.5 border border-slate-200">
          <div>
            <span class="text-[11px] font-bold uppercase tracking-wider text-muted">Total a Pagar</span>
            <div class="font-title text-xl font-extrabold text-emerald-600" id="modal-valor-total">R$ 247,00</div>
          </div>
          <span class="badge badge-tint" id="modal-ciclo-tag">Plano Mensal</span>
        </div>

        <form id="form-assinar" onsubmit="enviarAssinatura(event)" class="mt-5 flex flex-col gap-3.5 text-left">
          <input type="hidden" id="input-plano" name="plano" value="basico">
          <input type="hidden" id="input-ciclo" name="ciclo" value="mensal">

          <!-- Subdomínio Exclusivo -->
          <div>
            <label for="subdominio" class="block text-xs font-bold text-slate-700 mb-1">
              Subdomínio Exclusivo Desejado <span class="text-red-500">*</span>
            </label>
            <div class="flex items-center rounded-lg border border-slate-300 focus-within:border-primary focus-within:ring-1 focus-within:ring-primary overflow-hidden">
              <input type="text" id="subdominio" name="subdominio" required placeholder="suaempresa"
                     class="w-full px-3 py-2 text-xs font-semibold text-slate-800 placeholder-slate-400 outline-none"
                     oninput="sanitizarSubdominio(this)">
              <span class="bg-slate-100 px-3 py-2 text-xs font-medium text-slate-500 border-l border-slate-300 select-none">
                .os.zenydesk.com
              </span>
            </div>
            <p class="mt-1 text-[10px] text-muted">Apenas letras, números e traço. Ex: certimix, oficinax, eletro-silva.</p>
          </div>

          <!-- Nome da Empresa -->
          <div>
            <label for="nome_empresa" class="block text-xs font-bold text-slate-700 mb-1">
              Razão Social ou Nome Fantasia <span class="text-red-500">*</span>
            </label>
            <input type="text" id="nome_empresa" name="nome_empresa" required placeholder="Silva Assistência Técnica LTDA"
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs text-slate-800 placeholder-slate-400 outline-none focus:border-primary focus:ring-1 focus:ring-primary">
          </div>

          <!-- Responsável e E-mail em 2 colunas -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
              <label for="responsavel" class="block text-xs font-bold text-slate-700 mb-1">
                Nome do Responsável <span class="text-red-500">*</span>
              </label>
              <input type="text" id="responsavel" name="responsavel" required placeholder="Carlos Silva"
                     class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs text-slate-800 placeholder-slate-400 outline-none focus:border-primary focus:ring-1 focus:ring-primary">
            </div>
            <div>
              <label for="email" class="block text-xs font-bold text-slate-700 mb-1">
                E-mail Corporativo <span class="text-red-500">*</span>
              </label>
              <input type="email" id="email" name="email" required placeholder="contato@empresa.com.br"
                     class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs text-slate-800 placeholder-slate-400 outline-none focus:border-primary focus:ring-1 focus:ring-primary">
            </div>
          </div>

          <!-- Telefone e CPF/CNPJ em 2 colunas -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
              <label for="telefone" class="block text-xs font-bold text-slate-700 mb-1">
                WhatsApp / Telefone <span class="text-red-500">*</span>
              </label>
              <input type="text" id="telefone" name="telefone" required placeholder="(11) 99999-9999"
                     class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs text-slate-800 placeholder-slate-400 outline-none focus:border-primary focus:ring-1 focus:ring-primary">
            </div>
            <div>
              <label for="cpf_cnpj" class="block text-xs font-bold text-slate-700 mb-1">
                CNPJ ou CPF do Titular <span class="text-red-500">*</span>
              </label>
              <input type="text" id="cpf_cnpj" name="cpf_cnpj" required placeholder="00.000.000/0001-00"
                     class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs text-slate-800 placeholder-slate-400 outline-none focus:border-primary focus:ring-1 focus:ring-primary">
            </div>
          </div>

          <div id="checkout-erro" class="hidden rounded-lg bg-red-50 p-2.5 text-xs text-red-700 border border-red-200"></div>

          <div class="mt-3">
            <button type="submit" id="btn-submit-assinar" class="btn btn-signal w-full text-xs font-bold py-3 shadow-md flex items-center justify-center gap-2">
              <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
              <span>Gerar Pix para Ativação Imediata</span>
            </button>
            <p class="mt-2 text-center text-[10px] text-muted">
              Ambiente Seguro com Criptografia • Chave Pix Oficial BACEN • Sem carência
            </p>
          </div>
        </form>
      </div>

      <!-- Etapa 2: Exibição do QR Code Pix Real & Copia e Cola -->
      <div id="checkout-etapa-pix" class="hidden text-center">
        <div class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">
          <span class="size-2 rounded-full bg-emerald-500 animate-pulse"></span>
          Pix Gerado — Aguardando Pagamento
        </div>

        <h3 class="font-title mt-3 text-xl font-extrabold text-ink" id="pix-plano-titulo">Plano Básico</h3>
        <p class="text-xs text-muted">Escaneie o QR Code abaixo no app do seu banco ou utilize o código Copia e Cola.</p>

        <!-- QR Code Real -->
        <div class="mt-4 flex flex-col items-center justify-center">
          <div class="rounded-2xl border-2 border-slate-200 bg-white p-3 shadow-md inline-block">
            <img id="pix-qrcode-img" src="" alt="QR Code Pix Oficial" class="size-52 object-contain mx-auto" />
          </div>
          <div class="mt-2 text-xs font-bold text-slate-800">
            Valor: <span class="text-emerald-600 text-base" id="pix-valor-display">R$ 0,00</span>
          </div>
          <p class="text-[11px] text-muted">Beneficiário: <strong id="pix-beneficiario-display">ZENYDESK OS TECNOLOGIA</strong></p>
          <p class="text-[11px] text-slate-600">Subdomínio reservado: <code class="font-mono text-primary font-bold" id="pix-subdominio-display">empresa.os.zenydesk.com</code></p>
        </div>

        <!-- Copia e Cola -->
        <div class="mt-4 text-left">
          <label class="block text-xs font-bold text-slate-700 mb-1">Código Pix Copia e Cola</label>
          <div class="flex items-center gap-2">
            <input type="text" id="pix-copia-cola" readonly
                   class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 text-xs font-mono text-slate-700 outline-none select-all">
            <button type="button" id="btn-copiar-pix" onclick="copiarPix()" class="btn btn-primary shrink-0 px-4 py-2 text-xs font-bold">
              Copiar
            </button>
          </div>
        </div>

        <!-- Instruções -->
        <div class="mt-5 rounded-xl bg-slate-50 p-3 text-left border border-slate-200 text-xs text-slate-700">
          <div class="font-bold flex items-center gap-1.5 text-slate-800 mb-1">
            <svg class="size-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            Como funciona a liberação?
          </div>
          <p class="text-[11px] text-slate-600 leading-relaxed">
            Assim que a transferência for compensada pelo Banco Central, o seu subdomínio será ativado. Você também pode acelerar o processo enviando o comprovante diretamente para a nossa equipe no WhatsApp.
          </p>
        </div>

        <div class="mt-5 flex flex-col sm:flex-row gap-2">
          <a id="btn-confirmar-whatsapp" href="#" target="_blank" rel="noopener noreferrer" class="btn btn-signal flex-1 text-xs font-bold py-2.5">
            Já Paguei / Enviar Comprovante
          </a>
          <button type="button" onclick="fecharCheckout()" class="btn btn-outline text-xs font-bold py-2.5">
            Fechar
          </button>
        </div>
      </div>

    </div>
  </div>
</section>

<style>
.active-cycle {
  background-color: var(--color-ink, #0f172a) !important;
  color: #ffffff !important;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}
</style>

<script>
var cicloAtual = 'mensal';
var planosValores = {
  basico: { mensal: 247, anual: 2364 },
  profissional: { mensal: 497, anual: 4764 },
  avancado: { mensal: 897, anual: 9564 }
};

function setCycle(ciclo) {
  cicloAtual = ciclo;
  var btnMensal = document.getElementById('btn-ciclo-mensal');
  var btnAnual = document.getElementById('btn-ciclo-anual');
  
  if (ciclo === 'mensal') {
    btnMensal.classList.add('active-cycle');
    btnMensal.classList.remove('text-slate-600');
    btnAnual.classList.remove('active-cycle');
    btnAnual.classList.add('text-slate-600');
  } else {
    btnAnual.classList.add('active-cycle');
    btnAnual.classList.remove('text-slate-600');
    btnMensal.classList.remove('active-cycle');
    btnMensal.classList.add('text-slate-600');
  }

  document.querySelectorAll('.price-val').forEach(function(el) {
    el.textContent = el.getAttribute('data-' + ciclo);
  });

  document.querySelectorAll('.cycle-subtext').forEach(function(el) {
    el.textContent = el.getAttribute('data-' + ciclo);
  });
}

function sanitizarSubdominio(input) {
  input.value = input.value.toLowerCase().replace(/[^a-z0-9-]/g, '');
}

function abrirCheckout(planoKey, planoNome, valorMensal, valorAnual) {
  var modal = document.getElementById('checkout-modal');
  var etapaForm = document.getElementById('checkout-etapa-form');
  var etapaPix = document.getElementById('checkout-etapa-pix');
  var erroBox = document.getElementById('checkout-erro');
  
  erroBox.classList.add('hidden');
  erroBox.textContent = '';
  etapaForm.classList.remove('hidden');
  etapaPix.classList.add('hidden');

  document.getElementById('input-plano').value = planoKey;
  document.getElementById('input-ciclo').value = cicloAtual;
  document.getElementById('modal-plano-nome').textContent = planoNome;

  var valor = cicloAtual === 'anual' ? valorAnual : valorMensal;
  document.getElementById('modal-valor-total').textContent = 'R$ ' + valor.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
  document.getElementById('modal-ciclo-tag').textContent = cicloAtual === 'anual' ? 'Plano Anual' : 'Plano Mensal';

  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function fecharCheckout() {
  var modal = document.getElementById('checkout-modal');
  modal.classList.add('hidden');
  modal.classList.remove('flex');
}

function enviarAssinatura(event) {
  event.preventDefault();
  var btn = document.getElementById('btn-submit-assinar');
  var erroBox = document.getElementById('checkout-erro');
  var form = document.getElementById('form-assinar');
  
  erroBox.classList.add('hidden');
  erroBox.textContent = '';
  btn.disabled = true;
  btn.innerHTML = '<svg class="size-4 animate-spin inline mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-width="4" stroke="currentColor" stroke-dasharray="32" stroke-linecap="round"/></svg> Gerando Pix Oficial...';

  var formData = new FormData(form);

  fetch('<?= site_url("home/assinar") ?>', {
    method: 'POST',
    body: formData
  })
  .then(function(res) {
    return res.json();
  })
  .then(function(data) {
    btn.disabled = false;
    btn.innerHTML = '<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg> <span>Gerar Pix para Ativação Imediata</span>';

    if (!data.success) {
      erroBox.textContent = data.error || 'Ocorreu um erro ao gerar a cobrança Pix. Verifique os dados.';
      erroBox.classList.remove('hidden');
      return;
    }

    // Exibe a tela de pagamento Pix
    document.getElementById('checkout-etapa-form').classList.add('hidden');
    document.getElementById('checkout-etapa-pix').classList.remove('hidden');

    document.getElementById('pix-plano-titulo').textContent = data.planoNome + ' (' + (data.ciclo === 'anual' ? 'Anual' : 'Mensal') + ')';
    document.getElementById('pix-valor-display').textContent = data.valorFormatado;
    document.getElementById('pix-subdominio-display').textContent = data.subdominio + '.os.zenydesk.com';
    document.getElementById('pix-beneficiario-display').textContent = data.beneficiario || 'Asaas Gestão Financeira S.A. (Banco 461) - ZenyDesk';
    
    // QR Code dinâmico do Pix oficial do Asaas
    var qrUrl = data.qrBase64 ? data.qrBase64 : ('https://api.qrserver.com/v1/create-qr-code/?size=260x260&margin=8&data=' + encodeURIComponent(data.copyPaste));
    document.getElementById('pix-qrcode-img').src = qrUrl;
    document.getElementById('pix-copia-cola').value = data.copyPaste;

    // Link para WhatsApp com os dados da transação
    var zapMsg = encodeURIComponent('Olá! Acabei de gerar o Pix para o ZenyDesk OS no subdomínio: ' + data.subdominio + '.os.zenydesk.com (' + data.planoNome + ' - ' + data.valorFormatado + '). Segue o comprovante:');
    document.getElementById('btn-confirmar-whatsapp').href = 'https://wa.me/5575998626311?text=' + zapMsg;
  })
  .catch(function(err) {
    btn.disabled = false;
    btn.innerHTML = 'Gerar Pix para Ativação Imediata';
    erroBox.textContent = 'Falha de comunicação com o servidor. Verifique sua conexão e tente novamente.';
    erroBox.classList.remove('hidden');
  });
}

function copiarPix() {
  var input = document.getElementById('pix-copia-cola');
  input.select();
  input.setSelectionRange(0, 99999);
  
  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard.writeText(input.value).then(function() {
      feedbackCopia();
    });
  } else {
    document.execCommand('copy');
    feedbackCopia();
  }
}

function feedbackCopia() {
  var btn = document.getElementById('btn-copiar-pix');
  var originalText = btn.textContent;
  btn.textContent = 'Copiado! ✓';
  btn.classList.add('bg-emerald-600');
  setTimeout(function() {
    btn.textContent = originalText;
    btn.classList.remove('bg-emerald-600');
  }, 2500);
}
</script>
