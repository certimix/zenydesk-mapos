<style>
    select {
        width: 70px;
    }
    .situacao-ativo {
        background-color: #00cd00;
        color: white;
    }
    .situacao-inativo {
        background-color: #ff0000;
        color: white;
    }
</style>

<div class="new122">
    <div class="widget-title" style="margin:-15px -10px 0">
        <h5>Usuários</h5>
    </div>
    <div style="display: flex; gap: 10px; margin-bottom: 12px; align-items: center;">
        <a href="<?= base_url('index.php/usuarios/adicionar') ?>" class="button btn btn-success" style="max-width: 160px">
            <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2">Adicionar Usuário</span>
        </a>
        <a href="#modal-funcoes" role="button" data-toggle="modal" class="button btn btn-primary btn-abrir-funcoes-geral" style="max-width: 160px">
            <span class="button__icon"><i class='bx bx-id-card'></i></span><span class="button__text2">Funções</span>
        </a>
    </div>

    <div class="widget-box">
        <div class="widget-title" style="margin: -20px 0 0">
            <span class="icon">
                <i class="fas fa-cash-register"></i>
            </span>
            <h5 style="padding: 3px 0"></h5>
        </div>
        <div class="widget-content nopadding tab-content">
            <table id="tabela" class="table table-bordered ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>Nível</th>
                        <th>Situação</th>
                        <th>Validade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($results)): ?>
                        <tr>
                            <td colspan="8">Nenhum Usuário Cadastrado</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($results as $r): ?>
                            <tr>
                                <td><?= $r->idUsuarios ?></td>
                                <td><?= $r->nome ?></td>
                                <td><?= $r->cpf ?></td>
                                <td><?= $r->telefone ?></td>
                                <td>
                                    <?php
                                    $badgeCor = '#0f7ade';
                                    if (stripos($r->permissao, 'Desenvolvedor') !== false) {
                                        $badgeCor = '#8b5cf6';
                                    } elseif (stripos($r->permissao, 'Suporte') !== false) {
                                        $badgeCor = '#10b981';
                                    } elseif (stripos($r->permissao, 'Admin') !== false) {
                                        $badgeCor = '#0284c7';
                                    }
                                    ?>
                                    <span class="badge" style="background-color: <?= $badgeCor ?>; color: white; border-radius: 6px; padding: 4px 8px; font-weight: 500; font-size: 11px;"><?= $r->permissao ?></span>
                                    <?php if (!empty($r->permissao_secundaria)): ?>
                                        <span class="badge" style="background-color: #475569; color: white; border-radius: 6px; padding: 4px 8px; font-weight: 500; font-size: 11px; margin-left: 4px;"><?= $r->permissao_secundaria ?></span>
                                    <?php endif; ?>
                                </td>
                                <?php
                                $situacao = ($r->situacao == 1) ? 'Ativo' : 'Inativo';
                                $situacaoClasse = ($r->situacao == 1) ? 'situacao-ativo' : 'situacao-inativo';
                                ?>
                                <td><span class="badge <?= $situacaoClasse ?>"><?= ucfirst($situacao) ?></span></td>
                                <td><?= $r->dataExpiracao ?></td>
                                <td>
                                    <a href="<?= base_url('index.php/usuarios/editar/' . $r->idUsuarios) ?>" class="btn-nwe3" title="Editar Usuário" style="margin-right: 4px;"><i class="bx bx-edit"></i></a>
                                    <a href="#modal-funcoes" role="button" data-toggle="modal" class="btn-nwe2 btn-delegar-funcao" data-id="<?= $r->idUsuarios ?>" data-nome="<?= html_escape($r->nome) ?>" data-email="<?= html_escape($r->email ?? '') ?>" data-permissao="<?= $r->permissoes_id ?>" title="Delegar Função"><i class="bx bx-id-card"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->pagination->create_links(); ?>

<!-- Modal Delegar Funções -->
<div id="modal-funcoes" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalFuncoesLabel" aria-hidden="true" style="width: 620px; margin-left: -310px;">
    <form action="<?= base_url('index.php/usuarios/delegar_funcao') ?>" method="post" id="formDelegarFuncao">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 id="modalFuncoesLabel"><i class="bx bx-id-card" style="color: #0284c7;"></i> Delegar Funções de Acesso</h4>
        </div>
        <div class="modal-body" style="padding: 20px;">
            <div id="alerta-inegociavel" class="alert alert-info" style="display: none; align-items: center; gap: 8px;">
                <i class="bx bx-shield-quarter" style="font-size: 20px;"></i>
                <span><strong>Conta Mestre Inegociável:</strong> Este perfil possui autonomia total de Administrador e está protegido contra rebaixamento.</span>
            </div>

            <div class="control-group" style="margin-bottom: 15px;">
                <label for="select_usuario" style="font-weight: 600; margin-bottom: 4px; display: block;">Selecione o Usuário:</label>
                <select id="select_usuario" name="idUsuario" class="span12" style="width: 100%; height: 38px;">
                    <?php if (!empty($results)): ?>
                        <?php foreach ($results as $u): ?>
                            <option value="<?= $u->idUsuarios ?>" data-nome="<?= html_escape($u->nome) ?>" data-email="<?= html_escape($u->email ?? '') ?>" data-permissao="<?= $u->permissoes_id ?>">
                                <?= html_escape($u->nome) ?> (<?= html_escape($u->permissao) ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="control-group" style="margin-bottom: 15px;">
                <label for="select_funcao" style="font-weight: 600; margin-bottom: 4px; display: block;">Nova Função a Delegar:</label>
                <select id="select_funcao" name="permissoes_id" class="span12" style="width: 100%; height: 38px;">
                    <?php if (!empty($permissoes)): ?>
                        <?php foreach ($permissoes as $p): ?>
                            <option value="<?= $p->idPermissao ?>"><?= html_escape($p->nome) ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="1">Administrador</option>
                    <?php endif; ?>
                </select>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; font-size: 12px; color: #475569;">
                <p style="margin: 0 0 6px 0;"><strong>Regras de Autonomia:</strong></p>
                <ul style="margin: 0; padding-left: 18px;">
                    <li><strong>Administrador:</strong> Acesso irrestrito a configurações, finanças e cadastros.</li>
                    <li><strong>Desenvolvedor:</strong> Autonomia de desenvolvimento e sistema (Eduardo com peso pleno de Administrador).</li>
                    <li><strong>Suporte:</strong> Autonomia operacional em Ordens de Serviço, Clientes, Atendimentos e visualizações.</li>
                </ul>
            </div>
        </div>
        <div class="modal-footer" style="display:flex; justify-content: flex-end; gap: 10px;">
            <button type="button" class="button btn btn-default" data-dismiss="modal" aria-hidden="true">
                <span class="button__text2">Cancelar</span>
            </button>
            <button type="submit" id="btnSalvarFuncao" class="button btn btn-success">
                <span class="button__icon"><i class='bx bx-save'></i></span> <span class="button__text2">Salvar Função</span>
            </button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        function verificarInegociavel(email, nome) {
            email = (email || '').toLowerCase();
            nome = (nome || '').toLowerCase();
            var masterEmails = ['admin@zenydesk.com', 'certimixx@gmail.com'];
            if (masterEmails.indexOf(email) !== -1) {
                $('#alerta-inegociavel').show();
                $('#btnSalvarFuncao').prop('disabled', true);
                $('#select_funcao').prop('disabled', true);
            } else {
                $('#alerta-inegociavel').hide();
                $('#btnSalvarFuncao').prop('disabled', false);
                $('#select_funcao').prop('disabled', false);
            }
        }

        $('#select_usuario').on('change', function() {
            var selected = $(this).find(':selected');
            var email = selected.data('email');
            var nome = selected.data('nome');
            var perm = selected.data('permissao');
            $('#select_funcao').val(perm);
            verificarInegociavel(email, nome);
        });

        $(document).on('click', '.btn-delegar-funcao', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#select_usuario').val(id).trigger('change');
            $('#modal-funcoes').modal('show');
        });

        $('.btn-abrir-funcoes-geral').on('click', function() {
            $('#select_usuario').trigger('change');
        });
    });
</script>
