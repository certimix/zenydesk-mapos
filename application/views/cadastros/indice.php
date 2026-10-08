<?php
/**
 * Índice de todos os cadastros (o link "Cadastros" do menu, quando clicado direto).
 * Variáveis: $entidades
 */
$extras = [];
if ($this->permission->checkPermission($this->session->userdata('permissao'), 'cUsuario')) {
    $extras[] = ['Usuários / Técnico', 'bx-user-circle', site_url('usuarios')];
}
if ($this->permission->checkPermission($this->session->userdata('permissao'), 'cPermissao')) {
    $extras[] = ['Perfis de Acesso', 'bx-lock-alt', site_url('permissoes')];
}
if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
    $extras[] = ['Clientes', 'bx-user', site_url('clientes')];
}
if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')) {
    $extras[] = ['Produtos', 'bx-basket', site_url('produtos')];
}
if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vServico')) {
    $extras[] = ['Modelo de Serviços', 'bx-wrench', site_url('servicos')];
}

$itens = $extras;
foreach ($entidades as $chave => $ent) {
    $itens[] = [$ent['titulo'], $ent['icone'], site_url("cadastros/{$chave}")];
}
usort($itens, function ($a, $b) {
    return strcoll($a[0], $b[0]);
});
?>
<style>
    .cad-grade { display: grid; grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); gap: 12px; padding: 16px; }
    .cad-grade a { display: flex; align-items: center; gap: 10px; padding: 14px; border: 1px solid #e4e8f0; border-radius: 8px; background: #fff; color: #2c3344; text-decoration: none; }
    .cad-grade a:hover { border-color: #17b8a6; color: #0f9c8c; }
    .cad-grade i { font-size: 22px; color: #17b8a6; }
</style>
<div class="new122">
    <div class="widget-title" style="margin: -20px 0 0">
        <span class="icon"><i class="bx bx-folder-open"></i></span>
        <h5>Cadastros</h5>
    </div>
    <div class="cad-grade">
        <?php foreach ($itens as [$titulo, $icone, $url]) { ?>
            <a href="<?= $url ?>"><i class="bx <?= html_escape($icone) ?>"></i> <?= html_escape($titulo) ?></a>
        <?php } ?>
    </div>
</div>
