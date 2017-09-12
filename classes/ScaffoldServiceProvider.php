<?php namespace BnB\ScaffoldTranslation\Classes;

use BnB\ScaffoldTranslation\Classes\Console\CreateComponent;
use BnB\ScaffoldTranslation\Classes\Console\CreateController;
use BnB\ScaffoldTranslation\Classes\Console\CreatePlugin;
use BnB\ScaffoldTranslation\Classes\Console\CreateWidget;
use BnB\ScaffoldTranslation\Classes\Console\PluginTranslate;
use Illuminate\Support\ServiceProvider;

class ScaffoldServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->app->singleton('command.create.plugin.translated', function () {
            return new CreatePlugin;
        });

        $this->app->singleton('command.create.controller.translated', function () {
            return new CreateController;
        });

        $this->app->singleton('command.create.component.translated', function () {
            return new CreateComponent;
        });

        $this->app->singleton('command.create.widget.translated', function () {
            return new CreateWidget;
        });

        $this->app->singleton('command.plugin.translate.translated', function () {
            return new PluginTranslate;
        });

        $this->commands('command.create.plugin.translated');
        $this->commands('command.create.controller.translated');
        $this->commands('command.create.component.translated');
        $this->commands('command.create.widget.translated');
        $this->commands('command.plugin.translate.translated');
    }


    /**
     * Get the services provided by the provider.
     * @return array
     */
    public function provides()
    {
        return [
            'command.create.plugin',
            'command.create.controller',
            'command.create.component',
            'command.create.widget',
            'command.plugin.translate',
        ];
    }
}