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
</section>

<!-- Modal de Checkout Direto (Design Fintech Premium & Scroll-Locked) -->
<div id="checkout-modal" class="checkout-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="modal-plano-nome">
  <div class="checkout-modal-card">
    
    <!-- Top Accent Line -->
    <div class="checkout-top-accent"></div>

    <!-- Header com Badges, Título e Botão Fechar Separado -->
    <div class="checkout-header">
      <div class="checkout-header-content">
        <div class="checkout-badge-row">
          <span class="checkout-badge-signal">
            <svg class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
            Contratação Direta
          </span>
          <span class="checkout-badge-success">
            <svg class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Ativação Imediata
          </span>
        </div>
        <h3 class="checkout-title" id="modal-plano-nome">Assinar Plano</h3>
        <p class="checkout-subtitle">Reserve seu subdomínio exclusivo e ative o seu sistema via Pix oficial BACEN.</p>
      </div>

      <!-- Botão Fechar Redondo e Destacado (Sem Sobreposição) -->
      <button type="button" onclick="fecharCheckout()" class="checkout-close-circle" aria-label="Fechar checkout">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
    </div>

    <!-- Corpo com Rolagem Interna Autônoma -->
    <div class="checkout-body">

      <!-- Etapa 1: Formulário de Contratação -->
      <div id="checkout-etapa-form">
        
        <!-- Summary Box Estilo Cartão Fintech -->
        <div class="checkout-summary-box">
          <div>
            <span class="checkout-summary-label">Total do Investimento</span>
            <div class="checkout-summary-price" id="modal-valor-total">R$ 247,00</div>
          </div>
          <div class="text-right">
            <span class="checkout-cycle-pill" id="modal-ciclo-tag">Plano Mensal</span>
            <div class="checkout-summary-tagline">Cobrança Oficial • Sem fidelidade</div>
          </div>
        </div>

        <form id="form-assinar" onsubmit="enviarAssinatura(event)" class="checkout-form">
          <input type="hidden" id="input-plano" name="plano" value="basico">
          <input type="hidden" id="input-ciclo" name="ciclo" value="mensal">

          <!-- Subdomínio Exclusivo -->
          <div class="checkout-field-group">
            <label for="subdominio" class="checkout-label">
              <span>Subdomínio Exclusivo Desejado</span>
              <span class="checkout-required">*</span>
            </label>
            <div class="checkout-subdomain-wrapper">
              <span class="checkout-subdomain-protocol">https://</span>
              <input type="text" id="subdominio" name="subdominio" required placeholder="suaempresa"
                     class="checkout-subdomain-input"
                     oninput="sanitizarSubdominio(this)">
              <span class="checkout-subdomain-domain">.os.zenydesk.com</span>
            </div>
            <p class="checkout-helper-text">
              <svg width="12" height="12" style="width: 12px; height: 12px; display: inline-block; vertical-align: middle; margin-right: 4px; color: #0f7ade;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
              Seu painel exclusivo será: <strong class="text-ink" id="preview-subdomain-full">https://suaempresa.os.zenydesk.com</strong>
            </p>
          </div>

          <!-- Razão Social ou Nome Fantasia -->
          <div class="checkout-field-group">
            <label for="nome_empresa" class="checkout-label">
              <span>Razão Social ou Nome Fantasia</span>
              <span class="checkout-required">*</span>
            </label>
            <input type="text" id="nome_empresa" name="nome_empresa" required placeholder="Silva Assistência Técnica LTDA"
                   class="checkout-input">
          </div>

          <!-- Responsável e E-mail em 2 colunas -->
          <div class="checkout-grid-2">
            <div class="checkout-field-group">
              <label for="responsavel" class="checkout-label">
                <span>Nome do Responsável</span>
                <span class="checkout-required">*</span>
              </label>
              <input type="text" id="responsavel" name="responsavel" required placeholder="Carlos Silva"
                     class="checkout-input">
            </div>
            <div class="checkout-field-group">
              <label for="email" class="checkout-label">
                <span>E-mail Corporativo</span>
                <span class="checkout-required">*</span>
              </label>
              <input type="email" id="email" name="email" required placeholder="contato@empresa.com.br"
                     class="checkout-input">
            </div>
          </div>

          <!-- Telefone e CPF/CNPJ em 2 colunas -->
          <div class="checkout-grid-2">
            <div class="checkout-field-group">
              <label for="telefone" class="checkout-label">
                <span>WhatsApp / Telefone</span>
                <span class="checkout-required">*</span>
              </label>
              <input type="text" id="telefone" name="telefone" required placeholder="(11) 99999-9999"
                     class="checkout-input">
            </div>
            <div class="checkout-field-group">
              <label for="cpf_cnpj" class="checkout-label">
                <span>CNPJ ou CPF do Titular</span>
                <span class="checkout-required">*</span>
              </label>
              <input type="text" id="cpf_cnpj" name="cpf_cnpj" required placeholder="00.000.000/0001-00"
                     class="checkout-input">
            </div>
          </div>

          <!-- Caixa de Alerta/Erro -->
          <div id="checkout-erro" class="hidden checkout-error-box"></div>

          <!-- Botão de Ação -->
          <div class="mt-3">
            <button type="submit" id="btn-submit-assinar" class="checkout-btn-submit">
              <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
              <span>Gerar Pix para Ativação Imediata</span>
            </button>
            
            <!-- Barra de Garantias e Segurança -->
            <div class="checkout-trust-bar">
              <div class="checkout-trust-item">
                <svg class="size-3.5" style="color: #f59e0b;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <span>Criptografia 256-bit</span>
              </div>
              <div class="checkout-trust-item">
                <svg class="size-3.5" style="color: #10b981;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                <span>Chave Pix Oficial BACEN</span>
              </div>
              <div class="checkout-trust-item">
                <svg class="size-3.5" style="color: #0f7ade;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                <span>Sem Carência</span>
              </div>
            </div>
          </div>
        </form>
      </div>

      <!-- Etapa 2: Exibição do QR Code Pix Real & Copia e Cola -->
      <div id="checkout-etapa-pix" class="hidden text-center py-2">
        <div class="checkout-pix-pill">
          <span class="size-2 rounded-full" style="background-color: #10b981; animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;"></span>
          Pix Gerado — Aguardando Pagamento
        </div>

        <h3 class="font-title mt-3 text-2xl font-extrabold text-ink" id="pix-plano-titulo">Plano Profissional</h3>
        <p class="text-xs text-muted mt-1">Escaneie o QR Code no app do seu banco ou copie o código Pix abaixo.</p>

        <!-- Container do QR Code -->
        <div class="checkout-qrcode-card">
          <img id="pix-qrcode-img" src="" alt="QR Code Pix Oficial" class="checkout-qrcode-img" />
          
          <div class="mt-3 text-xs font-bold text-ink">
            Valor a Pagar: <span class="checkout-pix-value" id="pix-valor-display">R$ 0,00</span>
          </div>
          
          <div class="checkout-subdomain-tag">
            <svg class="size-3.5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
            <span>Subdomínio reservado:</span>
            <strong id="pix-subdominio-display">empresa.os.zenydesk.com</strong>
          </div>
        </div>

        <!-- Copia e Cola com 1 Clique -->
        <div class="mt-4 text-left">
          <label class="checkout-label">Código Pix Copia e Cola</label>
          <div class="checkout-copy-wrapper">
            <input type="text" id="pix-copia-cola" readonly class="checkout-copy-input select-all">
            <button type="button" id="btn-copiar-pix" onclick="copiarPix()" class="checkout-btn-copy">
              Copiar Código
            </button>
          </div>
        </div>

        <!-- Instruções de Liberação -->
        <div class="checkout-instructions-box">
          <div class="font-bold flex items-center gap-1.5 text-ink mb-1">
            <svg class="size-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            Como funciona a liberação automática?
          </div>
          <p class="text-[11px] text-muted leading-relaxed">
            Assim que a transferência for compensada pelo Banco Central, o seu subdomínio será ativado imediatamente. Você também pode acelerar o processo enviando o comprovante via WhatsApp para nossa equipe técnica.
          </p>
        </div>

        <!-- Botões de Ação Final -->
        <div class="mt-5 flex flex-col sm:flex-row gap-2.5">
          <a id="btn-confirmar-whatsapp" href="#" target="_blank" rel="noopener noreferrer" class="checkout-btn-whatsapp">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
            <span>Enviar Comprovante no WhatsApp</span>
          </a>
          <button type="button" onclick="fecharCheckout()" class="checkout-btn-secondary">
            Concluir / Fechar
          </button>
        </div>
      </div>

    </div>
  </div>
</div>

<style>
/* ==========================================================================
   1. SELETOR DE CICLO MENSAL / ANUAL
   ========================================================================== */
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

/* ==========================================================================
   2. GRID DE PLANOS
   ========================================================================== */
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

/* Card Profissional (Destaque Mais Escolhido) */
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

.pricing-price-box {
  border-top: 1px solid #f1f5f9;
  border-bottom: 1px solid #f1f5f9;
  padding: 16px 0;
}

/* ==========================================================================
   3. CHECKOUT MODAL ULTRA-PREMIUM (FINTECH LUXURY & SCROLL-LOCK)
   ========================================================================== */
.checkout-modal-overlay {
  position: fixed !important;
  inset: 0 !important;
  top: 0 !important;
  left: 0 !important;
  width: 100vw !important;
  height: 100vh !important;
  z-index: 999999 !important;
  display: none;
  align-items: center;
  justify-content: center;
  padding: 16px;
  background-color: rgba(15, 23, 42, 0.78) !important;
  backdrop-filter: blur(14px) !important;
  -webkit-backdrop-filter: blur(14px) !important;
  overflow-y: auto;
}

.checkout-modal-overlay.is-open {
  display: flex !important;
  animation: modalFadeIn 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes modalFadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.checkout-modal-overlay svg {
  max-width: 24px;
  max-height: 24px;
}

.checkout-modal-card {
  position: relative;
  width: 100%;
  max-width: 500px;
  background: #ffffff !important;
  border-radius: 22px !important;
  box-shadow: 0 30px 70px -15px rgba(0, 0, 0, 0.45), 0 0 0 1px rgba(226, 232, 240, 0.9) !important;
  overflow: hidden;
  margin: auto;
  display: flex;
  flex-direction: column;
  max-height: 94vh;
  animation: modalScaleUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes modalScaleUp {
  from { transform: scale(0.96) translateY(8px); opacity: 0; }
  to { transform: scale(1) translateY(0); opacity: 1; }
}

.checkout-top-accent {
  height: 4px;
  width: 100%;
  background: linear-gradient(90deg, #f59e0b 0%, #0f7ade 50%, #10b981 100%);
}

.checkout-header {
  padding: 16px 22px 10px 22px;
  border-bottom: 1px solid #f1f5f9;
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 16px;
  background: #ffffff;
}

.checkout-header-content {
  flex: 1;
}

.checkout-badge-row {
  display: flex;
  align-items: center;
  gap: 8px;
  flex-wrap: wrap;
}

.checkout-badge-signal {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  background-color: #fef3c7;
  color: #b45309;
  font-size: 10px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  padding: 3px 9px;
  border-radius: 9999px;
}

.checkout-badge-success {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  background-color: #ecfdf5;
  color: #047857;
  font-size: 10px;
  font-weight: 700;
  padding: 3px 9px;
  border-radius: 9999px;
}

.checkout-title {
  font-family: var(--font-title);
  font-size: 20px;
  font-weight: 800;
  color: #0f172a;
  margin-top: 4px;
  line-height: 1.2;
}

.checkout-subtitle {
  font-size: 11px;
  color: #64748b;
  margin-top: 2px;
  line-height: 1.35;
}

/* Botão Fechar Redondo Autônomo */
.checkout-close-circle {
  width: 32px;
  height: 32px;
  min-width: 32px;
  border-radius: 50%;
  background-color: #f8fafc;
  border: 1px solid #e2e8f0;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #64748b;
  cursor: pointer;
  transition: all 0.2s ease;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}

.checkout-close-circle:hover {
  background-color: #e2e8f0;
  color: #0f172a;
  transform: scale(1.06);
}

.checkout-body {
  padding: 14px 22px 20px 22px;
  overflow-y: auto;
  flex: 1;
}

.checkout-body::-webkit-scrollbar {
  width: 5px;
}
.checkout-body::-webkit-scrollbar-track {
  background: transparent;
}
.checkout-body::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 9999px;
}
.checkout-body::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}

/* Summary Box Fintech */
.checkout-summary-box {
  background: radial-gradient(circle at 100% 0%, #1e293b 0%, #0f172a 100%);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 14px;
  padding: 12px 18px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: 0 8px 20px -6px rgba(15, 23, 42, 0.3);
  margin-bottom: 14px;
}

.checkout-summary-label {
  display: block;
  font-size: 9.5px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: #94a3b8;
}

.checkout-summary-price {
  font-family: var(--font-title);
  font-size: 24px;
  font-weight: 800;
  color: #10b981;
  line-height: 1.1;
  margin-top: 2px;
}

.checkout-cycle-pill {
  display: inline-block;
  background: rgba(255, 255, 255, 0.12);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 9999px;
  padding: 3px 10px;
  font-size: 10.5px;
  font-weight: 700;
  color: #ffffff;
}

.checkout-summary-tagline {
  font-size: 9.5px;
  color: #94a3b8;
  margin-top: 2px;
}

/* Campos de Formulário Modernos */
.checkout-form {
  display: flex;
  flex-direction: column;
  gap: 10px;
  text-align: left;
}

.checkout-field-group {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.checkout-label {
  font-size: 11px;
  font-weight: 700;
  color: #334155;
  display: flex;
  align-items: center;
  gap: 3px;
}

.checkout-required {
  color: #ef4444;
  font-weight: 800;
}

.checkout-input {
  width: 100%;
  border-radius: 10px;
  border: 1.5px solid #cbd5e1;
  background-color: #f8fafc;
  padding: 8px 12px;
  font-size: 12px;
  font-weight: 500;
  color: #0f172a;
  outline: none;
  transition: all 0.2s ease;
}

.checkout-input:focus {
  border-color: #0f7ade;
  background-color: #ffffff;
  box-shadow: 0 0 0 3px rgba(15, 122, 222, 0.15);
}

.checkout-grid-2 {
  display: grid;
  grid-template-columns: 1fr;
  gap: 10px;
}

@media (min-width: 520px) {
  .checkout-grid-2 {
    grid-template-columns: repeat(2, 1fr);
  }
}

/* Subdomínio URL Box */
.checkout-subdomain-wrapper {
  display: flex;
  align-items: center;
  border: 1.5px solid #cbd5e1;
  border-radius: 10px;
  background-color: #ffffff;
  overflow: hidden;
  transition: all 0.2s ease;
}

.checkout-subdomain-wrapper:focus-within {
  border-color: #0f7ade;
  box-shadow: 0 0 0 3px rgba(15, 122, 222, 0.15);
}

.checkout-subdomain-protocol {
  padding: 8px 10px;
  font-size: 11px;
  font-weight: 700;
  color: #64748b;
  background-color: #f1f5f9;
  border-right: 1px solid #e2e8f0;
  user-select: none;
}

.checkout-subdomain-input {
  flex: 1;
  padding: 8px 10px;
  font-size: 12px;
  font-weight: 700;
  color: #0f172a;
  border: none;
  background: transparent;
  outline: none;
}

.checkout-subdomain-domain {
  padding: 8px 12px;
  font-size: 11px;
  font-weight: 800;
  color: #0f7ade;
  background-color: #eff6ff;
  border-left: 1px solid #dbeafe;
  user-select: none;
}

.checkout-helper-text {
  font-size: 10px;
  color: #64748b;
  margin-top: 1px;
}

.checkout-error-box {
  background-color: #fef2f2;
  border: 1.5px solid #fecaca;
  color: #b91c1c;
  padding: 9px 12px;
  border-radius: 10px;
  font-size: 11px;
  font-weight: 600;
  margin-top: 4px;
}

/* Botão de Envio Principal */
.checkout-btn-submit {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%);
  color: #ffffff;
  font-size: 13px;
  font-weight: 800;
  padding: 12px 18px;
  border-radius: 12px;
  border: none;
  cursor: pointer;
  box-shadow: 0 8px 20px -4px rgba(245, 158, 11, 0.45);
  transition: all 0.2s ease;
}

.checkout-btn-submit:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 26px -4px rgba(245, 158, 11, 0.58);
  filter: brightness(1.03);
}

.checkout-btn-submit:active {
  transform: translateY(0);
}

.checkout-btn-submit:disabled {
  opacity: 0.65;
  cursor: not-allowed;
  transform: none;
}

/* Barra de Confiança */
.checkout-trust-bar {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 14px;
  flex-wrap: wrap;
  margin-top: 10px;
  padding-top: 10px;
  border-top: 1px solid #f1f5f9;
}

.checkout-trust-item {
  display: flex;
  align-items: center;
  gap: 4px;
  font-size: 10px;
  font-weight: 700;
  color: #64748b;
}

/* ==========================================================================
   4. ETAPA 2: QR CODE PIX REAL
   ========================================================================== */
.checkout-pix-pill {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background-color: #ecfdf5;
  border: 1px solid #a7f3d0;
  color: #065f46;
  font-size: 11.5px;
  font-weight: 800;
  padding: 6px 16px;
  border-radius: 9999px;
}

.checkout-qrcode-card {
  background: #ffffff;
  border: 2px solid #e2e8f0;
  border-radius: 20px;
  padding: 16px;
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.06);
  display: inline-block;
  margin-top: 16px;
}

.checkout-qrcode-img {
  width: 210px;
  height: 210px;
  object-fit: contain;
  margin: 0 auto;
}

.checkout-pix-value {
  color: #10b981;
  font-size: 18px;
  font-weight: 800;
}

.checkout-subdomain-tag {
  margin-top: 8px;
  padding: 6px 12px;
  background-color: #f1f5f9;
  border-radius: 8px;
  font-size: 11px;
  color: #334155;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
}

.checkout-subdomain-tag strong {
  color: #0f7ade;
  font-family: var(--font-mono);
}

.checkout-copy-wrapper {
  display: flex;
  align-items: center;
  gap: 8px;
  background-color: #f8fafc;
  border: 1.5px solid #cbd5e1;
  border-radius: 12px;
  padding: 4px 5px 4px 12px;
  margin-top: 4px;
}

.checkout-copy-input {
  flex: 1;
  border: none;
  background: transparent;
  font-family: var(--font-mono);
  font-size: 11px;
  color: #334155;
  outline: none;
}

.checkout-btn-copy {
  background-color: #0f7ade;
  color: #ffffff;
  font-size: 11.5px;
  font-weight: 700;
  padding: 8px 16px;
  border-radius: 8px;
  border: none;
  cursor: pointer;
  transition: all 0.2s ease;
  white-space: nowrap;
}

.checkout-btn-copy:hover {
  background-color: #0284c7;
}

.checkout-instructions-box {
  margin-top: 16px;
  background-color: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  padding: 14px;
  text-align: left;
}

.checkout-btn-whatsapp {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  background-color: #25D366;
  color: #ffffff !important;
  font-size: 12.5px;
  font-weight: 800;
  padding: 12px 18px;
  border-radius: 12px;
  text-decoration: none;
  box-shadow: 0 4px 14px rgba(37, 211, 102, 0.35);
  transition: all 0.2s ease;
}

.checkout-btn-whatsapp:hover {
  background-color: #20ba59;
  transform: translateY(-1px);
}

.checkout-btn-secondary {
  padding: 12px 18px;
  font-size: 12px;
  font-weight: 700;
  border-radius: 12px;
  border: 1px solid #cbd5e1;
  background-color: #ffffff;
  color: #475569;
  cursor: pointer;
  transition: all 0.2s ease;
}

.checkout-btn-secondary:hover {
  background-color: #f1f5f9;
  color: #0f172a;
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
  var preview = document.getElementById('preview-subdomain-full');
  if (preview) {
    preview.textContent = 'https://' + (input.value || 'suaempresa') + '.os.zenydesk.com';
  }
}

/**
 * Abre o Modal de Checkout com CONGELAMENTO TOTAL DO SCROLL DE FUNDO
 */
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
  document.getElementById('modal-ciclo-tag').textContent = cicloAtual === 'anual' ? 'Plano Anual (-20%)' : 'Plano Mensal';

  // Congelar a rolagem do body e html de forma rigorosa
  document.body.style.overflow = 'hidden';
  document.documentElement.style.overflow = 'hidden';

  // Exibir com classe animada
  modal.classList.add('is-open');
}

/**
 * Fecha o Modal de Checkout e DESTRAVA O SCROLL DE FUNDO
 */
function fecharCheckout() {
  var modal = document.getElementById('checkout-modal');
  modal.classList.remove('is-open');

  // Destravar a rolagem da página
  document.body.style.overflow = '';
  document.documentElement.style.overflow = '';
}

// Fechar ao clicar diretamente no fundo (backdrop)
document.addEventListener('DOMContentLoaded', function() {
  var modal = document.getElementById('checkout-modal');
  if (modal) {
    modal.addEventListener('click', function(e) {
      if (e.target === this) {
        fecharCheckout();
      }
    });
  }
});

// Fechar com a tecla ESC
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape' || e.keyCode === 27) {
    fecharCheckout();
  }
});

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
    btn.innerHTML = '<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg> <span>Gerar Pix para Ativação Imediata</span>';
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
  btn.textContent = 'Copiado com Sucesso! ✓';
  btn.style.backgroundColor = '#10b981';
  setTimeout(function() {
    btn.textContent = originalText;
    btn.style.backgroundColor = '';
  }, 2500);
}
</script>
