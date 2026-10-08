<!doctype html>
<html lang="pt-BR" class="h-full antialiased">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($page_title) ?></title>
  <meta name="description" content="<?= htmlspecialchars($page_description) ?>" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('apple-touch-icon.png') ?>?v=20261008">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('favicon-32x32.png') ?>?v=20261008">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('favicon-16x16.png') ?>?v=20261008">
  <link rel="shortcut icon" href="<?= base_url('favicon.ico') ?>?v=20261008">
  <link rel="stylesheet" href="<?= base_url('assets/landing/css/style.css') ?>?v=1" />
</head>
<body class="min-h-full flex flex-col bg-paper text-ink">

<header class="sticky top-0 z-50 border-b border-white/10" style="background-color: color-mix(in oklab, var(--color-topbar) 95%, transparent); backdrop-filter: blur(8px);">
  <nav class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6">
    <a href="<?= base_url() ?>" class="flex items-center gap-2">
      <img src="<?= base_url('assets/img/logo-zenydesk.png') ?>" alt="Zenydesk" class="h-7 w-auto" />
      <span class="hidden text-xs font-semibold uppercase tracking-wide text-white/50 sm:inline">OS</span>
    </a>

    <ul class="hidden items-center gap-8 text-sm font-medium text-white/75 lg:flex">
      <li><a href="#funcionalidades" class="transition-colors hover:text-white">Funcionalidades</a></li>
      <li><a href="#fluxo" class="transition-colors hover:text-white">Comercial x Pós-venda</a></li>
      <li><a href="#precos" class="transition-colors hover:text-white">Planos</a></li>
      <li><a href="#faq" class="transition-colors hover:text-white">Perguntas frequentes</a></li>
    </ul>

    <div class="flex items-center gap-3">
      <a href="<?= htmlspecialchars($login_url) ?>" class="text-sm font-medium text-white/80 transition-colors hover:text-white px-3 py-2 hidden sm:inline-flex">
        Entrar
      </a>
      <a href="<?= htmlspecialchars($signup_url ?? site_url('login?action=cadastrar')) ?>" class="btn btn-signal btn-sm hidden sm:inline-flex">
        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
        Criar Conta Grátis
      </a>
      <button id="menu-toggle" class="grid size-10 place-items-center rounded-lg border border-white/15 text-white lg:hidden" aria-label="Abrir menu" aria-expanded="false">
        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="6" x2="20" y2="6"/><line x1="4" y1="18" x2="20" y2="18"/></svg>
      </button>
    </div>
  </nav>

  <div id="mobile-menu" class="hidden border-t border-white/10 px-6 py-4 lg:hidden" style="background-color: var(--color-topbar);">
    <ul class="flex flex-col gap-4 text-sm font-medium text-white/80">
      <li><a href="#funcionalidades">Funcionalidades</a></li>
      <li><a href="#fluxo">Comercial x Pós-venda</a></li>
      <li><a href="#precos">Planos</a></li>
      <li><a href="#faq">Perguntas frequentes</a></li>
      <li class="pt-2 flex flex-col gap-2">
        <a href="<?= htmlspecialchars($login_url) ?>" class="text-center font-semibold text-white/80 py-2 border border-white/20 rounded-lg">Entrar</a>
        <a href="<?= htmlspecialchars($signup_url ?? site_url('login?action=cadastrar')) ?>" class="btn btn-signal text-center">Criar Conta Grátis</a>
      </li>
    </ul>
  </div>
</header>

<main class="flex-1">
