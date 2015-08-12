<?php namespace BnB\ScaffoldTranslation\Classes\Console;

use BnB\ScaffoldTranslation\Classes\Templates\Widget;
use BnB\ScaffoldTranslation\Classes\TranslationScanner;
use Illuminate\Console\Command;
use Lang;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class CreateWidget extends Command
{

    /**
     * The console command name.
     */
    protected $name = 'create:widget';

    /**
     * The console command description.
     */
    protected $description = 'Creates a new widget.';


    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     */
    public function fire()
    {
        /*
         * Extract the author and name from the plugin code
         */
        $pluginCode = $this->argument('pluginCode');
        $parts      = explode('.', $pluginCode);
        $pluginName = array_pop($parts);
        $authorName = array_pop($parts);

        $destinationPath = plugins_path() . '/' . strtolower($authorName) . '/' . strtolower($pluginName);
        $widgetName      = $this->argument('widgetName');
        $vars            = [
            'name'   => $widgetName,
            'author' => $authorName,
            'plugin' => $pluginName
        ];

        Widget::make($destinationPath, $vars, $this->option('force'));

        $vars['plugin'] = $vars['name'];
        $langPrefix     = strtolower($authorName) . '.' . strtolower($pluginName) . '::lang.';

        $defaultLocale = Lang::getLocale();
        $locales       = TranslationScanner::loadPluginLocales();

        foreach ($locales as $locale) {
            Lang::setLocale($locale);
            $vars[$locale] = [
                $langPrefix . 'plugin.name'        => trans('bnb.scaffoldtranslation::lang.defaults.widget.name',
                    ['name' => $pluginName]),
                $langPrefix . 'plugin.description' => trans('bnb.scaffoldtranslation::lang.defaults.widget.description'),
            ];
        }

        Lang::setLocale($defaultLocale);

        TranslationScanner::instance()->with($vars)->scan($destinationPath . '/widgets');

        $this->info(sprintf('Successfully generated Form Widget named "%s"', $widgetName));
    }


    /**
     * Get the console command arguments.
     */
    protected function getArguments()
    {
        return [
            ['pluginCode', InputArgument::REQUIRED, 'The name of the plugin. Eg: RainLab.Blog'],
            ['widgetName', InputArgument::REQUIRED, 'The name of the widget. Eg: PostList'],
        ];
    }


    /**
     * Get the console command options.
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Overwrite existing files with generated ones.'],
            ['translated', 't', InputOption::VALUE_NONE, 'Generate translation ready files.'],
        ];
    }

}