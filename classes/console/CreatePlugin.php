<?php namespace BnB\ScaffoldTranslation\Classes\Console;

use BnB\ScaffoldTranslation\Classes\Templates\Plugin;
use BnB\ScaffoldTranslation\Classes\TranslationScanner;
use Lang;
use Symfony\Component\Console\Input\InputOption;

class CreatePlugin extends \October\Rain\Scaffold\Console\CreatePlugin
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

        if (count($parts) != 2) {
            $this->error('Invalid plugin name, either too many dots or not enough.');
            $this->error('Example name: AuthorName.PluginName');

            return;
        }

        $pluginName = array_pop($parts);
        $authorName = array_pop($parts);

        $destinationPath = base_path() . '/plugins';
        $vars            = [
            'name'   => $pluginName,
            'author' => $authorName,
        ];

        Plugin::make($destinationPath, $vars, $this->option('force'), $this->option('translated'));

        $vars['plugin'] = $vars['name'];
        $langPrefix     = strtolower($authorName) . '.' . strtolower($pluginName) . '::lang.';

        $defaultLocale = Lang::getLocale();
        $locales       = TranslationScanner::loadPluginLocales();

        foreach ($locales as $locale) {
            Lang::setLocale($locale);
            $vars[$locale] = [
                $langPrefix . 'plugin.name'        => trans('bnb.scaffoldtranslation::lang.defaults.plugin.name',
                    ['name' => $pluginName]),
                $langPrefix . 'plugin.description' => trans('bnb.scaffoldtranslation::lang.defaults.plugin.description'),
            ];
        }

        Lang::setLocale($defaultLocale);

        TranslationScanner::instance()->with($vars)->scanFile($destinationPath . '/' . strtolower($authorName) . '/' . strtolower($pluginName) . '/Plugin.php');

        $this->info(sprintf('Successfully generated Plugin named "%s"', $pluginCode));
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