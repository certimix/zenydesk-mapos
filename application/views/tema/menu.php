<?php
/*
 * Menu lateral no estilo do SNDesk:
 *   Dashboard · Cadastros ▸ · Relatórios ▸ · Avaliações
 *   Menu rápido: Novo Chamado, Agenda, Ativos, Kanban, Todos Chamados,
 *                Pré-Chamados, Central de Chamados, Chamados Sem Técnico,
 *                Gerar OS em Branco
 *   Outros módulos: Vendas, Garantias, Arquivos, Lançamentos, Cobranças
 *
 * Cada item só aparece para quem tem a permissão correspondente.
 */
$permissao = $this->session->userdata('permissao');
$pode = function ($flag) use ($permissao) {
    return $this->permission->checkPermission($permissao, $flag);
};
$seg1 = strtolower((string) $this->uri->segment(1));
$seg2 = strtolower((string) $this->uri->segment(2));

// Item de menu: [rótulo, ícone boxicons, url, ativo?, extra de atributos, contador]
$item = function ($rotulo, $icone, $url, $ativo = false, $attrs = '', $contador = 0) {
    $rot = html_escape($rotulo);
    echo '<li class="' . ($ativo ? 'active' : '') . '">'
        . '<a class="tip-bottom" title="" href="' . $url . '"' . $attrs . '>'
        . '<i class="bx ' . $icone . ' iconX"></i>'
        . '<span class="title">' . $rot . ($contador > 0 ? ' <span class="zd-contador">' . (int) $contador . '</span>' : '') . '</span>'
        . '<span class="title-tooltip">' . $rot . '</span>'
        . '</a></li>';
};

// ---------- Cadastros ----------
$cadastros = [];
if ($pode('cUsuario')) {
    $cadastros[] = ['Usuários / Técnico', 'bx-user-circle', site_url('usuarios'), $seg1 === 'usuarios'];
}
if ($pode('cPermissao')) {
    $cadastros[] = ['Perfis de Acesso', 'bx-lock-alt', site_url('permissoes'), $seg1 === 'permissoes'];
}
if ($pode('vCliente')) {
    if ($pode('vCadastro')) {
        $cadastros[] = ['Usuário Portal', 'bx-id-card', site_url('cadastros/usuariosportal'), $seg1 === 'cadastros' && $seg2 === 'usuariosportal'];
    }
    $cadastros[] = ['Clientes', 'bx-user', site_url('clientes'), isset($menuClientes)];
}
$cad = function ($chave, $rotulo, $icone) use (&$cadastros, $pode, $seg1, $seg2) {
    if ($pode('vCadastro')) {
        $cadastros[] = [$rotulo, $icone, site_url("cadastros/{$chave}"), $seg1 === 'cadastros' && $seg2 === $chave];
    }
};
$cad('afastamentos', 'Afastamentos', 'bx-calendar-x');
$cad('ativos', 'Ativos', 'bx-devices');
$cad('campos', 'Campos Adicionais', 'bx-list-plus');
$cad('categorias', 'Categorias', 'bx-category');
$cad('checklist', 'Check List', 'bx-list-check');
$cad('departamentos', 'Departamentos', 'bx-sitemap');
$cad('edificios', 'Edifícios', 'bx-buildings');
$cad('equipes', 'Equipes', 'bx-group');
$cad('estagios', 'Estágios', 'bx-git-commit');
$cad('eventos', 'Eventos', 'bx-calendar-event');
$cad('feriados', 'Feriados', 'bx-party');
$cad('fluxos', 'Fluxos', 'bx-git-branch');
$cad('mensagens', 'Mensagens - Pré Definidas', 'bx-message-square-detail');
if ($pode('vProduto')) {
    $cadastros[] = ['Produtos', 'bx-basket', site_url('produtos'), isset($menuProdutos)];
}
if ($pode('vServico')) {
    $cadastros[] = ['Modelo de Serviços', 'bx-wrench', site_url('servicos'), isset($menuServicos)];
}
$cad('slas', 'SLAs', 'bx-timer');
if ($pode('cSistema')) {
    $cadastros[] = ['Status', 'bx-flag', site_url('mapos/configurar') . '#menu5', false];
}
$cad('subcategorias', 'Sub Categoria', 'bx-subdirectory-right');

// ---------- Relatórios ----------
$relatorios = [];
$rel = function ($flag, $rotulo, $metodo) use (&$relatorios, $pode, $seg1, $seg2) {
    $ok = is_array($flag) ? ($pode($flag[0]) && $pode($flag[1])) : $pode($flag);
    if ($ok) {
        $relatorios[] = [$rotulo, 'bx-file-blank', site_url("relatorios/{$metodo}"), $seg1 === 'relatorios' && $seg2 === strtolower($metodo)];
    }
};
$rel('rCliente', 'Clientes', 'clientes');
$rel('rProduto', 'Produtos', 'produtos');
$rel('rServico', 'Serviços', 'servicos');
$rel('rOs', 'Ordens de Serviço', 'os');
$rel('rVenda', 'Vendas', 'vendas');
$rel('rFinanceiro', 'Financeiro', 'financeiro');
$rel(['rVenda', 'rOs'], 'SKU', 'sku');
$rel('rFinanceiro', 'Receitas Brutas - MEI', 'receitasBrutasMei');

$grupo = function ($id, $rotulo, $icone, $itens) use ($item) {
    if (! $itens) {
        return;
    }
    $aberto = (bool) array_filter($itens, function ($i) {
        return $i[3];
    });
    $rot = html_escape($rotulo);
    echo '<li class="zd-grupo' . ($aberto ? ' zd-aberto' : '') . '" data-grupo="' . $id . '">'
        . '<a class="zd-grupo-toggle" href="#" role="button" aria-expanded="' . ($aberto ? 'true' : 'false') . '">'
        . '<i class="bx ' . $icone . ' iconX"></i>'
        . '<span class="title">' . $rot . '</span>'
        . '<span class="title-tooltip">' . $rot . '</span>'
        . '<i class="bx bx-chevron-down zd-seta"></i>'
        . '</a><ul class="zd-sub">';
    foreach ($itens as $i) {
        $item($i[0], $i[1], $i[2], $i[3]);
    }
    echo '</ul></li>';
};

$secao = function ($rotulo) {
    echo '<li class="zd-secao"><span class="title">' . html_escape($rotulo) . '</span></li>';
};
?>
<!--sidebar-menu-->
<nav id="sidebar">
    <div id="newlog" style="display: flex; justify-content: center; align-items: center; padding: 16px 18px; margin-bottom: 6px; box-sizing: border-box; width: 100%; overflow: hidden;">
        <a href="<?= site_url('Zenydesk.OS'); ?>" style="display: flex; justify-content: center; align-items: center; text-decoration: none; width: 100%;">
            <img src="<?= base_url(); ?>assets/img/logo-zenydesk.png" alt="ZenyDesk" class="logo-expanded" style="max-height: 34px; max-width: 100%; width: auto; height: auto; object-fit: contain; display: block; margin: 0 auto;">
            <img src="<?= base_url(); ?>assets/img/favicon.png" alt="ZenyDesk" class="logo-collapsed" style="max-height: 32px; max-width: 32px; width: auto; display: none; margin: 0 auto;">
        </a>
    </div>
    <style>
        #sidebar.open .logo-expanded { display: none !important; }
        #sidebar.open .logo-collapsed { display: block !important; }
        #sidebar:not(.open) .logo-expanded { display: block !important; }
        #sidebar:not(.open) .logo-collapsed { display: none !important; }
        /* Entre 1024 e 1366px o sistema inverte: sem .open = recolhido, com .open = aberto */
        @media (min-width: 1024px) and (max-width: 1366px) {
            #sidebar:not(.open) .logo-expanded { display: none !important; }
            #sidebar:not(.open) .logo-collapsed { display: block !important; }
            #sidebar.open .logo-expanded { display: block !important; }
            #sidebar.open .logo-collapsed { display: none !important; }
        }
    </style>
    <a href="#" class="visible-phone">
        <div class="mode">
            <div class="moon-menu">
                <i class='bx bx-chevron-right iconX open-2'></i>
                <i class='bx bx-chevron-left iconX close-2'></i>
            </div>
        </div>
    </a>
    <!-- Start Pesquisar-->
    <li class="search-box">
        <form style="display: flex" action="<?= site_url('Zenydesk.OS/pesquisar') ?>">
        <button style="background:transparent;border:transparent" type="submit" class="tip-bottom" title="">
                <i class='bx bx-search iconX'></i></button>
                <input style="background:transparent;<?= $configuration['app_theme'] == 'white' ? 'color:#313030;' : 'color:#fff;' ?>border:transparent" type="search" name="termo" placeholder="Pesquise aqui...">
            <span class="title-tooltip">Pesquisar</span>
        </form>
    </li>
    <!-- End Pesquisar-->

    <div class="menu-bar">
        <div class="menu zd-menu-rolagem">

            <ul class="menu-links" style="position: relative;">
                <?php
                $secao('Administrador');
                $item('Dashboard', 'bx-home-alt', base_url(), isset($menuPainel));
                $grupo('cadastros', 'Cadastros', 'bx-folder-open', $cadastros);
                $grupo('relatorios', 'Relatórios', 'bx-pie-chart-alt-2', $relatorios);
                if ($pode('vOs')) {
                    $item('Avaliações', 'bx-badge-check', site_url('avaliacoes'), $seg1 === 'avaliacoes');
                }

                if ($pode('vOs') || $pode('vCadastro')) {
                    $secao('Menu rápido');
                    if ($pode('aOs')) {
                        $item('Novo Chamado', 'bx-plus-circle', site_url('os/adicionar'), $seg1 === 'os' && $seg2 === 'adicionar');
                    }
                    $item('Agenda', 'bx-calendar', site_url('agenda'), $seg1 === 'agenda');
                    if ($pode('vCadastro')) {
                        $item('Ativos', 'bx-devices', site_url('cadastros/ativos'), false);
                    }
                    if ($pode('vOs')) {
                        $item('Kanban', 'bx-columns', site_url('kanban'), $seg1 === 'kanban');
                        $item('Todos Chamados', 'bx-file', site_url('os'), isset($menuOs) && empty($minhas) && empty($semTecnico) && $seg2 !== 'adicionar');
                        // Contadores das filas que precisam de ação
                        $qtdPre = $qtdSemTec = 0;
                        if ($this->db->field_exists('pre_chamado', 'os')) {
                            $qtdPre = $this->db->where('pre_chamado', 1)->count_all_results('os');
                            $qtdSemTec = $this->db->where('pre_chamado', 0)->where('usuarios_id IS NULL', null, false)
                                ->where_not_in('status', ['Finalizado', 'Faturado', 'Cancelado'])->count_all_results('os');
                        }
                        $item('Pré-Chamados', 'bx-message-square-add', site_url('prechamados'), $seg1 === 'prechamados', '', $qtdPre);
                        $item('Central de Chamados', 'bx-task', site_url('os?minhas=1'), isset($menuOs) && ! empty($minhas));
                        $item('Chamados Sem Técnico', 'bx-user-x', site_url('os?semtecnico=1'), isset($menuOs) && ! empty($semTecnico), '', $qtdSemTec);
                        $item('Gerar OS em Branco', 'bx-printer', site_url('atalhos/osEmBranco'), false, ' target="_blank" rel="noopener"');
                    }
                }

                $outros = [];
                if ($pode('vVenda')) {
                    $outros[] = ['Vendas', 'bx-cart-alt', site_url('vendas'), isset($menuVendas)];
                }
                if ($pode('vGarantia')) {
                    $outros[] = ['Termos de Garantias', 'bx-receipt', site_url('garantias'), isset($menuGarantia)];
                }
                if ($pode('vArquivo')) {
                    $outros[] = ['Arquivos', 'bx-box', site_url('arquivos'), isset($menuArquivos)];
                }
                if ($pode('vLancamento')) {
                    $outros[] = ['Lançamentos', 'bx-bar-chart-alt-2', site_url('financeiro/lancamentos'), isset($menuLancamentos)];
                }
                if ($pode('vCobranca')) {
                    $outros[] = ['Cobranças', 'bx-dollar-circle', site_url('cobrancas/cobrancas'), isset($menuCobrancas)];
                }
                if ($outros) {
                    $secao('Outros módulos');
                    foreach ($outros as $o) {
                        $item($o[0], $o[1], $o[2], $o[3]);
                    }
                }
                ?>
            </ul>
        </div>

        <div class="botton-content">
            <li class="">
                <a class="tip-bottom" title="Sobre a Certimix" href="<?= site_url('Zenydesk.OS/sobre'); ?>">
                    <i class='bx bx-info-circle iconX'></i>
                    <span class="title">Sobre</span>
                    <span class="title-tooltip">Sobre a Certimix</span>
                </a>
            </li>
            <li class="">
                <a class="tip-bottom" title="" href="<?= site_url('login/sair'); ?>">
                    <i class='bx bx-log-out-circle iconX'></i>
                    <span class="title">Sair</span>
                    <span class="title-tooltip">Sair</span>
                </a>
            </li>
        </div>
    </div>
</nav>
<script>
    (function () {
        // Abre/fecha os grupos (Cadastros, Relatórios) e lembra a escolha.
        var chave = 'zd-menu-grupos';
        var salvos = {};
        try { salvos = JSON.parse(localStorage.getItem(chave) || '{}') || {}; } catch (e) {}

        document.querySelectorAll('#sidebar .zd-grupo').forEach(function (g) {
            var id = g.getAttribute('data-grupo');
            if (!g.classList.contains('zd-aberto') && salvos[id]) {
                g.classList.add('zd-aberto');
            }
            g.querySelector('.zd-grupo-toggle').addEventListener('click', function (e) {
                e.preventDefault();
                var aberto = g.classList.toggle('zd-aberto');
                this.setAttribute('aria-expanded', aberto ? 'true' : 'false');
                salvos[id] = aberto;
                try { localStorage.setItem(chave, JSON.stringify(salvos)); } catch (e2) {}
            });
        });
    })();
</script>
<!--End sidebar-menu-->
