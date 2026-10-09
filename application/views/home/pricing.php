<section id="precos" class="mx-auto max-w-7xl px-6 py-16 lg:py-24">
  <div class="mx-auto max-w-3xl text-center">
    <span class="badge badge-signal">Planos &amp; Investimento</span>
    <h2 class="font-title mt-4 text-3xl font-extrabold text-ink sm:text-4xl">Planos Claros e Escaláveis para a Sua Empresa</h2>
    <p class="mt-4 text-muted">
      Ordens de serviço ilimitadas, laudo fotográfico em conformidade legal (CDC Art. 27), banco de dados 100% isolado por cliente e ativação imediata via Pix oficial.
    </p>

    <!-- Seletor de Ciclo Mensal / Anual -->
    <div class="pricing-toggle-container">
      <button type="button" id="btn-ciclo-mensal" class="cycle-btn active" onclick="setCycle('mensal')">
        Mensal
      </button>
      <button type="button" id="btn-ciclo-anual" class="cycle-btn" onclick="setCycle('anual')">
        <span>Anual</span>
        <span class="discount-pill">Economize até 20%</span>
      </button>
    </div>
  </div>

  <!-- Grid de 4 Planos Oficiais ZenyDesk OS -->
  <div class="pricing-grid">
    
    <!-- 1. Básico -->
    <div class="pricing-card pricing-card-default">
      <div>
        <div class="flex items-center justify-between">
          <span class="badge badge-tint">Básico</span>
          <span class="text-xs font-semibold text-muted">Até 4 usuários</span>
        </div>
        <h3 class="font-title mt-4 text-xl font-bold text-ink">Básico</h3>
        <p class="mt-1 text-xs text-muted">Para organizar a rotina inicial de atendimento e OS da equipe.</p>
        
        <div class="mt-6 pricing-price-box">
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
    <div class="pricing-card pricing-card-featured">
      <div class="pricing-badge-featured">
        <svg class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
        <span>Mais Escolhido</span>
      </div>

      <div>
        <div class="flex items-center justify-between">
          <span class="badge badge-signal">Profissional</span>
          <span class="text-xs font-bold" style="color: #b45309;">Até 10 usuários</span>
        </div>
        <h3 class="font-title mt-4 text-xl font-bold text-ink">Profissional</h3>
        <p class="mt-1 text-xs text-muted">Para equipes em crescimento que precisam de velocidade e controle.</p>
        
        <div class="mt-6 pricing-price-box">
          <div class="flex items-baseline gap-1">
            <span class="text-xs font-bold" style="color: #d97706;">R$</span>
            <span class="font-title text-3xl font-extrabold text-ink price-val" data-mensal="497" data-anual="397">497</span>
            <span class="text-xs font-semibold text-muted">/mês</span>
          </div>
          <p class="mt-1 text-[11px] text-muted cycle-subtext" data-mensal="Cobrança mensal recorrente" data-anual="Faturado R$ 4.764/ano no Pix">Cobrança mensal recorrente</p>
        </div>

        <ul class="mt-6 flex flex-col gap-2.5 text-xs text-ink/80">
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-signal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span><strong>Até 10 usuários</strong> simultâneos</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-signal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span><strong>5 GB</strong> de armazenamento em nuvem</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-signal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Tudo incluído no plano Básico</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-signal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Controle financeiro e fluxo de caixa</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-signal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Gestão de estoque com alerta mínimo</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-signal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Múltiplos técnicos atribuídos por O.S</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-signal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Termos de garantia personalizados</span>
          </li>
          <li class="flex items-start gap-2">
            <svg class="mt-0.5 size-4 shrink-0 text-signal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
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
    <div class="pricing-card pricing-card-default">
      <div>
        <div class="flex items-center justify-between">
          <span class="badge badge-default">Avançado</span>
          <span class="text-xs font-semibold text-muted">Até 25 usuários</span>
        </div>
        <h3 class="font-title mt-4 text-xl font-bold text-ink">Avançado</h3>
        <p class="mt-1 text-xs text-muted">Para operações maiores com campo, acompanhamento e escala.</p>
        
        <div class="mt-6 pricing-price-box">
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

    <!-- 4. Enterprise (Fundo Escuro Premium) -->
    <div class="pricing-card pricing-card-enterprise">
      <div>
        <div class="flex items-center justify-between">
          <span class="enterprise-badge">Enterprise</span>
          <span class="text-xs font-semibold" style="color: #94a3b8;">50 a 100+ usuários</span>
        </div>
        <h3 class="font-title mt-4 text-xl font-bold text-white">Enterprise</h3>
        <p class="mt-1 text-xs" style="color: #94a3b8;">Para redes, franquias e grandes operações corporativas.</p>
        
        <div class="mt-6 enterprise-divider py-4">
          <div class="flex items-baseline gap-1">
            <span class="font-title text-2xl font-extrabold text-white">Sob Consulta</span>
          </div>
          <p class="mt-1 text-[11px]" style="color: #94a3b8;">Projetos customizados com contrato e SLA</p>
        </div>

        <ul class="mt-6 flex flex-col gap-2.5 text-xs">
          <li class="flex items-start gap-2" style="color: #e2e8f0;">
            <svg class="mt-0.5 size-4 shrink-0" style="color: #10b981;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span><strong class="text-white">50 a 100+ usuários</strong> liberados</span>
          </li>
          <li class="flex items-start gap-2" style="color: #e2e8f0;">
            <svg class="mt-0.5 size-4 shrink-0" style="color: #10b981;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span><strong class="text-white">50 GB+</strong> de armazenamento dedicado</span>
          </li>
          <li class="flex items-start gap-2" style="color: #e2e8f0;">
            <svg class="mt-0.5 size-4 shrink-0" style="color: #10b981;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Domínio próprio personalizado</span>
          </li>
          <li class="flex items-start gap-2" style="color: #e2e8f0;">
            <svg class="mt-0.5 size-4 shrink-0" style="color: #10b981;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Servidor e banco de dados dedicados</span>
          </li>
          <li class="flex items-start gap-2" style="color: #e2e8f0;">
            <svg class="mt-0.5 size-4 shrink-0" style="color: #10b981;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Treinamento e migração de dados assistida</span>
          </li>
          <li class="flex items-start gap-2" style="color: #e2e8f0;">
            <svg class="mt-0.5 size-4 shrink-0" style="color: #10b981;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>SLA contratual de 99.9% de uptime</span>
          </li>
          <li class="flex items-start gap-2" style="color: #e2e8f0;">
            <svg class="mt-0.5 size-4 shrink-0" style="color: #10b981;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Gerente de contas dedicado</span>
          </li>
        </ul>
      </div>

      <div class="mt-8 pt-4">
        <a href="<?= htmlspecialchars($whatsapp_url) ?>&text=Ol%C3%A1!+Gostaria+de+um+or%C3%A7amento+para+o+plano+Enterprise+do+ZenyDesk+OS" target="_blank" rel="noopener noreferrer" class="enterprise-cta-btn">
          Falar com Especialista
        </a>
      </div>
    </div>

  </div>

  <!-- Modal de Checkout Direto (Totalmente Real e Operacional) -->
  <div id="checkout-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" style="background-color: rgba(15, 23, 42, 0.8); backdrop-filter: blur(4px);">
    <div class="relative w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl max-h-[92vh] overflow-y-auto" style="border: 1px solid #e2e8f0;">
      
      <!-- Botão Fechar -->
      <button type="button" onclick="fecharCheckout()" class="checkout-close-btn" aria-label="Fechar">
        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>

      <!-- Etapa 1: Formulário de Contratação -->
      <div id="checkout-etapa-form">
        <div class="flex items-center gap-2">
          <span class="badge badge-signal">Contratação Direta</span>
          <span class="text-xs font-semibold flex items-center gap-1" style="color: #10b981;">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Ativação Imediata
          </span>
        </div>
        
        <h3 class="font-title mt-2 text-2xl font-extrabold text-ink" id="modal-plano-nome">Assinar Plano</h3>
        <p class="text-xs text-muted">Informe os dados da sua empresa para reservar o seu subdomínio exclusivo e gerar o Pix.</p>

        <!-- Resumo do Valor -->
        <div class="mt-4 flex items-center justify-between rounded-xl p-3.5" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
          <div>
            <span class="text-[11px] font-bold uppercase tracking-wider text-muted">Total a Pagar</span>
            <div class="font-title text-xl font-extrabold" style="color: #10b981;" id="modal-valor-total">R$ 247,00</div>
          </div>
          <span class="badge badge-tint" id="modal-ciclo-tag">Plano Mensal</span>
        </div>

        <form id="form-assinar" onsubmit="enviarAssinatura(event)" class="mt-5 flex flex-col gap-3.5 text-left">
          <input type="hidden" id="input-plano" name="plano" value="basico">
          <input type="hidden" id="input-ciclo" name="ciclo" value="mensal">

          <!-- Subdomínio Exclusivo -->
          <div>
            <label for="subdominio" class="block text-xs font-bold text-slate-700 mb-1" style="color: #334155;">
              Subdomínio Exclusivo Desejado <span style="color: #ef4444;">*</span>
            </label>
            <div class="flex items-center rounded-lg overflow-hidden" style="border: 1px solid #cbd5e1;">
              <input type="text" id="subdominio" name="subdominio" required placeholder="suaempresa"
                     class="w-full px-3 py-2 text-xs font-semibold outline-none" style="color: #0f172a; background: #fff;"
                     oninput="sanitizarSubdominio(this)">
              <span class="px-3 py-2 text-xs font-medium select-none" style="background-color: #f1f5f9; color: #64748b; border-left: 1px solid #cbd5e1;">
                .os.zenydesk.com
              </span>
            </div>
            <p class="mt-1 text-[10px] text-muted">Apenas letras, números e traço. Ex: certimix, oficinax, eletro-silva.</p>
          </div>

          <!-- Nome da Empresa -->
          <div>
            <label for="nome_empresa" class="block text-xs font-bold mb-1" style="color: #334155;">
              Razão Social ou Nome Fantasia <span style="color: #ef4444;">*</span>
            </label>
            <input type="text" id="nome_empresa" name="nome_empresa" required placeholder="Silva Assistência Técnica LTDA"
                   class="modal-input">
          </div>

          <!-- Responsável e E-mail em 2 colunas -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
              <label for="responsavel" class="block text-xs font-bold mb-1" style="color: #334155;">
                Nome do Responsável <span style="color: #ef4444;">*</span>
              </label>
              <input type="text" id="responsavel" name="responsavel" required placeholder="Carlos Silva"
                     class="modal-input">
            </div>
            <div>
              <label for="email" class="block text-xs font-bold mb-1" style="color: #334155;">
                E-mail Corporativo <span style="color: #ef4444;">*</span>
              </label>
              <input type="email" id="email" name="email" required placeholder="contato@empresa.com.br"
                     class="modal-input">
            </div>
          </div>

          <!-- Telefone e CPF/CNPJ em 2 colunas -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
              <label for="telefone" class="block text-xs font-bold mb-1" style="color: #334155;">
                WhatsApp / Telefone <span style="color: #ef4444;">*</span>
              </label>
              <input type="text" id="telefone" name="telefone" required placeholder="(11) 99999-9999"
                     class="modal-input">
            </div>
            <div>
              <label for="cpf_cnpj" class="block text-xs font-bold mb-1" style="color: #334155;">
                CNPJ ou CPF do Titular <span style="color: #ef4444;">*</span>
              </label>
              <input type="text" id="cpf_cnpj" name="cpf_cnpj" required placeholder="00.000.000/0001-00"
                     class="modal-input">
            </div>
          </div>

          <div id="checkout-erro" class="hidden rounded-lg p-2.5 text-xs" style="background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;"></div>

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
        <div class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-bold" style="background-color: #d1fae5; color: #065f46;">
          <span class="size-2 rounded-full" style="background-color: #10b981; animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;"></span>
          Pix Gerado — Aguardando Pagamento
        </div>

        <h3 class="font-title mt-3 text-xl font-extrabold text-ink" id="pix-plano-titulo">Plano Básico</h3>
        <p class="text-xs text-muted">Escaneie o QR Code abaixo no app do seu banco ou utilize o código Copia e Cola.</p>

        <!-- QR Code Real -->
        <div class="mt-4 flex flex-col items-center justify-center">
          <div class="rounded-2xl p-3 shadow-md inline-block" style="background: #ffffff; border: 2px solid #e2e8f0;">
            <img id="pix-qrcode-img" src="" alt="QR Code Pix Oficial" class="size-52 object-contain mx-auto" />
          </div>
          <div class="mt-2 text-xs font-bold" style="color: #0f172a;">
            Valor: <span class="text-base" style="color: #10b981;" id="pix-valor-display">R$ 0,00</span>
          </div>
          <p class="text-[11px] text-muted">Beneficiário: <strong id="pix-beneficiario-display">ZENYDESK OS TECNOLOGIA</strong></p>
          <p class="text-[11px]" style="color: #475569;">Subdomínio reservado: <code class="font-mono text-primary font-bold" id="pix-subdominio-display">empresa.os.zenydesk.com</code></p>
        </div>

        <!-- Copia e Cola -->
        <div class="mt-4 text-left">
          <label class="block text-xs font-bold mb-1" style="color: #334155;">Código Pix Copia e Cola</label>
          <div class="flex items-center gap-2">
            <input type="text" id="pix-copia-cola" readonly
                   class="w-full rounded-lg px-3 py-2 text-xs font-mono outline-none select-all"
                   style="border: 1px solid #cbd5e1; background-color: #f8fafc; color: #334155;">
            <button type="button" id="btn-copiar-pix" onclick="copiarPix()" class="btn btn-primary shrink-0 px-4 py-2 text-xs font-bold">
              Copiar
            </button>
          </div>
        </div>

        <!-- Instruções -->
        <div class="mt-5 rounded-xl p-3 text-left text-xs" style="background-color: #f8fafc; border: 1px solid #e2e8f0; color: #334155;">
          <div class="font-bold flex items-center gap-1.5 mb-1" style="color: #0f172a;">
            <svg class="size-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            Como funciona a liberação?
          </div>
          <p class="text-[11px] leading-relaxed" style="color: #475569;">
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
/* Seletor de Ciclo Mensal / Anual */
.pricing-toggle-container {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  background-color: #f1f5f9;
  border: 1px solid #e2e8f0;
  border-radius: 9999px;
  padding: 4px;
  margin-top: 24px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.cycle-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 20px;
  font-size: 13px;
  font-weight: 700;
  border-radius: 9999px;
  border: none;
  background: transparent;
  color: #64748b;
  cursor: pointer;
  transition: all 0.2s ease;
  line-height: 1.2;
}

.cycle-btn:hover {
  color: #0f172a;
}

.cycle-btn.active {
  background-color: #0f172a !important;
  color: #ffffff !important;
  box-shadow: 0 2px 8px rgba(15, 23, 42, 0.2);
}

.cycle-btn.active:hover {
  color: #ffffff !important;
}

.discount-pill {
  font-size: 10px;
  font-weight: 800;
  padding: 2px 8px;
  border-radius: 9999px;
  background-color: #d1fae5;
  color: #065f46;
  letter-spacing: 0.02em;
}

.cycle-btn.active .discount-pill {
  background-color: #10b981;
  color: #ffffff;
}

/* Grid de Planos */
.pricing-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 24px;
  margin-top: 48px;
  align-items: stretch;
}

@media (min-width: 640px) {
  .pricing-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .pricing-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

/* Cards Base */
.pricing-card {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  border-radius: 20px;
  padding: 28px 24px 24px 24px;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  position: relative;
}

.pricing-card-default {
  background-color: #ffffff;
  border: 1px solid #e2e8f0;
  box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
}

.pricing-card-default:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
}

/* Card Profissional (Destaque) */
.pricing-card-featured {
  background-color: #ffffff;
  border: 2px solid #f59e0b;
  box-shadow: 0 12px 32px rgba(245, 158, 11, 0.16);
}

.pricing-card-featured:hover {
  transform: translateY(-2px);
  box-shadow: 0 18px 40px rgba(245, 158, 11, 0.24);
}

.pricing-badge-featured {
  position: absolute;
  top: -13px;
  left: 50%;
  transform: translateX(-50%);
  background: linear-gradient(90deg, #f59e0b 0%, #ea580c 100%);
  color: #ffffff;
  font-size: 10px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  padding: 4px 14px;
  border-radius: 9999px;
  box-shadow: 0 4px 12px rgba(245, 158, 11, 0.35);
  display: inline-flex;
  align-items: center;
  gap: 5px;
  white-space: nowrap;
  z-index: 10;
}

/* Card Enterprise (Fundo Escuro Premium) */
.pricing-card-enterprise {
  background-color: #0f172a !important;
  color: #ffffff !important;
  border: 1px solid #1e293b !important;
  box-shadow: 0 12px 32px rgba(15, 23, 42, 0.25) !important;
}

.pricing-card-enterprise:hover {
  transform: translateY(-2px);
  box-shadow: 0 18px 40px rgba(15, 23, 42, 0.38) !important;
}

.enterprise-badge {
  background: rgba(255, 255, 255, 0.12);
  color: #ffffff;
  font-weight: 700;
  font-size: 11px;
  padding: 3px 10px;
  border-radius: 9999px;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  display: inline-block;
}

.enterprise-divider {
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.enterprise-cta-btn {
  display: block;
  width: 100%;
  text-align: center;
  padding: 10px 16px;
  font-size: 12px;
  font-weight: 700;
  border-radius: 12px;
  background-color: rgba(255, 255, 255, 0.08);
  color: #ffffff !important;
  border: 1px solid rgba(255, 255, 255, 0.2);
  transition: all 0.2s ease;
  text-decoration: none;
}

.enterprise-cta-btn:hover {
  background-color: rgba(255, 255, 255, 0.18);
  border-color: rgba(255, 255, 255, 0.4);
  color: #ffffff !important;
}

/* Elementos Utilitários de Preço */
.pricing-price-box {
  border-top: 1px solid #f1f5f9;
  border-bottom: 1px solid #f1f5f9;
  padding: 16px 0;
}

.modal-input {
  width: 100%;
  border-radius: 8px;
  border: 1px solid #cbd5e1;
  padding: 8px 12px;
  font-size: 12px;
  color: #0f172a;
  background-color: #ffffff;
  outline: none;
  transition: border-color 0.15s ease, box-shadow 0.15s ease;
}

.modal-input:focus {
  border-color: var(--color-primary, #0f7ade);
  box-shadow: 0 0 0 2px rgba(15, 122, 222, 0.15);
}

.checkout-close-btn {
  position: absolute;
  right: 16px;
  top: 16px;
  border-radius: 8px;
  padding: 6px;
  color: #94a3b8;
  background: transparent;
  border: none;
  cursor: pointer;
  transition: all 0.15s ease;
}

.checkout-close-btn:hover {
  background-color: #f1f5f9;
  color: #334155;
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
    btnMensal.classList.add('active');
    btnAnual.classList.remove('active');
  } else {
    btnAnual.classList.add('active');
    btnMensal.classList.remove('active');
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
