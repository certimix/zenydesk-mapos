<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>OS em branco</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #222; margin: 0; background: #f1f3f8; }
        .folha { width: 210mm; min-height: 297mm; margin: 16px auto; background: #fff; padding: 12mm; }
        .acoes { text-align: center; margin: 14px 0 0; }
        .acoes button { background: #17b8a6; color: #fff; border: 0; border-radius: 6px; padding: 9px 18px; font-size: 14px; cursor: pointer; }
        .cab { display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #13263f; padding-bottom: 8px; margin-bottom: 10px; }
        .cab img { max-height: 55px; max-width: 160px; }
        .cab .emp { font-size: 11px; line-height: 1.4; }
        .cab .emp strong { font-size: 14px; }
        .num { text-align: right; }
        .num .t { font-size: 18px; font-weight: bold; color: #13263f; }
        .num .n { margin-top: 6px; border: 1px solid #999; width: 140px; height: 26px; display: inline-block; }
        h4 { background: #13263f; color: #fff; margin: 12px 0 0; padding: 4px 8px; font-size: 12px; text-transform: uppercase; letter-spacing: .5px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { border: 1px solid #999; padding: 4px 6px; vertical-align: top; text-align: left; }
        td .r { font-size: 10px; color: #555; display: block; }
        td { height: 30px; }
        .linhas td { height: 24px; }
        .alta td { height: 70px; }
        .chk { display: inline-block; width: 11px; height: 11px; border: 1px solid #555; vertical-align: middle; margin: 0 4px 0 10px; }
        .ass { display: flex; gap: 30px; margin-top: 40px; }
        .ass div { flex: 1; border-top: 1px solid #333; text-align: center; padding-top: 4px; font-size: 11px; }
        .termo { font-size: 10px; color: #444; margin-top: 10px; line-height: 1.4; }
        @media print {
            body { background: #fff; }
            .folha { margin: 0; width: auto; min-height: 0; padding: 8mm; }
            .acoes { display: none; }
            @page { size: A4; margin: 6mm; }
        }
    </style>
</head>
<body>
<div class="acoes"><button onclick="window.print()">Imprimir</button></div>
<div class="folha">
    <div class="cab">
        <div style="display:flex;align-items:center;gap:12px">
            <?php if ($emitente && ! empty($emitente->url_logo)) { ?>
                <img src="<?= html_escape($emitente->url_logo) ?>" alt="">
            <?php } ?>
            <div class="emp">
                <?php if ($emitente) { ?>
                    <strong><?= html_escape($emitente->nome) ?></strong><br>
                    <?= $emitente->cnpj ? 'CNPJ: ' . html_escape($emitente->cnpj) . '<br>' : '' ?>
                    <?= html_escape(trim("{$emitente->rua}, {$emitente->numero} - {$emitente->bairro}", ' ,-')) ?><br>
                    <?= html_escape(trim("{$emitente->cidade}/{$emitente->uf}", '/')) ?>
                    <?= $emitente->telefone ? ' • ' . html_escape($emitente->telefone) : '' ?>
                <?php } else { ?>
                    <strong><?= html_escape($configuration['app_name'] ?? '') ?></strong>
                <?php } ?>
            </div>
        </div>
        <div class="num">
            <div class="t">ORDEM DE SERVIÇO</div>
            Nº <span class="n"></span>
        </div>
    </div>

    <table>
        <tr>
            <td style="width:25%"><span class="r">Data de entrada</span></td>
            <td style="width:25%"><span class="r">Hora</span></td>
            <td style="width:25%"><span class="r">Previsão de entrega</span></td>
            <td style="width:25%"><span class="r">Técnico</span></td>
        </tr>
    </table>

    <h4>Cliente</h4>
    <table>
        <tr><td colspan="3"><span class="r">Nome / Razão social</span></td><td><span class="r">CPF / CNPJ</span></td></tr>
        <tr><td colspan="2"><span class="r">Endereço</span></td><td><span class="r">Cidade/UF</span></td><td><span class="r">Telefone / WhatsApp</span></td></tr>
        <tr><td colspan="2"><span class="r">E-mail</span></td><td colspan="2"><span class="r">Contato no local</span></td></tr>
    </table>

    <h4>Equipamento</h4>
    <table>
        <tr>
            <td><span class="r">Equipamento</span></td>
            <td><span class="r">Marca</span></td>
            <td><span class="r">Modelo</span></td>
            <td><span class="r">Nº de série / Patrimônio</span></td>
        </tr>
        <tr>
            <td colspan="4">
                <span class="r">Acompanha</span>
                <span class="chk"></span>Carregador <span class="chk"></span>Cabo <span class="chk"></span>Bateria
                <span class="chk"></span>Bolsa/Case <span class="chk"></span>Outros: ______________________
            </td>
        </tr>
    </table>

    <h4>Defeito relatado pelo cliente</h4>
    <table class="alta"><tr><td></td></tr></table>

    <h4>Diagnóstico técnico</h4>
    <table class="alta"><tr><td></td></tr></table>

    <h4>Serviços e peças</h4>
    <table class="linhas">
        <tr><th style="width:55%">Descrição</th><th style="width:10%">Qtd</th><th style="width:17%">Valor unit.</th><th style="width:18%">Total</th></tr>
        <?php for ($i = 0; $i < 7; $i++) { ?>
            <tr><td></td><td></td><td></td><td></td></tr>
        <?php } ?>
        <tr><td colspan="3" style="text-align:right"><b>Desconto</b></td><td></td></tr>
        <tr><td colspan="3" style="text-align:right"><b>TOTAL</b></td><td></td></tr>
    </table>

    <table style="margin-top:8px">
        <tr>
            <td>
                <span class="r">Situação</span>
                <span class="chk"></span>Orçamento <span class="chk"></span>Aprovado <span class="chk"></span>Em andamento
                <span class="chk"></span>Aguardando peças <span class="chk"></span>Finalizado
            </td>
        </tr>
        <tr>
            <td>
                <span class="r">Pagamento</span>
                <span class="chk"></span>Dinheiro <span class="chk"></span>PIX <span class="chk"></span>Cartão
                <span class="chk"></span>Boleto <span class="chk"></span>Garantia (sem custo)
            </td>
        </tr>
    </table>

    <div class="termo">
        Declaro que as informações acima conferem e autorizo a execução dos serviços descritos nesta ordem.
    </div>

    <div class="ass">
        <div>Assinatura do cliente</div>
        <div>Assinatura do técnico</div>
        <div>Data de retirada: ____/____/______</div>
    </div>
</div>
</body>
</html>
