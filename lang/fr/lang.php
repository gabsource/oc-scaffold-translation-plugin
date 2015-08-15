<?php

return [
    'commands' => [
        'disclaimer' => 'Vous utilisez une commande surchargée par le plugin BnB.ScaffoldTranslation. Pour revenir à la commander par défaut d’OctoberCMS, désactivez ou désinstallez ce plugin.',
    ],
    'settings' => [
        'label'              => 'Traduction des échafaudages',
        'description'        => 'Configurer le options par défaut',
        'field_default_mode' => [
            'label'   => 'Génération de fichiers traductibles via les commandes d’échafaudage',
            'comment' => 'Cliquez sur l’interrupteur pour activer ou désactiver la génération de fichiers traductibles
                            via les commandes d’échafaudage (create:plugin, create:command, create:component, etc).
                            Si désactivé, vous pouvez tout de même forcer la génération de fichiers traductibles en
                            utilisant les options --translated ou -t des commandes.',
        ]
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
            'delete_selected_empty'   => 'Il n’y a aucun :name sélectionné à supprimer.',
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