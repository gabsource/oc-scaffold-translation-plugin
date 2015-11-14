<?php

return [
    'commands' => [
        'disclaimer' => 'Você está usando o plugin BnB.ScaffoldTranslation subistituindo alguns comandos de scaffold. Para voltar para os comandos padrão do OctoberCMS, desative ou desinstale este plugin.',
    ],
    'settings' => [
        'label'              => 'Tradutor de Scaffolds',
        'description'        => 'Define padrões para opções de scaffold',
        'field_default_mode' => [
            'label' => 'Gera arquivos traduzíveis através de comandos de scaffold',
            'comment' => 'Marque para ativar ou desativar a geração automática de arquivos de scaffold traduzíveis
                            (create:plugin, create:command, create:component, etc). Se desabilitado, poderá ainda utilizar
                             arquivos traduzíveis através das opções --translated ou ainda -t.',
        ]
    ],
    'defaults' => [
        'component'  => [
            'name'        => ':name Component',
            'description' => 'Nenhuma descrição informada ainda...',
        ],
        'controller' => [
            'return_to_list'          => 'Retornar para :name',
            'delete_confirm'          => 'Deseja mesmo deletar este :name?',
            'delete_selected_success' => ':name selecionados deletados com sucesso.',
            'delete_selected_empty'   => 'Não há :name selecionados para deletar.',
            'delete_selected_confirm' => 'Deseja deletar os :name selecionados?',
            'menu_label'              => ':name',
            'new'                     => 'Inserir :name',
            'label'                   => ':name',
            'manage'                  => 'Gerenciar :name',
            'create'                  => 'Criar :name',
            'update'                  => 'Editar :name',
            'preview'                 => 'Visualizar :name',
        ],
        'plugin'     => [
            'name'        => ':name',
            'description' => 'Nenhuma descrição informada ainda...',
        ],
    ],
];
