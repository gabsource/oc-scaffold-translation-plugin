<?php namespace BnB\ScaffoldTranslation\Classes\Console;

use Lang;
use Symfony\Component\Console\Input\InputOption;

class CreateController extends \October\Rain\Scaffold\Console\CreateController implements TranslationAwareCommand
{

    use TranslatableCommand;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'create:controller:translated';


    /**
     * Build custom translated variables for the stub generation
     *
     * @return array
     */
    public function prepareTranslatedVars()
    {
        $langPrefix = strtolower($this->vars['author']) . '.' . strtolower($this->vars['plugin']) . '::lang.';

        $titleSingular = $this->vars['title_singular_name'];
        $titlePlural   = $this->vars['title_plural_name'];
        $plural        = $this->vars['lower_plural_name'];
        $singular      = $this->vars['lower_singular_name'];
        $prefix        = 'bnb.scaffoldtranslation::lang.defaults.controller';

        return [
            $langPrefix . $plural . '.return_to_list'          =>
                trans($prefix . '.return_to_list', ['name' => $titlePlural]),
            $langPrefix . $plural . '.delete_confirm'          =>
                trans($prefix . '.delete_confirm', ['name' => $titleSingular]),
            $langPrefix . $plural . '.delete_selected_success' =>
                trans($prefix . '.delete_selected_success', ['name' => $titlePlural]),
            $langPrefix . $plural . '.delete_selected_empty'   =>
                trans($prefix . '.delete_selected_empty', ['name' => $titlePlural]),
            $langPrefix . $plural . '.delete_selected_confirm' =>
                trans($prefix . '.delete_selected_confirm', ['name' => $titlePlural]),
            $langPrefix . $plural . '.menu_label'              =>
                trans($prefix . '.menu_label', ['name' => $titlePlural]),

            $langPrefix . $singular . '.new'           =>
                trans($prefix . '.new', ['name' => $titleSingular]),
            $langPrefix . $singular . '.label'         =>
                trans($prefix . '.label', ['name' => $titleSingular]),
            $langPrefix . $singular . '.list_title'    =>
                trans($prefix . '.manage', ['name' => $titlePlural]),
            $langPrefix . $singular . '.create_title'  =>
                trans($prefix . '.create', ['name' => $titleSingular]),
            $langPrefix . $singular . '.update_title'  =>
                trans($prefix . '.update', ['name' => $titleSingular]),
            $langPrefix . $singular . '.preview_title' =>
                trans($prefix . '.preview', ['name' => $titleSingular])
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
        return [$this->getDestinationPath() . '/controllers'];
    }
}
