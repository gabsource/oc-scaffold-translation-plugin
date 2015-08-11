# Scaffold Translation Plugin

> This is an [OctoberCMS] plugin

To manually install the plugin, files must be placed in `plugins/bnb/scaffoldtranslation` folder and this command must 
be run:

    php artisan plugin:refresh BnB.ScaffoldTranslation

## Purpose

This plugin overrides default scaffold commands to generate translation aware source files.

Following __php artisan__ commands are enhanced :
- `create:plugin`
- `create:controllers`
- `create:component`

## Usage

    artisan create:plugin Acme.Demo
    artisan create:controller Acme.Demo Turtles
    artisan create:controller Acme.Demo Turtles
    
Will generate the plugin, with a controller and a component. The `lang/en/lang.php` will look like this :
 
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
        'delete_selected_confirm' => 'Successfully deleted the selected turtles.',
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

Those keys are used in the controller, component and plugin classes, views or YAML files.

Language files for `en`, `config('app.locale')` and `config('app.fallback_locale')` are generated.

The default values can be translated in other languages using the `lang/xx/lang.php` files of this plugin.

## Settings



## New command

    php artisan plugin:translate Acme.Plugin

This new command will scan `classes`, `components`, `controllers`, `widgets`, `formwidgets` folders and `Plugin.php` files.
It will detect missing translation key and add them to the `lang/xx/lang.php` files.

[OctoberCMS]: https://octobercms.com
