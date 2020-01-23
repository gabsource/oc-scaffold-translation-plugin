<?php

return [
    'commands' => [
        'disclaimer' => 'Używasz nakładki do generowania tłumaczeń o nazwie BnB Scaffold translation by przestać jej używać odinstaluj wtyczkę.',
        'success' => 'Pomyslnie wygenerowano tłumaczenie dla :type o nazwie :name',
    ],
    'settings' => [
        'label'              => 'Scaffold translations',
        'description'        => 'Ustaw domyślne opcje',
        'field_default_mode' => [
            'label' => 'Twórz przetłumaczalne pliki z komendą szkieletu (scaffold)',
            'comment' => 'Przełącz by włączyć lub wyłączyć tworzenie tłumaczeń używając koment scaffoldowania
                            (create:plugin, create:command, create:component, etc). Jeśli wyłączone, możesz obejść te ustawienie dodając opcję --translated lub -t do wywołania.',
        ]
    ],
    'defaults' => [
        'component'  => [
            'name'        => 'Komponent :name',
            'description' => 'Nie dodano opisu',
        ],
        'controller' => [
            'return_to_list'          => 'Powrót do listy :name',
            'delete_confirm'          => 'Na pewno usunąć zaznaczone :name?',
            'delete_selected_success' => 'Pomyślnie usunięto zaznaczone :name.',
            'delete_selected_empty'   => 'Nie wybrano :name do usunięcia.',
            'delete_selected_confirm' => 'Usunąć zaznaczoną :name?',
            'menu_label'              => ':name',
            'new'                     => 'Nowy :name',
            'label'                   => ':name',
            'manage'                  => 'Zarządzaj :name',
            'create'                  => 'Utwórz :name',
            'update'                  => 'Edytuj :name',
            'preview'                 => 'podgląd :name',
        ],
        'plugin'     => [
            'name'        => ':name',
            'description' => 'Opis wtyczki',
            'permissions' => [
                'some_permission' => 'Przykład prawa dostępu',
            ],
        ],
    ],
];
