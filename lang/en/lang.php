<?php

return [
    'settings' => [
        'label'              => 'Scaffold translations',
        'description'        => 'Set default scaffold options',
        'field_default_mode' => 'Default scaffold mode generates translatable files'
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