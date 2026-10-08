<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avalie nosso atendimento — ZenyDesk OS</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: "DM Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; background: #eef5fb; color: #2b3035; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 16px; }
        .cartao { background: #fff; border-radius: 14px; box-shadow: 0 6px 24px rgba(20, 50, 90, .10); width: 100%; max-width: 480px; padding: 28px 24px; text-align: center; }
        .logo { max-width: 200px; max-height: 44px; margin-bottom: 14px; object-fit: contain; }
        h1 { font-size: 22px; color: #0284c7; margin: 0 0 6px; font-weight: 800; }
        .sub { color: #6b7480; font-size: 14px; margin: 0 0 18px; line-height: 1.45; }
        .escala-notas { display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px; margin: 12px 0 20px; }
        .escala-item { position: relative; }
        .escala-item input { position: absolute; opacity: 0; width: 0; height: 0; }
        .escala-btn {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            height: 60px; border-radius: 10px; border: 2px solid #e2e8f0; background: #f8fafc;
            cursor: pointer; transition: all .15s ease-in-out;
        }
        .escala-num { font-size: 20px; font-weight: 800; color: #334155; }
        .escala-rotulo { font-size: 10px; font-weight: 600; text-transform: uppercase; color: #64748b; margin-top: 2px; }
        .escala-item:hover .escala-btn { border-color: #38bdf8; background: #f0f9ff; }
        .escala-item input:checked + .escala-btn {
            border-color: #0284c7; background: #0284c7; color: #fff;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.35); transform: translateY(-2px);
        }
        .escala-item input:checked + .escala-btn .escala-num,
        .escala-item input:checked + .escala-btn .escala-rotulo { color: #ffffff; }
        .escala-item input:focus-visible + .escala-btn { outline: 2px solid #0284c7; outline-offset: 2px; }
        textarea { width: 100%; min-height: 96px; border: 1px solid #ced4da; border-radius: 8px; padding: 10px 12px; font: inherit; font-size: 14px; resize: vertical; background: #f9fafb; }
        textarea:focus { outline: none; border-color: #0284c7; box-shadow: 0 0 0 3px rgba(2, 132, 199, .15); background: #fff; }
        button { margin-top: 14px; width: 100%; border: 0; border-radius: 8px; background: #16a34a; color: #fff; font: inherit; font-weight: 700; font-size: 15px; padding: 12px; cursor: pointer; transition: background .15s; }
        button:hover { background: #15803d; }
        .erro { background: #fdecef; color: #a3243b; border-radius: 8px; padding: 8px 12px; font-size: 13px; margin-bottom: 12px; }
        .ok-icone { font-size: 48px; color: #16a34a; margin-bottom: 8px; }
        .nota-final-box { display: inline-flex; align-items: center; gap: 8px; background: #dcfce7; border: 1px solid #bbf7d0; color: #166534; font-size: 18px; font-weight: 700; padding: 8px 16px; border-radius: 8px; margin: 10px 0; }
        .os-info { font-size: 12.5px; color: #8a94a0; margin-top: 16px; border-top: 1px solid #f1f5f9; padding-top: 12px; }
        .sr { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); }
    </style>
</head>
<body>
<div class="cartao">
    <img class="logo" src="<?= ($emitente && ! empty($emitente->url_logo)) ? html_escape($emitente->url_logo) : base_url('assets/img/logo-zenydesk.png') ?>" alt="ZenyDesk">

    <?php if (! $av) { ?>
        <h1>Link inválido</h1>
        <p class="sub">Este link de avaliação não existe ou foi digitado incorretamente.</p>

    <?php } elseif ($av->respondido_em) { ?>
        <div class="ok-icone"><i class='bx bx-check-circle'></i></div>
        <h1><?= $enviado ? 'Obrigado pela sua avaliação!' : 'Avaliação já registrada' ?></h1>
        <p class="sub">Sua opinião sobre a OS #<?= (int) $av->idOs ?> foi computada com sucesso.</p>
        <div class="nota-final-box">
            <i class='bx bx-badge-check'></i> Nota <?= (int) $av->nota ?> de 5
        </div>

    <?php } else { ?>
        <h1>Como foi nosso atendimento?</h1>
        <p class="sub">
            Olá<?= $av->nomeCliente ? ', ' . html_escape($av->nomeCliente) : '' ?>! Avalie o serviço realizado na
            <strong>OS #<?= (int) $av->idOs ?></strong><?= $av->tecnico ? ' pelo técnico ' . html_escape($av->tecnico) : '' ?>.
        </p>

        <?php if ($erro) { ?><div class="erro" role="alert"><?= html_escape($erro) ?></div><?php } ?>

        <form method="post" action="<?= site_url('avaliacao/' . $token) ?>">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
            <fieldset style="border:0;padding:0;margin:0">
                <legend class="sr">Selecione uma nota de 1 a 5</legend>
                <div class="escala-notas">
                    <?php
                    $rotulos = [1 => 'Péssimo', 2 => 'Ruim', 3 => 'Regular', 4 => 'Bom', 5 => 'Excelente'];
                    for ($n = 1; $n <= 5; $n++) { ?>
                        <div class="escala-item">
                            <input type="radio" name="nota" id="nota<?= $n ?>" value="<?= $n ?>" <?= (int) $this->input->post('nota') === $n ? 'checked' : '' ?> required>
                            <label class="escala-btn" for="nota<?= $n ?>">
                                <span class="escala-num"><?= $n ?></span>
                                <span class="escala-rotulo"><?= $rotulos[$n] ?></span>
                            </label>
                        </div>
                    <?php } ?>
                </div>
            </fieldset>
            <label for="comentario" class="sr">Comentário</label>
            <textarea id="comentario" name="comentario" maxlength="2000" placeholder="Conte mais detalhes sobre sua experiência (opcional)"><?= html_escape((string) $this->input->post('comentario')) ?></textarea>
            <button type="submit"><i class='bx bx-send'></i> Confirmar Avaliação</button>
        </form>
    <?php } ?>

    <?php if ($emitente) { ?>
        <div class="os-info"><?= html_escape($emitente->nome) ?></div>
    <?php } ?>
</div>
</body>
</html>
