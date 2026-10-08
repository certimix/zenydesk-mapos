<!DOCTYPE html>
<html lang="pt-br">

<head>
  <title>Zenydesk O.S</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-responsive.min.css" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/matrix-login.css" />
  <link href="<?= base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=20261008">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png?v=20261008">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png?v=20261008">
  <link rel="shortcut icon" type="image/png" href="<?= base_url(); ?>assets/img/favicon.png?v=20261008" />
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
                <div id="mcell" style="padding: 0 0 18px 0; color: #a0aec0; font-size: 11px; text-align: center;">Zenydesk-O.S &bull; v<?= $this->config->item('app_version'); ?></div>

                <!-- ABA 1: LOGIN -->
                <div id="view-login">
                  <div class="input-field">
                    <label class="fas fa-user" for="email"></label>
                    <input id="email" name="email" type="text" placeholder="Email">
                  </div>
                  <div class="input-field">
                    <label class="fas fa-lock" for="senha"></label>
                    <input name="senha" type="password" placeholder="Senha">
                  </div>
                  <div class="center">
                    <button id="btn-acessar" type="submit">Acessar</button>
                  </div>

                  <div class="login-options" style="margin-top: 16px; text-align: center; display: flex; flex-direction: column; gap: 8px; font-size: 13px;">
                    <a href="javascript:void(0)" id="link-esqueci" style="color: #60a5fa; text-decoration: none; font-weight: 500;">Esqueceu sua senha?</a>
                    <a href="javascript:void(0)" id="link-cadastrar" style="color: #34d399; text-decoration: none; font-weight: 600;">Não tem uma conta? Crie uma agora!</a>
                  </div>

                  <div class="links-uteis" style="margin-top: 14px; font-size: 13px; text-align: center;">
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
                </div>

                <!-- ABA 2: CADASTRAR CONTA -->
                <div id="view-cadastrar" style="display: none;">
                  <h3 style="color: #ffffff; text-align: center; font-size: 15px; margin: 0 0 16px 0; font-weight: 600;">Criar uma Conta</h3>
                  <div class="input-field">
                    <label class="fas fa-user" for="cad_nome"></label>
                    <input id="cad_nome" name="cad_nome" type="text" placeholder="Nome Completo">
                  </div>
                  <div class="input-field">
                    <label class="fas fa-envelope" for="cad_email"></label>
                    <input id="cad_email" name="cad_email" type="text" placeholder="E-mail">
                  </div>
                  <div class="input-field">
                    <label class="fas fa-lock" for="cad_senha"></label>
                    <input id="cad_senha" name="cad_senha" type="password" placeholder="Senha (mínimo 6 caracteres)">
                  </div>
                  <div class="input-field">
                    <label class="fas fa-check-double" for="cad_confirmar_senha"></label>
                    <input id="cad_confirmar_senha" name="cad_confirmar_senha" type="password" placeholder="Confirmar Senha">
                  </div>
                  <div class="center" style="margin-top: 14px;">
                    <button type="button" id="btn-cadastrar-submit" style="width: 100%; background: #10b981; color: #ffffff; border: none; border-radius: 22px; padding: 12px; font-weight: bold; cursor: pointer; font-size: 14px;">Criar Minha Conta</button>
                  </div>
                  <div style="margin-top: 16px; text-align: center;">
                    <a href="javascript:void(0)" class="link-voltar-login" style="color: #a0aec0; text-decoration: none; font-size: 13px;">Já possui uma conta? <strong style="color: #38bdf8;">Fazer Login</strong></a>
                  </div>
                </div>

                <!-- ABA 3: RECUPERAR SENHA -->
                <div id="view-recuperar" style="display: none;">
                  <h3 style="color: #ffffff; text-align: center; font-size: 15px; margin: 0 0 10px 0; font-weight: 600;">Recuperar Acesso</h3>
                  
                  <!-- ETAPA 1: Solicitar Código -->
                  <div id="rec-etapa-1">
                    <p style="color: #94a3b8; font-size: 12px; text-align: center; margin-bottom: 14px; line-height: 1.4;">
                      Informe seu e-mail cadastrado. Enviaremos um <strong>código de 8 dígitos</strong> (válido por 10 minutos).
                    </p>
                    <div class="input-field">
                      <label class="fas fa-envelope" for="rec_email"></label>
                      <input id="rec_email" name="rec_email" type="text" placeholder="Seu E-mail Cadastrado">
                    </div>
                    <div class="center" style="margin-top: 14px;">
                      <button type="button" id="btn-recuperar-solicitar" style="width: 100%; background: #0f7ade; color: #ffffff; border: none; border-radius: 22px; padding: 12px; font-weight: bold; cursor: pointer; font-size: 14px;">Enviar Código por E-mail</button>
                    </div>
                    <div style="margin-top: 16px; text-align: center;">
                      <a href="javascript:void(0)" class="link-voltar-login" style="color: #a0aec0; text-decoration: none; font-size: 13px;">Lembrou a senha? <strong style="color: #38bdf8;">Fazer Login</strong></a>
                    </div>
                  </div>

                  <!-- ETAPA 2: Redefinir Senha -->
                  <div id="rec-etapa-2" style="display: none;">
                    <p style="color: #38bdf8; font-size: 12px; text-align: center; margin-bottom: 14px; line-height: 1.4;">
                      Insira o código de 8 dígitos enviado para o seu e-mail e escolha sua nova senha.
                    </p>
                    <div class="input-field">
                      <label class="fas fa-key" for="rec_codigo"></label>
                      <input id="rec_codigo" name="rec_codigo" type="text" maxlength="8" placeholder="Código (8 caracteres)" style="text-transform: uppercase; font-weight: bold; letter-spacing: 2px;">
                    </div>
                    <div class="input-field">
                      <label class="fas fa-lock" for="rec_nova_senha"></label>
                      <input id="rec_nova_senha" name="rec_nova_senha" type="password" placeholder="Nova Senha">
                    </div>
                    <div class="input-field">
                      <label class="fas fa-check-double" for="rec_confirmar_nova_senha"></label>
                      <input id="rec_confirmar_nova_senha" name="rec_confirmar_nova_senha" type="password" placeholder="Confirmar Nova Senha">
                    </div>
                    <div class="center" style="margin-top: 14px;">
                      <button type="button" id="btn-recuperar-redefinir" style="width: 100%; background: #10b981; color: #ffffff; border: none; border-radius: 22px; padding: 12px; font-weight: bold; cursor: pointer; font-size: 14px;">Redefinir Senha</button>
                    </div>
                    <div style="margin-top: 16px; text-align: center; display: flex; justify-content: space-between; font-size: 12px;">
                      <a href="javascript:void(0)" id="link-reenviar-codigo" style="color: #38bdf8; text-decoration: none;">Reenviar código</a>
                      <a href="javascript:void(0)" class="link-voltar-login" style="color: #a0aec0; text-decoration: none;">Fazer Login</a>
                    </div>
                  </div>
                </div>

                <a href="#notification" id="call-modal" role="button" class="btn" data-toggle="modal" style="display: none ">notification</a>
                <div id="notification" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 id="myModalLabel">ZenyDesk</h4>
                  </div>
                  <div class="modal-body">
                    <h5 style="text-align: center" id="message">Os dados de acesso estão incorretos, por favor tente novamente!</h5>
                  </div>
                  <div class="modal-footer" style="display: flex; justify-content: center; gap: 10px;">
                    <button type="button" id="btn-modal-cadastrar" class="btn btn-success" style="display: none;">Criar Conta Agora</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Fechar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>

  <script src="<?= base_url() ?>assets/js/jquery-1.12.4.min.js"></script>
  <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
  <script src="<?= base_url() ?>assets/js/validate.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      // Alternar Visões na Interface de Login
      function mostrarVisao(visao) {
        $('#view-login, #view-cadastrar, #view-recuperar').hide();
        $('#' + visao).fadeIn(200);
        $('#btn-modal-cadastrar').hide();
      }

      var urlParams = new URLSearchParams(window.location.search);
      if (urlParams.get('action') === 'cadastrar' || window.location.hash === '#cadastrar') {
        mostrarVisao('view-cadastrar');
        $('#cad_nome').focus();
      } else if (urlParams.get('action') === 'recuperar' || window.location.hash === '#recuperar') {
        mostrarVisao('view-recuperar');
        $('#rec-etapa-1').show();
        $('#rec-etapa-2').hide();
        $('#rec_email').focus();
      } else {
        $('#email').focus();
      }

      $('#link-cadastrar').on('click', function() {
        mostrarVisao('view-cadastrar');
        $('#cad_nome').focus();
      });

      $('#link-esqueci').on('click', function() {
        mostrarVisao('view-recuperar');
        $('#rec-etapa-1').show();
        $('#rec-etapa-2').hide();
        $('#rec_email').focus();
      });

      $('.link-voltar-login').on('click', function() {
        mostrarVisao('view-login');
        $('#email').focus();
      });

      // Ação do Botão no Modal: "Criar Conta Agora"
      $('#btn-modal-cadastrar').on('click', function() {
        $('#notification').modal('hide');
        mostrarVisao('view-cadastrar');
        if ($('#rec_email').val()) {
          $('#cad_email').val($('#rec_email').val());
        }
        $('#cad_nome').focus();
      });

      // Cadastrar Conta via AJAX
      $('#btn-cadastrar-submit').on('click', function() {
        var csrfName = "<?= $this->security->get_csrf_token_name(); ?>";
        var csrfHash = $("input[name='" + csrfName + "']").val() || "<?= $this->security->get_csrf_hash(); ?>";

        var postData = {
          cad_nome: $('#cad_nome').val(),
          cad_email: $('#cad_email').val(),
          cad_senha: $('#cad_senha').val(),
          cad_confirmar_senha: $('#cad_confirmar_senha').val()
        };
        postData[csrfName] = csrfHash;

        $('#btn-cadastrar-submit').prop('disabled', true).text('Criando conta...');

        $.ajax({
          url: "<?= site_url('login/cadastrarConta'); ?>",
          type: "POST",
          dataType: "json",
          data: postData,
          success: function(res) {
            $('#btn-cadastrar-submit').prop('disabled', false).text('Criar Minha Conta');
            if (res.MAPOS_TOKEN) {
              $("input[name='" + csrfName + "']").val(res.MAPOS_TOKEN);
            }
            if (res.result) {
              window.location.href = res.redirect || "<?= site_url('Inicio'); ?>";
            } else {
              $('#btn-modal-cadastrar').hide();
              $('#message').text(res.message || 'Erro ao criar conta.');
              $('#call-modal').trigger('click');
            }
          },
          error: function() {
            $('#btn-cadastrar-submit').prop('disabled', false).text('Criar Minha Conta');
            $('#btn-modal-cadastrar').hide();
            $('#message').text('Ocorreu um erro de comunicação ao cadastrar conta.');
            $('#call-modal').trigger('click');
          }
        });
      });

      // Solicitar Código de 8 Dígitos via AJAX
      $('#btn-recuperar-solicitar').on('click', function() {
        var csrfName = "<?= $this->security->get_csrf_token_name(); ?>";
        var csrfHash = $("input[name='" + csrfName + "']").val() || "<?= $this->security->get_csrf_hash(); ?>";

        var postData = {
          rec_email: $('#rec_email').val()
        };
        postData[csrfName] = csrfHash;

        $('#btn-recuperar-solicitar').prop('disabled', true).text('Enviando código...');

        $.ajax({
          url: "<?= site_url('login/solicitarCodigo'); ?>",
          type: "POST",
          dataType: "json",
          data: postData,
          success: function(res) {
            $('#btn-recuperar-solicitar').prop('disabled', false).text('Enviar Código por E-mail');
            if (res.MAPOS_TOKEN) {
              $("input[name='" + csrfName + "']").val(res.MAPOS_TOKEN);
            }
            if (res.result) {
              $('#rec-etapa-1').hide();
              $('#rec-etapa-2').fadeIn(200);
              $('#rec_codigo').focus();
              $('#btn-modal-cadastrar').hide();
              $('#message').text(res.message);
              $('#call-modal').trigger('click');
            } else {
              if (res.no_account) {
                $('#btn-modal-cadastrar').show();
              } else {
                $('#btn-modal-cadastrar').hide();
              }
              $('#message').text(res.message || 'Erro ao solicitar código de recuperação.');
              $('#call-modal').trigger('click');
            }
          },
          error: function() {
            $('#btn-recuperar-solicitar').prop('disabled', false).text('Enviar Código por E-mail');
            $('#btn-modal-cadastrar').hide();
            $('#message').text('Ocorreu um erro de comunicação ao solicitar o código de recuperação.');
            $('#call-modal').trigger('click');
          }
        });
      });

      // Reenviar Código
      $('#link-reenviar-codigo').on('click', function() {
        $('#btn-recuperar-solicitar').trigger('click');
      });

      // Redefinir Senha via AJAX (com Código de 8 dígitos)
      $('#btn-recuperar-redefinir').on('click', function() {
        var csrfName = "<?= $this->security->get_csrf_token_name(); ?>";
        var csrfHash = $("input[name='" + csrfName + "']").val() || "<?= $this->security->get_csrf_hash(); ?>";

        var postData = {
          rec_email: $('#rec_email').val(),
          rec_codigo: $('#rec_codigo').val(),
          rec_nova_senha: $('#rec_nova_senha').val(),
          rec_confirmar_nova_senha: $('#rec_confirmar_nova_senha').val()
        };
        postData[csrfName] = csrfHash;

        $('#btn-recuperar-redefinir').prop('disabled', true).text('Redefinindo...');

        $.ajax({
          url: "<?= site_url('login/redefinirSenha'); ?>",
          type: "POST",
          dataType: "json",
          data: postData,
          success: function(res) {
            $('#btn-recuperar-redefinir').prop('disabled', false).text('Redefinir Senha');
            if (res.MAPOS_TOKEN) {
              $("input[name='" + csrfName + "']").val(res.MAPOS_TOKEN);
            }
            if (res.result) {
              $('#btn-modal-cadastrar').hide();
              $('#message').text(res.message);
              $('#call-modal').trigger('click');
              mostrarVisao('view-login');
              $('#email').val($('#rec_email').val());
              $('#senha').focus();
            } else {
              $('#btn-modal-cadastrar').hide();
              $('#message').text(res.message || 'Erro ao redefinir senha.');
              $('#call-modal').trigger('click');
            }
          },
          error: function() {
            $('#btn-recuperar-redefinir').prop('disabled', false).text('Redefinir Senha');
            $('#btn-modal-cadastrar').hide();
            $('#message').text('Ocorreu um erro de comunicação ao redefinir a senha.');
            $('#call-modal').trigger('click');
          }
        });
      });

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
                    $('#btn-modal-cadastrar').hide();
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
              $('#btn-modal-cadastrar').hide();
              $("#message").text(res.message || "Erro ao autenticar com o Google.");
              $("#call-modal").trigger("click");
            }
          },
          error: function() {
            $("#googleLoading").hide();
            $("#googleButtonWrapper").show();
            $('#btn-modal-cadastrar').hide();
            $("#message").text("Ocorreu um erro de comunicação ao autenticar com o Google.");
            $("#call-modal").trigger("click");
          }
        });
      }
    }
  </script>
</body>

</html>
