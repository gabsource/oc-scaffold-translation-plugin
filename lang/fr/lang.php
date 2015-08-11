<?php

return [
    'settings' => [
        'label'              => 'Traduction des échafaudages',
        'description'        => 'Configurer le options par défaut',
        'field_default_mode' => 'Le mode de génération par défaut des échafaudages utilise des fichiers traductible'
    ],
    'defaults' => [
        'component'  => [
            'name'        => 'Composant :name',
            'description' => 'Aucune description pour le moment...',
        ],
        'controller' => [
            'return_to_list'          => 'Retour à la liste des :name',
            'delete_confirm'          => 'Confirmez-vous la suppression de ce :name?',
            'delete_selected_success' => 'Les :name sélectionnés ont été supprimés avec succès.',
            'delete_selected_empty'   => 'Il n‘y a aucun :name sélectionné à supprimer.',
            'delete_selected_confirm' => 'Supprimer les :name sélectionnés ?',
            'menu_label'              => ':name',
            'new'                     => 'Nouveau :name',
            'label'                   => ':name',
            'manage'                  => 'Gérer les :name',
            'create'                  => 'Créer un :name',
            'update'                  => 'Modifier un :name',
            'preview'                 => 'Consulter un :name',
        ],
        'plugin'     => [
            'name'        => ':name',
            'description' => 'Aucune description pour le moment...',
        ],
    ],
];