<?php namespace BnB\ScaffoldTranslation\Classes\Console;

use Lang;
use Symfony\Component\Console\Input\InputOption;

class CreateComponent extends \October\Rain\Scaffold\Console\CreateComponent implements TranslationAwareCommand
{

    use TranslatableCommand;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'create:component:translated';


    /**
     * Build custom translated variables for the stub generation
     *
     * @return array
     */
    public function prepareTranslatedVars()
    {
        $langPrefix = strtolower($this->vars['author']) . '.' . strtolower($this->vars['plugin']) . '::lang.components.' . strtolower($this->vars['name']) . '.';

        return [
            $langPrefix . 'name'        =>
                trans('bnb.scaffoldtranslation::lang.defaults.component.name', ['name' => $this->vars['name']]),
            $langPrefix . 'description' =>
                trans('bnb.scaffoldtranslation::lang.defaults.component.description')
        ];
    }


    /**
     * Get the list of files to scan for translation
     *
     * @return array
     */
    public function getScannedFiles()
    {
        return [];
    }


    /**
     * Get the list of folders to scan recursively for translation
     *
     * @return array
     */
    public function getScannedFolders()
    {
        return [$this->getDestinationPath() . '/components'];
    }
}