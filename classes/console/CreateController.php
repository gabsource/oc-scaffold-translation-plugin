<?php namespace BnB\ScaffoldTranslation\Classes\Console;

use BnB\ScaffoldTranslation\Classes\Templates\Controller;
use BnB\ScaffoldTranslation\Classes\TranslationScanner;
use Lang;
use October\Rain\Support\Facades\Str;
use Symfony\Component\Console\Input\InputOption;

class CreateController extends \October\Rain\Scaffold\Console\CreateController
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
        $controllerName  = $this->argument('controllerName');

        /*
         * Determine the model name to use,
         * either supplied or singular from the controller name.
         */
        $modelName = $this->option('model');
        if ( ! $modelName) {
            $modelName = Str::singular($controllerName);
        }

        $vars = [
            'name'   => $controllerName,
            'model'  => $modelName,
            'author' => $authorName,
            'plugin' => $pluginName
        ];

        Controller::make($destinationPath, $vars, $this->option('force'), $this->option('translated'));

        $langPrefix       = strtolower($authorName) . '.' . strtolower($pluginName) . '::lang.';
        $titleSingular    = ucwords(str_replace('_', ' ', Str::snake(str_singular($controllerName))));
        $titlePlural      = ucwords(str_replace('_', ' ', Str::snake(str_plural($controllerName))));
        $lowerTitlePlural = strtolower(str_replace('_', ' ', Str::snake(str_plural($controllerName))));
        $plural           = strtolower(str_plural($controllerName));
        $singular         = strtolower(str_singular($controllerName));
        $vars['en']       = [
            $langPrefix . $plural . '.return_to_list'          => 'Return to ' . $titlePlural,
            $langPrefix . $plural . '.delete_confirm'          => 'Do you really want to delete this ' . $titleSingular . '?',
            $langPrefix . $plural . '.delete_selected_success' => 'Successfully deleted the selected ' . $titlePlural . '.',
            $langPrefix . $plural . '.delete_selected_empty'   => 'There are no selected ' . $lowerTitlePlural . ' to delete.',
            $langPrefix . $plural . '.delete_selected_confirm' => 'Delete the selected ' . $titlePlural . '?',
            $langPrefix . $plural . '.menu_label'              => $titlePlural,
            $langPrefix . $singular . '.new'                   => 'New ' . $titleSingular,
            $langPrefix . $singular . '.label'                 => $titleSingular,
            $langPrefix . $singular . '.list_title'            => 'Manage ' . $titlePlural,
            $langPrefix . $singular . '.create_title'          => 'Create ' . $titleSingular,
            $langPrefix . $singular . '.update_title'          => 'Edit ' . $titleSingular,
            $langPrefix . $singular . '.preview_title'         => 'Preview ' . $titleSingular,
        ];

        $langPrefix       = strtolower($authorName) . '.' . strtolower($pluginName) . '::lang.';
        $titleSingular    = ucwords(str_replace('_', ' ', Str::snake(str_singular($controllerName))));
        $titlePlural      = ucwords(str_replace('_', ' ', Str::snake(str_plural($controllerName))));
        $lowerTitlePlural = strtolower(str_replace('_', ' ', Str::snake(str_plural($controllerName))));
        $plural           = strtolower(str_plural($controllerName));
        $singular         = strtolower(str_singular($controllerName));

        $defaultLocale = Lang::getLocale();
        $locales       = TranslationScanner::loadPluginLocales();

        foreach ($locales as $locale) {
            Lang::setLocale($locale);
            $vars[$locale] = [
                $langPrefix . $plural . '.return_to_list'          => trans('bnb.scaffoldtranslation::lang.defaults.controller.return_to_list',
                    ['name' => $titlePlural]),
                $langPrefix . $plural . '.delete_confirm'          => trans('bnb.scaffoldtranslation::lang.defaults.controller.delete_confirm',
                    ['name' => $titleSingular]),
                $langPrefix . $plural . '.delete_selected_success' => trans('bnb.scaffoldtranslation::lang.defaults.controller.delete_selected_success',
                    ['name' => $titlePlural]),
                $langPrefix . $plural . '.delete_selected_empty'   => trans('bnb.scaffoldtranslation::lang.defaults.controller.delete_selected_empty',
                    ['name' => $titlePlural]),
                $langPrefix . $plural . '.delete_selected_confirm' => trans('bnb.scaffoldtranslation::lang.defaults.controller.delete_selected_confirm',
                    ['name' => $titlePlural]),
                $langPrefix . $plural . '.menu_label'              => trans('bnb.scaffoldtranslation::lang.defaults.controller.menu_label',
                    ['name' => $titlePlural]),
                $langPrefix . $singular . '.new'                   => trans('bnb.scaffoldtranslation::lang.defaults.controller.new',
                    ['name' => $titleSingular]),
                $langPrefix . $singular . '.label'                 => trans('bnb.scaffoldtranslation::lang.defaults.controller.label',
                    ['name' => $titleSingular]),
                $langPrefix . $singular . '.list_title'            => trans('bnb.scaffoldtranslation::lang.defaults.controller.manage',
                    ['name' => $titlePlural]),
                $langPrefix . $singular . '.create_title'          => trans('bnb.scaffoldtranslation::lang.defaults.controller.create',
                    ['name' => $titleSingular]),
                $langPrefix . $singular . '.update_title'          => trans('bnb.scaffoldtranslation::lang.defaults.controller.update',
                    ['name' => $titleSingular]),
                $langPrefix . $singular . '.preview_title'         => trans('bnb.scaffoldtranslation::lang.defaults.controller.preview',
                    ['name' => $titleSingular]),
            ];
        }

        Lang::setLocale($defaultLocale);

        TranslationScanner::instance()->with($vars)->scan($destinationPath . '/controllers');

        $this->info(sprintf('Successfully generated Controller and views for "%s"', $controllerName));
    }


    /**
     * Get the console command options.
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Overwrite existing files with generated ones.'],
            [
                'model',
                null,
                InputOption::VALUE_OPTIONAL,
                'Define which model name to use, otherwise the singular controller name is used.'
            ],
            ['translated', 't', InputOption::VALUE_NONE, 'Generate translation ready files.'],
        ];
    }

}
