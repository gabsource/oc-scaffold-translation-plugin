<?php

return [
    'commands' => [
        'disclaimer' => 'You are using BnB.ScaffoldTranslation plugin overridden command. To switch back to default OctoberCMS command, disable or uninstall this plugin.',
    ],
    'settings' => [
        'label'              => 'Scaffold translations',
        'description'        => 'Set default scaffold options',
        'field_default_mode' => [
            'label' => 'Generate translatable files with scaffold commands',
            'comment' => 'Flick this to enable or disable generation of translatable files using scaffold commands
                            (create:plugin, create:command, create:component, etc). If disabled, you can still bypass
                             this setting using the --translated or -t options switch.',
        ]
    ],
    'defaults' => [
        'component'  => [
            'name'        => ':name Component',
            'description' => 'No description provided yet...',
        ],
        'controller' => [
            'return_to_list'          => 'Return to :name',
            'delete_confirm'          => 'Do you really want to delete this :name?',
            'delete_selected_success' => 'Successfully deleted the selected :name.',
            'delete_selected_empty'   => 'There are no selected :name to delete.',
            'delete_selected_confirm' => 'Delete the selected :name?',
            'menu_label'              => ':name',
            'new'                     => 'New :name',
            'label'                   => ':name',
            'manage'                  => 'Manage :name',
            'create'                  => 'Create :name',
            'update'                  => 'Edit :name',
            'preview'                 => 'Preview :name',
        ],
        'plugin'     => [
            'name'        => ':name',
            'description' => 'No description provided yet...',
        ],
    ],
];