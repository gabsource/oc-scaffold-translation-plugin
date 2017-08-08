# Scaffold Translation Plugin

## Purpose

This [OctoberCMS] plugin adds scaffold commands to generate translation aware source files.

Following `php artisan` commands are enhanced :
- `create:plugin:translated`
- `create:controllers:translated`
- `create:component:translated`

> Note: running those commands will rewrite and reformat existing plugin language files (ie. the returned PHP array).

## Usage

    php artisan create:plugin:translated Acme.Demo
    php artisan create:controller:translated Acme.Demo Turtles
    php artisan create:component:translated Acme.Demo TurtleList
    
Those commands will create the plugin, with a controller and a component. The new __Acme.Demo__ plugin `lang/en/lang.php` 
will look like this :
 
```php
<?php

return [
    'plugin' => [
        'name' => 'Demo',
        'description' => 'No description provided yet...',
    ],
    'turtle' => [
        'new' => 'New Turtle',
        'label' => 'Turtle',
        'create_title' => 'Create Turtle',
        'update_title' => 'Edit Turtle',
        'preview_title' => 'Preview Turtle',
        'list_title' => 'Manage Turtles',
    ],
    'turtles' => [
        'delete_selected_confirm' => 'Delete the selected turtles?',
        'menu_label' => 'Turtles',
        'return_to_list' => 'Return to Turtles',
        'delete_confirm' => 'Do you really want to delete this turtle?',
        'delete_selected_success' => 'Successfully deleted the selected turtles.',
        'delete_selected_empty' => 'There are no selected :name to delete.',
    ],
    'components' => [
        'turtlelist' => [
            'name' => 'TurtleList Component',
            'description' => 'No description provided yet...',
        ],
    ],
];
```

These keys are used in controller, component and plugin classes, views or YAML files.

Language files for `en`, `config('app.locale')` and `config('app.fallback_locale')` are generated.

The default values can be translated in other languages using the `lang/xx/lang.php` files of this plugin.
If no default value is found, the key is used.

## New commands available

### Generate a widget stub

    php artisan create:widget:translated Acme.Plugin FooWidget
    
Similar to `create:formwidget`, no translation here.

### Find missing translation keys

    php artisan plugin:translate Acme.Plugin

This new command will scan `classes`, `components`, `models`, `controllers`, `widgets`, `formwidgets` folders and 
`Plugin.php` files.
It will detect missing translation key and add them to the `lang/xx/lang.php` files.

_Warning:_ running those commands will rewrite and reformat existing language file returned array.

## Manual installation

To manually install the plugin, get the sources archive from Github, uncompress the files in 
`plugins/bnb/scaffoldtranslation` folder and run this command at the root of OctoberCMS installation :

    php artisan plugin:refresh BnB.ScaffoldTranslation


[OctoberCMS]: https://octobercms.com
