<?php namespace BnB\ScaffoldTranslation\Classes\Console;

use Illuminate\Console\Command;
use Lang;
use October\Rain\Scaffold\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class CreateWidget extends GeneratorCommand implements TranslationAwareCommand
{

    use TranslatableCommand;

    /**
     * The console command name.
     */
    protected $name = 'create:widget:translated';

    /**
     * The console command description.
     */
    protected $description = 'Creates a new widget.';

    /**
     * The console command description.
     */
    protected $type = 'Widget';

    /**
     * @var array A mapping of stub to generated file.
     */
    protected $stubs = [
        'widget/widget.stub'     => 'widgets/{{studly_name}}.php',
        'widget/partial.stub'    => 'widgets/{{lower_name}}/_{{lower_name}}.htm',
        'widget/stylesheet.stub' => 'widgets/{{lower_name}}/assets/css/{{lower_name}}.css',
        'widget/javascript.stub' => 'widgets/{{lower_name}}/assets/js/{{lower_name}}.js',
    ];


    /**
     * Prepare variables for stubs.
     *
     * return @array
     */
    protected function prepareVars()
    {
        $pluginCode = $this->argument('plugin');

        $parts  = explode('.', $pluginCode);
        $plugin = array_pop($parts);
        $author = array_pop($parts);
        $widget = $this->argument('widget');

        return [
            'name'   => $widget,
            'author' => $author,
            'plugin' => $plugin
        ];
    }


    /**
     * Get the console command arguments.
     */
    protected function getArguments()
    {
        return [
            ['plugin', InputArgument::REQUIRED, 'The name of the plugin. Eg: RainLab.Blog'],
            ['widget', InputArgument::REQUIRED, 'The name of the widget. Eg: PostList'],
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


    /**
     * Build custom translated variables for the stub generation
     *
     * @return array
     */
    public function prepareTranslatedVars()
    {
        $langPrefix = strtolower($this->vars['author']) . '.' . strtolower($this->vars['plugin']) . '::lang.wdigets.' . strtolower($this->vars['name']) . '.';

        return [
            $langPrefix . 'plugin.name'        =>
                trans('bnb.scaffoldtranslation::lang.defaults.widget.name', ['name' => $this->vars['name']]),
            $langPrefix . 'plugin.description' =>
                trans('bnb.scaffoldtranslation::lang.defaults.widget.description')
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
        return [$this->getDestinationPath() . '/widgets'];
    }
}