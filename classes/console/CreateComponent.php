<?php namespace BnB\ScaffoldTranslation\Classes\Console;

use BnB\ScaffoldTranslation\Classes\Templates\Component;
use BnB\ScaffoldTranslation\Classes\TranslationScanner;
use Lang;
use Symfony\Component\Console\Input\InputOption;

class CreateComponent extends \October\Rain\Scaffold\Console\CreateComponent
{

    /**
     * Execute the console command.
     */
    public function fire()
    {
        $this->comment(trans('bnb.scaffoldtranslation::lang.commands.disclaimer'));

        /*
         * Extract the author and name from the plugin code
         */
        $pluginCode = $this->argument('pluginCode');

        $parts      = explode('.', $pluginCode);
        $pluginName = array_pop($parts);
        $authorName = array_pop($parts);

        $destinationPath = base_path() . '/plugins/' . strtolower($authorName) . '/' . strtolower($pluginName);
        $componentName   = $this->argument('componentName');

        $vars = [
            'name'   => $componentName,
            'author' => $authorName,
            'plugin' => $pluginName
        ];

        Component::make($destinationPath, $vars, $this->option('force'), $this->option('translated'));

        $langPrefix = strtolower($authorName) . '.' . strtolower($pluginName) . '::lang.components.' . strtolower($componentName) . '.';

        $defaultLocale = Lang::getLocale();
        $locales       = TranslationScanner::loadPluginLocales();

        foreach ($locales as $locale) {
            Lang::setLocale($locale);
            $vars[$locale] = [
                $langPrefix . 'name'        => trans('bnb.scaffoldtranslation::lang.defaults.component.name',
                    ['name' => $componentName]),
                $langPrefix . 'description' => trans('bnb.scaffoldtranslation::lang.defaults.component.description'),
            ];
        }

        Lang::setLocale($defaultLocale);

        TranslationScanner::instance()->with($vars)->scan($destinationPath . '/components');

        $this->info(sprintf('Successfully generated Component for "%s"', $componentName));
    }


    /**
     * Get the console command options.
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Overwrite existing files with generated ones.'],
            ['translated', 't', InputOption::VALUE_NONE, 'Force generation of translation aware files.']
        ];
    }

}