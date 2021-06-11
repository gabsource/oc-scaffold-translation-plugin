<?php namespace BnB\ScaffoldTranslation\Classes\Console;

use Lang;
use Symfony\Component\Console\Input\InputOption;

class CreatePlugin extends \October\Rain\Scaffold\Console\CreatePlugin implements TranslationAwareCommand
{

    use TranslatableCommand;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'create:plugin:translated';


    public function prepareVars(): array
    {
        $vars = parent::prepareVars();

        $vars['plugin'] = $vars['name'];

        return $vars;
    }


    /**
     * Build custom translated variables for the stub generation
     *
     * @return array
     */
    public function prepareTranslatedVars()
    {
        $langPrefix = strtolower($this->vars['author']) . '.' . strtolower($this->vars['name']) . '::lang.';

        return [
            $langPrefix . 'plugin.name'                 =>
                trans('bnb.scaffoldtranslation::lang.defaults.plugin.name', ['name' => $this->vars['name']]),
            $langPrefix . 'plugin.description'          =>
                trans('bnb.scaffoldtranslation::lang.defaults.plugin.description'),
            $langPrefix . 'permissions.some_permission' => trans('bnb.scaffoldtranslation::lang.defaults.plugin.permissions.some_permission'),
        ];
    }


    /**
     * Get the list of files to scan for translation
     *
     * @return array
     */
    public function getScannedFiles()
    {
        return [$this->getDestinationPath() . '/Plugin.php'];
    }


    /**
     * Get the list of folders to scan recursively for translation
     *
     * @return array
     */
    public function getScannedFolders()
    {
        return [];
    }
}
