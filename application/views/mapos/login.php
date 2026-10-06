<!DOCTYPE html>
<html lang="pt-br">

<head>
  <title><?= $this->config->item('app_name') ?> </title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-responsive.min.css" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/matrix-login.css" />
  <link href="<?= base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="shortcut icon" type="image/png" href="<?= base_url(); ?>assets/img/favicon.png" />
  <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>

<body>
  <div class="main-login">
    <div class="left-login">
      <!-- Saudação -->
      <h1 class="h-one">
        <?php
        function saudacao($nome = '')
        {
            $hora = date('H');
            if ($hora >= 00 && $hora < 12) {
                return 'Olá! Bom dia' . (empty($nome) ? '' : ', ' . $nome);
            } elseif ($hora >= 12 && $hora < 18) {
                return 'Olá! Boa tarde' . (empty($nome) ? '' : ', ' . $nome);
            } else {
                return 'Olá! Boa noite' . (empty($nome) ? '' : ', ' . $nome);
            }
        }
  $login = 'bem-vindo';
  echo saudacao($login);
  // Irá retornar conforme o horário:
  ?>
      </h1>
      <h2 class="h-two"> Ao Sistema de Controle de Ordens de Serviço Zenydesk</h2>
      <img src="<?php echo base_url() ?>assets/img/dashboard-animate.svg" class="left-login-image" alt="ZenyDesk - Versão: <?= $this->config->item('app_version'); ?>">
    </div>
    <form class="form-vertical" id="formLogin" method="post" action="<?= site_url('login/verificarLogin') ?>">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
      <?php if ($this->session->flashdata('error') != null) { ?>
        <div id="loginbox">
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= $this->session->flashdata('error'); ?>
          </div>
        </div>
      <?php } ?>
      <div class="d-flex flex-column">
        <div class="right-login">
          <div class="container">
            <div class="card">
              <div class="content">
                <div id="newlog" style="display: flex; justify-content: center; align-items: center; margin-bottom: 8px;">
                  <a href="https://zenydesk.com" target="_blank" style="display: inline-block; text-decoration: none;">
                    <img src="<?= base_url() ?>assets/img/logo-zenydesk.png" alt="ZenyDesk" style="max-height: 45px; max-width: 220px; width: auto; height: auto; object-fit: contain;">
                  </a>
                </div>
                <div id="mcell" style="padding: 0 0 20px 0; color: #a0aec0; font-size: 11px; text-align: center;">Zenydesk-O.S &bull; v<?= $this->config->item('app_version'); ?></div>
                <div class="input-field">
                  <label class="fas fa-user" for="nome"></label>
                  <input id="email" name="email" type="text" placeholder="Email">
                </div>
                <div class="input-field">
                  <label class="fas fa-lock" for="senha"></label>
                  <input name="senha" type="password" placeholder="Senha">
                </div>
                <div class="center">
                  <button id="btn-acessar">Acessar</button>
                </div>
                <div class="links-uteis" style="margin-top: 18px; font-size: 13px; text-align: center;">
                  <a href="https://zenydesk.com" target="_blank" style="color: #a0aec0; text-decoration: none; font-weight: 500;">
                    zenydesk.com
                  </a>
                </div>

                <!-- Divisor Google -->
                <div style="display: flex; align-items: center; text-align: center; margin: 18px 0 14px 0;">
                  <div style="flex-grow: 1; border-bottom: 1px solid rgba(255, 255, 255, 0.12);"></div>
                  <span style="padding: 0 10px; color: #718096; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">ou continue com</span>
                  <div style="flex-grow: 1; border-bottom: 1px solid rgba(255, 255, 255, 0.12);"></div>
                </div>

                <!-- Botão Oficial Google Identity Services & Fallback -->
                <div id="googleButtonWrapper" style="display: flex; justify-content: center; width: 100%; min-height: 44px;">
                  <div id="googleButtonContainer" style="display: flex; justify-content: center; width: 100%;"></div>
                </div>

                <button type="button" id="btnGoogleCustom" style="display: none; width: 100%; background: #ffffff; color: #1f2937; border: 1px solid #e5e7eb; border-radius: 22px; padding: 10px 16px; font-size: 13px; font-weight: 600; cursor: pointer; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-top: 4px;">
                  <svg width="18" height="18" viewBox="0 0 24 24"><path fill="#EA4335" d="M12 5c1.6 0 3 .6 4.1 1.6l3.1-3.1C17.3 1.8 14.8 1 12 1 7.5 1 3.7 3.6 1.9 7.3l3.7 2.9C6.5 7.4 9 5 12 5z"/><path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.6h6.5c-.3 1.5-1.1 2.8-2.4 3.7l3.7 2.9c2.2-2 3.7-5 3.7-8.9z"/><path fill="#FBBC05" d="M5.6 14.8c-.2-.7-.4-1.5-.4-2.3 0-.8.2-1.6.4-2.3L1.9 7.3C.7 9.7 0 12.3 0 15s.7 5.3 1.9 7.7l3.7-2.9z"/><path fill="#34A853" d="M12 23c3.2 0 6-1.1 8-3l-3.7-2.9c-1.1.7-2.5 1.2-4.3 1.2-3 0-5.5-2.4-6.4-5.2L1.9 16C3.7 19.7 7.5 23 12 23z"/></svg>
                  <span>Entrar com o Google</span>
                </button>

                <div id="googleLoading" style="display: none; text-align: center; color: #38bdf8; font-size: 12px; margin-top: 10px;">
                  <i class="fas fa-spinner fa-spin" style="margin-right: 6px;"></i> Conectando com o Google...
                </div>
                <a href="#notification" id="call-modal" role="button" class="btn" data-toggle="modal" style="display: none ">notification</a>
                <div id="notification" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-header">
                    <h4 id="myModalLabel">ZenyDesk</h4>
                  </div>
                  <div class="modal-body">
                    <h5 style="text-align: center" id="message">Os dados de acesso estão incorretos, por favor tente novamente!</h5>
                  </div>
                  <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Fechar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <a href="#notification" id="call-modal" role="button" class="btn" data-toggle="modal" style="display: none ">notification</a>
      <div id="notification" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <h4 id="myModalLabel">ZenyDesk</h4>
        </div>
        <div class="modal-body">
          <h5 style="text-align: center" id="message">Os dados de acesso estão incorretos, por favor tente novamente!</h5>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Fechar</button>
        </div>
      </div>
    </form>
  </div>

  <script src="<?= base_url() ?>assets/js/jquery-1.12.4.min.js"></script>
  <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
  <script src="<?= base_url() ?>assets/js/validate.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#email').focus();
      $("#formLogin").validate({
        rules: {
          email: {
            required: true,
            email: true
          },
          senha: {
            required: true
          }
        },
        messages: {
          email: {
            required: '',
            email: 'Insira Email válido'
          },
          senha: {
            required: 'Campos Requeridos.'
          }
        },
        submitHandler: function(form) {
          var dados = $(form).serialize();
          $('#btn-acessar').addClass('disabled');
          $('#progress-acessar').removeClass('hide');

          $.ajax({
            type: "POST",
            url: "<?= site_url('login/verificarLogin?ajax=true'); ?>",
            data: dados,
            dataType: 'json',
            success: function(data) {
                if (data.result == true) {
                    window.location.href = "<?= site_url('mapos'); ?>";
                } else {
                    $('#btn-acessar').removeClass('disabled');
                    $('#progress-acessar').addClass('hide');
                    $('#message').text(data.message || 'Os dados de acesso estão incorretos, por favor tente novamente!');
                    $('#call-modal').trigger('click');

                    // Atualiza o token a cada requisição
                    var newCsrfToken = data.MAPOS_TOKEN; 
                    $("input[name='<?= $this->security->get_csrf_token_name(); ?>']").val(newCsrfToken);
                    
                }
            }
          });

          return false;
        },

        errorClass: "help-inline",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
          $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).parents('.control-group').removeClass('error');
          $(element).parents('.control-group').addClass('success');
        }
      });

      // Configuração e Renderização do Google Identity Services
      var GOOGLE_CLIENT_ID = "<?= $_ENV['GOOGLE_CLIENT_ID'] ?? '615444982313-dvtl6p7jtb7smte977430comtvu118ge.apps.googleusercontent.com'; ?>";

      function inicializarGoogleAuth() {
        if (window.google && window.google.accounts && window.google.accounts.id) {
          try {
            google.accounts.id.initialize({
              client_id: GOOGLE_CLIENT_ID,
              callback: handleGoogleCredentialResponse,
              auto_select: false,
              cancel_on_tap_outside: true
            });
            google.accounts.id.renderButton(
              document.getElementById("googleButtonContainer"),
              {
                type: "standard",
                theme: "outline",
                size: "large",
                text: "continue_with",
                shape: "pill",
                logo_alignment: "left",
                width: 280,
                locale: "pt-BR"
              }
            );
          } catch (err) {
            console.warn("Google Render:", err);
            $("#googleButtonContainer").hide();
            $("#btnGoogleCustom").css('display', 'flex');
          }
        } else {
          setTimeout(inicializarGoogleAuth, 300);
        }
      }

      inicializarGoogleAuth();

      $("#btnGoogleCustom").on('click', function() {
        if (window.google && window.google.accounts && window.google.accounts.id) {
          google.accounts.id.prompt();
        } else {
          alert("Serviço do Google temporariamente indisponível.");
        }
      });
    });

    function handleGoogleCredentialResponse(response) {
      if (response && response.credential) {
        $("#googleLoading").show();
        $("#googleButtonWrapper").hide();
        $("#btnGoogleCustom").hide();

        var csrfName = "<?= $this->security->get_csrf_token_name(); ?>";
        var csrfHash = $("input[name='" + csrfName + "']").val() || "<?= $this->security->get_csrf_hash(); ?>";

        var postData = {
          credential: response.credential
        };
        postData[csrfName] = csrfHash;

        $.ajax({
          url: "<?= site_url('login/googleAuth'); ?>",
          type: "POST",
          dataType: "json",
          data: postData,
          success: function(res) {
            if (res.result) {
              window.location.href = res.redirect || "<?= site_url('mapos'); ?>";
            } else {
              $("#googleLoading").hide();
              $("#googleButtonWrapper").show();
              $("#message").text(res.message || "Erro ao autenticar com o Google.");
              $("#call-modal").trigger("click");
            }
          },
          error: function() {
            $("#googleLoading").hide();
            $("#googleButtonWrapper").show();
            $("#message").text("Ocorreu um erro de comunicação ao autenticar com o Google.");
            $("#call-modal").trigger("click");
          }
        });
      }
    }
  </script>
</body>

</html>
