# Scaffold Translation Plugin

> This is an [OctoberCMS] plugin

## Purpose

This plugin overrides default scaffold commands to generate translation aware source files.

Those commands are overrided :
- plugin
- controllers
- component

## New command

    php artisan plugin:translate Acme.Plugin

This new command will scan `classes`, `components`, `controllers`, `widgets`, `formwidgets` folders and `Plugin.php` files.
It will detect missing translation key and add them to the `lang/xx/lang.php` files.

[OctoberCMS]: https://octobercms.com
