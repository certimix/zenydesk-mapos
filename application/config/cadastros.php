<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
| -------------------------------------------------------------------------
| Cadastros auxiliares (menu "Cadastros", no padrão do SNDesk)
| -------------------------------------------------------------------------
| Cada entrada vira uma tela completa em /cadastros/<chave>: lista com busca
| e paginação, adicionar, editar, excluir e chave liga/desliga de "Ativo".
| Para criar um cadastro novo basta acrescentar uma entrada aqui e a tabela
| correspondente numa migration.
|
| Tipos de campo:
|   texto, textarea, email, telefone, numero, decimal, data, datahora,
|   booleano, cor, opcoes (lista fixa em 'opcoes'), relacao (select de outra
|   tabela: 'tabela', 'chave', 'exibir', opcional 'filtro' => [coluna => valor]).
|
| Chaves de campo:
|   rotulo, tipo, obrigatorio, lista (aparece na tabela), busca (entra na
|   pesquisa), max (tamanho máximo), padrao, ajuda, depois_de (campo de data
|   que este precisa ser igual ou posterior), largo (ocupa a linha inteira
|   no formulário).
*/

$usuario = ['tipo' => 'relacao', 'tabela' => 'usuarios', 'chave' => 'idUsuarios', 'exibir' => 'nome'];
$cliente = ['tipo' => 'relacao', 'tabela' => 'clientes', 'chave' => 'idClientes', 'exibir' => 'nomeCliente'];
$sla = ['tipo' => 'relacao', 'tabela' => 'cad_slas', 'chave' => 'id', 'exibir' => 'nome'];
$ativo = ['rotulo' => 'Ativo', 'tipo' => 'booleano', 'padrao' => 1, 'lista' => true];
$removerPortal = ['rotulo' => 'Remover do portal do cliente', 'tipo' => 'booleano', 'padrao' => 0];
$ufs = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];

$config['cadastros_entidades'] = [

    'afastamentos' => [
        'titulo' => 'Afastamentos',
        'singular' => 'Afastamento',
        'icone' => 'bx-calendar-x',
        'tabela' => 'cad_afastamentos',
        'ordem' => 'data_inicio DESC',
        'campos' => [
            'usuario_id' => $usuario + ['rotulo' => 'Técnico', 'obrigatorio' => true, 'lista' => true],
            'motivo' => ['rotulo' => 'Motivo', 'tipo' => 'texto', 'lista' => true, 'busca' => true, 'max' => 150],
            'data_inicio' => ['rotulo' => 'Início', 'tipo' => 'datahora', 'obrigatorio' => true, 'lista' => true],
            'data_fim' => ['rotulo' => 'Fim', 'tipo' => 'datahora', 'obrigatorio' => true, 'lista' => true, 'depois_de' => 'data_inicio'],
        ],
    ],

    'ativos' => [
        'titulo' => 'Ativos',
        'singular' => 'Ativo',
        'icone' => 'bx-devices',
        'tabela' => 'cad_ativos',
        'campos' => [
            'nome' => ['rotulo' => 'Nome do Ativo', 'tipo' => 'texto', 'obrigatorio' => true, 'lista' => true, 'busca' => true, 'max' => 150],
            'categoria_id' => ['rotulo' => 'Categoria', 'tipo' => 'relacao', 'tabela' => 'cad_categorias', 'chave' => 'id', 'exibir' => 'nome', 'lista' => true],
            'subcategoria_id' => ['rotulo' => 'Sub Categoria', 'tipo' => 'relacao', 'tabela' => 'cad_subcategorias', 'chave' => 'id', 'exibir' => 'nome'],
            'status' => ['rotulo' => 'Status', 'tipo' => 'opcoes', 'obrigatorio' => true, 'lista' => true, 'padrao' => 'Em uso',
                'opcoes' => ['Em uso', 'Em estoque', 'Em manutenção', 'Inativo', 'Descartado']],
            'cliente_id' => $cliente + ['rotulo' => 'Cliente', 'lista' => true],
            'contrato' => ['rotulo' => 'Contrato', 'tipo' => 'texto', 'lista' => true, 'busca' => true, 'max' => 100],
            'data_aquisicao' => ['rotulo' => 'Data de Aquisição', 'tipo' => 'data', 'lista' => true],
            'edificio_id' => ['rotulo' => 'Edifício', 'tipo' => 'relacao', 'tabela' => 'cad_edificios', 'chave' => 'id', 'exibir' => 'nome'],
            'numero_serie' => ['rotulo' => 'Nº de série', 'tipo' => 'texto', 'busca' => true, 'max' => 100],
            'patrimonio' => ['rotulo' => 'Patrimônio', 'tipo' => 'texto', 'busca' => true, 'max' => 100],
            'observacao' => ['rotulo' => 'Observação', 'tipo' => 'textarea', 'largo' => true],
            'ativo' => array_merge($ativo, ['lista' => false]),
        ],
    ],

    'campos' => [
        'titulo' => 'Campos Adicionais',
        'singular' => 'Campo Adicional',
        'icone' => 'bx-list-plus',
        'tabela' => 'cad_campos_adicionais',
        'ordem' => 'ordem ASC',
        'campos' => [
            'nome' => ['rotulo' => 'Descrição', 'tipo' => 'texto', 'obrigatorio' => true, 'lista' => true, 'busca' => true, 'max' => 100],
            'ordem' => ['rotulo' => 'Ordem', 'tipo' => 'numero', 'padrao' => 1, 'lista' => true],
            'tipo' => ['rotulo' => 'Tipo', 'tipo' => 'opcoes', 'obrigatorio' => true, 'lista' => true,
                'opcoes' => ['Texto', 'Valor', 'Data', 'Hora', 'Lista', 'Check Box', 'Caixa Texto', 'Horário']],
            'opcoes' => ['rotulo' => 'Opções da lista', 'tipo' => 'textarea', 'largo' => true, 'ajuda' => 'Só para o tipo "Lista": uma opção por linha.'],
            'usar_cliente' => ['rotulo' => 'Utilizar no cadastro de cliente', 'tipo' => 'booleano', 'padrao' => 0, 'lista' => true, 'coluna' => 'Cliente?'],
            'usar_chamado' => ['rotulo' => 'Utilizar na abertura de chamado', 'tipo' => 'booleano', 'padrao' => 1, 'lista' => true, 'coluna' => 'Chamado?'],
            'usar_portal' => ['rotulo' => 'Utilizar no portal do Cliente', 'tipo' => 'booleano', 'padrao' => 0, 'lista' => true, 'coluna' => 'Portal?'],
            'so_edicao' => ['rotulo' => 'Exibir apenas na edição do chamado', 'tipo' => 'booleano', 'padrao' => 0],
            'obrigatorio' => ['rotulo' => 'Requerido', 'tipo' => 'booleano', 'padrao' => 0],
            'ativo' => $ativo,
        ],
    ],

    'categorias' => [
        'titulo' => 'Categorias',
        'singular' => 'Categoria',
        'icone' => 'bx-category',
        'tabela' => 'cad_categorias',
        'campos' => [
            'nome' => ['rotulo' => 'Nome da categoria', 'tipo' => 'texto', 'obrigatorio' => true, 'lista' => true, 'busca' => true, 'max' => 120],
            'departamento_id' => ['rotulo' => 'Departamento', 'tipo' => 'relacao', 'tabela' => 'cad_departamentos', 'chave' => 'id', 'exibir' => 'nome', 'lista' => true],
            'valor' => ['rotulo' => 'Valor da categoria (R$)', 'tipo' => 'decimal', 'lista' => true],
            'sla_id' => $sla + ['rotulo' => 'SLA', 'lista' => true],
            'descricao' => ['rotulo' => 'Descrição', 'tipo' => 'textarea', 'busca' => true, 'largo' => true],
            'remover_portal' => $removerPortal,
            'ativo' => $ativo,
        ],
    ],

    'checklist' => [
        'titulo' => 'Check List',
        'singular' => 'Pergunta do Check List',
        'icone' => 'bx-list-check',
        'tabela' => 'cad_checklist_perguntas',
        'ordem' => 'ordem ASC',
        'campos' => [
            'descricao' => ['rotulo' => 'Descrição', 'tipo' => 'textarea', 'obrigatorio' => true, 'lista' => true, 'busca' => true, 'largo' => true],
            'ordem' => ['rotulo' => 'Ordem', 'tipo' => 'numero', 'padrao' => 1, 'lista' => true],
            'tipo' => ['rotulo' => 'Tipo', 'tipo' => 'opcoes', 'obrigatorio' => true, 'lista' => true,
                'opcoes' => ['Pergunta Curta', 'Paragrafo', 'Data', 'Hora', 'Escolha', 'Caixa de Seleção', 'Descrição', 'Separador', 'Anexo']],
            'opcoes' => ['rotulo' => 'Opções', 'tipo' => 'textarea', 'largo' => true, 'ajuda' => 'Só para o tipo "Escolha": uma opção por linha.'],
            'requerido' => ['rotulo' => 'Requerido', 'tipo' => 'booleano', 'padrao' => 0],
            'ativo' => $ativo,
        ],
    ],

    'departamentos' => [
        'titulo' => 'Departamentos',
        'singular' => 'Departamento',
        'icone' => 'bx-sitemap',
        'tabela' => 'cad_departamentos',
        'campos' => [
            'nome' => ['rotulo' => 'Nome do Departamento', 'tipo' => 'texto', 'obrigatorio' => true, 'lista' => true, 'busca' => true, 'max' => 120, 'coluna' => 'Descrição'],
            'valor' => ['rotulo' => 'Valor departamento (R$)', 'tipo' => 'decimal'],
            'sla_id' => $sla + ['rotulo' => 'SLA'],
            'responsavel_id' => $usuario + ['rotulo' => 'Técnico responsável'],
            'email' => ['rotulo' => 'E-mail', 'tipo' => 'email', 'busca' => true, 'max' => 150],
            'telefone' => ['rotulo' => 'Telefone', 'tipo' => 'telefone', 'max' => 30],
            'remover_portal' => $removerPortal,
            'ativo' => $ativo,
        ],
    ],

    'edificios' => [
        'titulo' => 'Edifícios',
        'singular' => 'Edifício',
        'icone' => 'bx-buildings',
        'tabela' => 'cad_edificios',
        'campos' => [
            'codigo' => ['rotulo' => 'Código do Edifício', 'tipo' => 'texto', 'lista' => true, 'busca' => true, 'max' => 50, 'coluna' => 'Código'],
            'nome' => ['rotulo' => 'Edifício', 'tipo' => 'texto', 'obrigatorio' => true, 'lista' => true, 'busca' => true, 'max' => 150],
            'cliente_id' => $cliente + ['rotulo' => 'Cliente'],
            'vigencia_inicio' => ['rotulo' => 'Vigência Início', 'tipo' => 'data'],
            'vigencia_fim' => ['rotulo' => 'Vigência Fim', 'tipo' => 'data', 'depois_de' => 'vigencia_inicio'],
            'cep' => ['rotulo' => 'CEP', 'tipo' => 'texto', 'max' => 9],
            'endereco' => ['rotulo' => 'Rua/Avenida', 'tipo' => 'texto', 'obrigatorio' => true, 'lista' => true, 'busca' => true, 'max' => 255, 'coluna' => 'Endereço'],
            'numero' => ['rotulo' => 'Nº', 'tipo' => 'texto', 'obrigatorio' => true, 'max' => 20],
            'bairro' => ['rotulo' => 'Bairro', 'tipo' => 'texto', 'obrigatorio' => true, 'max' => 100],
            'complemento' => ['rotulo' => 'Complemento', 'tipo' => 'texto', 'max' => 100],
            'cidade' => ['rotulo' => 'Cidade', 'tipo' => 'texto', 'obrigatorio' => true, 'busca' => true, 'max' => 100],
            'uf' => ['rotulo' => 'UF', 'tipo' => 'opcoes', 'obrigatorio' => true, 'opcoes' => $ufs],
            'tecnico_id' => $usuario + ['rotulo' => 'Técnico responsável'],
            'equipe_id' => ['rotulo' => 'Equipe', 'tipo' => 'relacao', 'tabela' => 'cad_equipes', 'chave' => 'id', 'exibir' => 'nome'],
            'observacao' => ['rotulo' => 'Observação', 'tipo' => 'textarea', 'largo' => true],
            'ativo' => array_merge($ativo, ['lista' => false]),
        ],
    ],

    'equipes' => [
        'titulo' => 'Equipes',
        'singular' => 'Equipe',
        'icone' => 'bx-group',
        'tabela' => 'cad_equipes',
        'campos' => [
            'nome' => ['rotulo' => 'Nome', 'tipo' => 'texto', 'obrigatorio' => true, 'lista' => true, 'busca' => true, 'max' => 120, 'coluna' => 'Equipe'],
            'nivel' => ['rotulo' => 'Nível padrão', 'tipo' => 'numero', 'padrao' => 1, 'lista' => true, 'coluna' => 'Nível'],
            'nivel_acesso' => ['rotulo' => 'Nível de acesso padrão', 'tipo' => 'numero', 'padrao' => 1, 'lista' => true, 'coluna' => 'N. Acesso'],
            'departamento_id' => ['rotulo' => 'Departamento', 'tipo' => 'relacao', 'tabela' => 'cad_departamentos', 'chave' => 'id', 'exibir' => 'nome'],
            'lider_id' => $usuario + ['rotulo' => 'Líder'],
            'descricao' => ['rotulo' => 'Descrição', 'tipo' => 'textarea', 'largo' => true],
            'ativo' => $ativo,
        ],
    ],

    'estagios' => [
        'titulo' => 'Estágios',
        'singular' => 'Estágio',
        'icone' => 'bx-git-commit',
        'tabela' => 'cad_estagios',
        'ordem' => 'fluxo_id ASC, ordem ASC',
        'campos' => [
            'nome' => ['rotulo' => 'Nome', 'tipo' => 'texto', 'obrigatorio' => true, 'lista' => true, 'busca' => true, 'max' => 120],
            'fluxo_id' => ['rotulo' => 'Fluxo', 'tipo' => 'relacao', 'tabela' => 'cad_fluxos', 'chave' => 'id', 'exibir' => 'nome', 'obrigatorio' => true, 'lista' => true],
            'ordem' => ['rotulo' => 'Ordem', 'tipo' => 'numero', 'padrao' => 1, 'lista' => true],
            'cor' => ['rotulo' => 'Cor', 'tipo' => 'cor', 'padrao' => '#3c94e6', 'lista' => true],
            'descricao' => ['rotulo' => 'Descrição', 'tipo' => 'textarea', 'largo' => true],
            'ativo' => $ativo,
        ],
    ],

    'eventos' => [
        'titulo' => 'Eventos',
        'singular' => 'Evento',
        'icone' => 'bx-calendar-event',
        'tabela' => 'cad_eventos',
        'ordem' => 'data_inicio DESC',
        'campos' => [
            'titulo' => ['rotulo' => 'Nome do Evento', 'tipo' => 'texto', 'obrigatorio' => true, 'lista' => true, 'busca' => true, 'max' => 150, 'coluna' => 'Nome'],
            'tipo' => ['rotulo' => 'Tipo', 'tipo' => 'opcoes', 'lista' => true,
                'opcoes' => ['Visita técnica', 'Reunião', 'Treinamento', 'Manutenção preventiva', 'Outro']],
            'data_inicio' => ['rotulo' => 'Início', 'tipo' => 'datahora', 'obrigatorio' => true, 'lista' => true],
            'data_fim' => ['rotulo' => 'Fim', 'tipo' => 'datahora', 'depois_de' => 'data_inicio'],
            'usuario_id' => $usuario + ['rotulo' => 'Técnico', 'lista' => true],
            'cliente_id' => $cliente + ['rotulo' => 'Cliente'],
            'cor' => ['rotulo' => 'Cor na agenda', 'tipo' => 'cor', 'padrao' => '#3c94e6'],
            'descricao' => ['rotulo' => 'Descrição', 'tipo' => 'textarea', 'busca' => true, 'largo' => true],
        ],
    ],

    'feriados' => [
        'titulo' => 'Feriados',
        'singular' => 'Feriado',
        'icone' => 'bx-party',
        'tabela' => 'cad_feriados',
        'ordem' => 'data ASC',
        'campos' => [
            'nome' => ['rotulo' => 'Nome', 'tipo' => 'texto', 'obrigatorio' => true, 'lista' => true, 'busca' => true, 'max' => 120, 'coluna' => 'Descrição'],
            'data' => ['rotulo' => 'Data', 'tipo' => 'data', 'obrigatorio' => true, 'lista' => true],
            'recorrente' => ['rotulo' => 'Recorrente', 'tipo' => 'booleano', 'padrao' => 1, 'lista' => true],
            'ativo' => array_merge($ativo, ['lista' => false]),
        ],
    ],

    'fluxos' => [
        'titulo' => 'Fluxos',
        'singular' => 'Fluxo',
        'icone' => 'bx-git-branch',
        'tabela' => 'cad_fluxos',
        'campos' => [
            'nome' => ['rotulo' => 'Nome', 'tipo' => 'texto', 'obrigatorio' => true, 'lista' => true, 'busca' => true, 'max' => 120],
            'descricao' => ['rotulo' => 'Descrição', 'tipo' => 'textarea', 'lista' => true, 'largo' => true],
            'ativo' => $ativo,
        ],
    ],

    'mensagens' => [
        'titulo' => 'Mensagens - Pré Definidas',
        'singular' => 'Mensagem Pré-definida',
        'icone' => 'bx-message-square-detail',
        'tabela' => 'cad_mensagens_predefinidas',
        'campos' => [
            'titulo' => ['rotulo' => 'Título', 'tipo' => 'texto', 'obrigatorio' => true, 'lista' => true, 'busca' => true, 'max' => 150],
            'mensagem' => ['rotulo' => 'Descrição', 'tipo' => 'textarea', 'obrigatorio' => true, 'lista' => true, 'busca' => true, 'largo' => true],
            'ativo' => $ativo,
        ],
    ],

    'slas' => [
        'titulo' => 'SLAs (Prazos e tempo de resposta)',
        'singular' => 'SLA',
        'icone' => 'bx-timer',
        'tabela' => 'cad_slas',
        'ordem' => 'prioridade ASC',
        'campos' => [
            'nome' => ['rotulo' => 'Descrição', 'tipo' => 'texto', 'obrigatorio' => true, 'lista' => true, 'busca' => true, 'max' => 120],
            'tempo_solucao' => ['rotulo' => 'Tempo de Resolução (horas)', 'tipo' => 'numero', 'obrigatorio' => true, 'lista' => true, 'coluna' => 'Horas'],
            'prioridade' => ['rotulo' => 'Prioridade', 'tipo' => 'opcoes', 'obrigatorio' => true, 'lista' => true, 'opcoes' => ['1', '2', '3', '4', '5'],
                'ajuda' => '1 = menor prioridade, 5 = maior.'],
            'cor' => ['rotulo' => 'Cor', 'tipo' => 'cor', 'obrigatorio' => true, 'padrao' => '#3c94e6', 'lista' => true],
            'tempo_resposta' => ['rotulo' => 'Tempo de primeira resposta (horas)', 'tipo' => 'numero'],
            'checkin_checkout' => ['rotulo' => 'SLA de checkin/checkout', 'tipo' => 'booleano', 'padrao' => 0],
            'horario_comercial' => ['rotulo' => 'Contar só horário comercial (sem intervalos desligado)', 'tipo' => 'booleano', 'padrao' => 1],
            'descricao' => ['rotulo' => 'Observação', 'tipo' => 'textarea', 'largo' => true],
            'ativo' => $ativo,
        ],
    ],

    'usuariosportal' => [
        'titulo' => 'Usuários do Portal',
        'singular' => 'Usuário do Portal',
        'icone' => 'bx-id-card',
        'tabela' => 'cad_usuarios_portal',
        'campos' => [
            'email' => ['rotulo' => 'E-mail (login)', 'tipo' => 'email', 'obrigatorio' => true, 'unico' => true, 'lista' => true, 'busca' => true, 'max' => 150, 'coluna' => 'Email'],
            'nome' => ['rotulo' => 'Nome', 'tipo' => 'texto', 'obrigatorio' => true, 'lista' => true, 'busca' => true, 'max' => 120],
            'telefone' => ['rotulo' => 'Telefone', 'tipo' => 'telefone', 'lista' => true, 'max' => 30],
            'cliente_id' => $cliente + ['rotulo' => 'Cliente (empresa)', 'obrigatorio' => true, 'lista' => true,
                'ajuda' => 'O usuário vê e abre chamados em nome deste cliente na Área do Cliente.'],
            'senha' => ['rotulo' => 'Senha de acesso', 'tipo' => 'senha', 'obrigatorio' => true],
            'sla_id' => $sla + ['rotulo' => 'SLA dos chamados deste usuário'],
            'ativo' => $ativo,
        ],
    ],

    'subcategorias' => [
        'titulo' => 'Sub Categorias de Chamados',
        'singular' => 'Sub Categoria',
        'icone' => 'bx-subdirectory-right',
        'tabela' => 'cad_subcategorias',
        'campos' => [
            'nome' => ['rotulo' => 'Nome da sub categoria', 'tipo' => 'texto', 'obrigatorio' => true, 'lista' => true, 'busca' => true, 'max' => 120, 'coluna' => 'Descrição'],
            'categoria_id' => ['rotulo' => 'Categoria', 'tipo' => 'relacao', 'tabela' => 'cad_categorias', 'chave' => 'id', 'exibir' => 'nome', 'obrigatorio' => true, 'lista' => true],
            'valor' => ['rotulo' => 'Valor (R$)', 'tipo' => 'decimal'],
            'sla_id' => $sla + ['rotulo' => 'SLA'],
            'remover_portal' => $removerPortal,
            'ativo' => $ativo,
        ],
    ],
];
