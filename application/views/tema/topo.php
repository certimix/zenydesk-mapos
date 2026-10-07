<!DOCTYPE html>
<html lang="pt-br">

<?php $configuration = (isset($configuration) && is_array($configuration)) ? $configuration : []; ?>
<head>
  <title><?= (!empty($configuration['app_name']) && $configuration['app_name'] !== 'Certimix OS') ? $configuration['app_name'] : 'Zenydesk OS' ?></title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token-name" content="<?= $this->config->item("csrf_token_name") ?>">
  <meta name="csrf-cookie-name" content="<?= $this->config->item("csrf_cookie_name") ?>">
  <meta name="csrf-token-hash" content="<?= $this->security->get_csrf_hash() ?>">
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <link rel="shortcut icon" type="image/png" href="<?= base_url(); ?>assets/img/favicon.png" />
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap-responsive.min.css" />
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/matrix-style.css" />
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/matrix-media.css" />
  <link href="<?= base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/fullcalendar.css" />
  <?php $appTheme = $configuration['app_theme'] ?? ''; ?>
  <?php if ($appTheme === 'white') { ?>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/tema-white.css" />
  <?php } ?>
  <?php if ($appTheme === 'puredark') { ?>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/tema-pure-dark.css" />
  <?php } ?>
  <?php if ($appTheme === 'darkviolet') { ?>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/tema-dark-violet.css" />
  <?php } ?>
  <?php if ($appTheme === 'darkorange') { ?>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/tema-dark-orange.css" />
  <?php } ?>
  <?php if ($appTheme === 'whitegreen') { ?>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/tema-white-green.css" />
  <?php } ?>
  <?php if ($appTheme === 'whiteblack') { ?>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/tema-white-black.css" />
  <?php } ?>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;500;700&display=swap' rel='stylesheet' type='text/css'>
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-1.12.4.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/shortcut.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/funcoesGlobal.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/datatables.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/sweetalert.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/csrf.js"></script>
  <script type="text/javascript">
    shortcut.add("escape", function() {
      location.href = '<?= base_url(); ?>';
    });
    shortcut.add("F1", function() {
      location.href = '<?= site_url('clientes'); ?>';
    });
    shortcut.add("F2", function() {
      location.href = '<?= site_url('produtos'); ?>';
    });
    shortcut.add("F3", function() {
      location.href = '<?= site_url('servicos'); ?>';
    });
    shortcut.add("F4", function() {
      location.href = '<?= site_url('os'); ?>';
    });
    //shortcut.add("F5", function() {});
    shortcut.add("F6", function() {
      location.href = '<?= site_url('vendas/adicionar'); ?>';
    });
    shortcut.add("F7", function() {
      location.href = '<?= site_url('financeiro/lancamentos'); ?>';
    });
    shortcut.add("F8", function() {});
    shortcut.add("F9", function() {});
    shortcut.add("F10", function() {});
    //shortcut.add("F11", function() {});
    shortcut.add("F12", function() {});
    window.BaseUrl = "<?= base_url() ?>";
  </script>
</head>

<body>
  <!--top-Header-menu-->
  <div class="navebarn">
    <div id="user-nav" class="navbar navbar-inverse">
      <ul class="nav">
        <li class="dropdown">
          <a href="#" class="tip-right dropdown-toggle" data-toggle="dropdown" title="Perfis"><i class='bx bx-user-circle iconN'></i><span class="text"></span></a>
          <ul class="dropdown-menu">
            <li class=""><a title="Área do Cliente" href="<?= site_url(); ?>/mine" target="_blank"> <span class="text">Área do Cliente</span></a></li>
            <li class=""><a title="Meu Perfil" href="<?= site_url('Zenydesk.OS/minhaConta'); ?>"><span class="text">Meu Perfil</span></a></li>
            <li class=""><a title="Sobre a Certimix" href="<?= site_url('Zenydesk.OS/sobre'); ?>"><span class="text">Sobre a Certimix</span></a></li>
            <li class="divider"></li>
            <li class=""><a title="Sair do Sistema" href="<?= site_url('login/sair'); ?>"><i class='bx bx-log-out-circle'></i> <span class="text">Sair do Sistema</span></a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="tip-right dropdown-toggle" data-toggle="dropdown" title="Relatórios"><i class='bx bx-pie-chart-alt-2 iconN'></i><span class="text"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?= site_url('relatorios/clientes') ?>">Clientes</a></li>
            <li><a href="<?= site_url('relatorios/produtos') ?>">Produtos</a></li>
            <li><a href="<?= site_url('relatorios/servicos') ?>">Serviços</a></li>
            <li><a href="<?= site_url('relatorios/os') ?>">Ordens de Serviço</a></li>
            <li><a href="<?= site_url('relatorios/vendas') ?>">Vendas</a></li>
            <li><a href="<?= site_url('relatorios/financeiro') ?>">Financeiro</a></li>
            <li><a href="<?= site_url('relatorios/sku') ?>">SKU</a></li>
            <li><a href="<?= site_url('relatorios/receitasBrutasMei') ?>">Receitas Brutas - MEI</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="tip-right dropdown-toggle" data-toggle="dropdown" title="Configurações"><i class='bx bx-cog iconN'></i><span class="text"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?= site_url('Zenydesk.OS/configurar') ?>">Sistema</a></li>
            <li><a href="<?= site_url('usuarios') ?>">Usuários</a></li>
            <li><a href="<?= site_url('Zenydesk.OS/emitente') ?>">Emitente</a></li>
            <li><a href="<?= site_url('permissoes') ?>">Permissões</a></li>
            <li><a href="<?= site_url('auditoria') ?>">Auditoria</a></li>
            <li><a href="<?= site_url('Zenydesk.OS/emails') ?>">Emails</a></li>
            <li><a href="<?= site_url('Zenydesk.OS/backup') ?>">Backup</a></li>
          </ul>
        </li>
      </ul>
    </div>

    <!-- New User -->
    <div id="userr" style="padding-right:45px;display:flex;flex-direction:column;align-items:flex-end;justify-content:center;">
      <div class="user-names userT0">
        <?php
        if (!function_exists('saudacao')) {
            function saudacao()
            {
                $hora = (int) date('H');
                if ($hora >= 0 && $hora < 12) {
                    return 'Bom dia, ';
                } elseif ($hora >= 12 && $hora < 18) {
                    return 'Boa tarde, ';
                } else {
                    return 'Boa noite, ';
                }
            }
        }

        echo saudacao();
        ?>
      </div>
      <div class="userT"><?= $this->session->userdata('nome_admin') ?></div>

      <section class="sec_profile">
        <div class="profile">
          <div class="profile-img">
            <?php
            $userPhoto = $this->session->userdata('url_image_user_admin');
            if (empty($userPhoto)) {
                $userPhoto = $this->session->userdata('url_image_user');
            }
            if ((empty($userPhoto) || !is_file(FCPATH . 'assets/userImage/' . $userPhoto)) && $this->session->userdata('id_admin')) {
                $dbInstance = isset($this->db) ? $this->db : null;
                if ($dbInstance) {
                    $dbUser = $dbInstance->select('url_image_user')->get_where('usuarios', ['idUsuarios' => $this->session->userdata('id_admin')])->row();
                    if ($dbUser && !empty($dbUser->url_image_user) && is_file(FCPATH . 'assets/userImage/' . $dbUser->url_image_user)) {
                        $userPhoto = $dbUser->url_image_user;
                        $this->session->set_userdata('url_image_user_admin', $userPhoto);
                        $this->session->set_userdata('url_image_user', $userPhoto);
                    }
                }
            }
            $userAvatarUrl = (!empty($userPhoto) && is_file(FCPATH . 'assets/userImage/' . $userPhoto))
                ? base_url('assets/userImage/' . $userPhoto)
                : base_url('assets/img/User.png');
            ?>
            <a href="<?= site_url('Zenydesk.OS/minhaConta'); ?>"><img src="<?= $userAvatarUrl ?>" alt=""></a>
          </div>
        </div>
      </section>

    </div>
  </div>
  <!-- End User -->

  <!--start-top-serch-->
  <div style="display: none" id="search">
    <form action="<?= site_url('Zenydesk.OS/pesquisar') ?>">
      <input type="text" name="termo" placeholder="Pesquisar..." />
      <button type="submit" class="tip-bottom" title="Pesquisar"><i class="fas fa-search fa-white"></i></button>
    </form>
  </div>
  <!--close-top-serch-->
