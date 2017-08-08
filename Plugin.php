<?php namespace BnB\ScaffoldTranslation;

use App;
use System\Classes\PluginBase;

/**
 * ScaffoldTranslation Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'ScaffoldTranslation',
            'description' => 'Overrides default OctoberCMS scaffold commands to generate translation aware source files ',
            'author'      => 'B&B Web Expertise',
            'icon'        => 'icon-leaf'
        ];
    }


    public function boot()
    {
        App::register('\BnB\ScaffoldTranslation\Classes\ScaffoldServiceProvider');
    }
}
