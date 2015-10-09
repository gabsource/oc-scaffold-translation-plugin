<?php namespace BnB\ScaffoldTranslation\Classes\Console;

use BnB\ScaffoldTranslation\Classes\TranslationScanner;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class PluginTranslate extends Command
{

    /**
     * The console command name.
     */
    protected $name = 'plugin:translate';

    /**
     * The console command description.
     */
    protected $description = 'Generates missing plugin translation entries.';


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

        if (count($parts) != 2) {
            $this->error('Invalid plugin name, either too many dots or not enough.');
            $this->error('Example name: AuthorName.PluginName');

            return;
        }

        $pluginName = array_pop($parts);
        $authorName = array_pop($parts);

        $destinationPath = base_path() . '/plugins/' . strtolower($authorName) . '/' . strtolower($pluginName);
        $vars            = [
            'plugin' => $pluginName,
            'author' => $authorName,
        ];

        $scanner = TranslationScanner::instance();

        $this->info(sprintf('Scanning classes...'));
        $this->noFiles($scanner->with($vars)->scan($destinationPath . '/classes'));

        $this->info(sprintf('Scanning controllers...'));
        $this->noFiles($scanner->with($vars)->scan($destinationPath . '/controllers'));

        $this->info(sprintf('Scanning models...'));
        $this->noFiles($scanner->with($vars)->scan($destinationPath . '/models'));

        $this->info(sprintf('Scanning components...'));
        $this->noFiles($scanner->with($vars)->scan($destinationPath . '/components'));

        $this->info(sprintf('Scanning widgets...'));
        $this->noFiles($scanner->with($vars)->scan($destinationPath . '/widgets'));

        $this->info(sprintf('Scanning formwidgets...'));
        $this->noFiles($scanner->with($vars)->scan($destinationPath . '/formwidgets'));

        $this->info(sprintf('Scanning report widgets...'));
        $this->noFiles($scanner->with($vars)->scan($destinationPath . '/reportwidgets'));

        $this->info(sprintf('Scanning plugin files...'));
        $this->noFiles($scanner->with($vars)->scanFile($destinationPath . '/Plugin.php'));

        $this->info(sprintf('Successfully generated translation entries for plugin "%s"', $pluginCode));
    }


    /**
     * Get the console command arguments.
     */
    protected function getArguments()
    {
        return [
            [
                'pluginCode',
                InputArgument::REQUIRED,
                'The name of the plugin to scan. Eg: RainLab.Blog'
            ],
        ];
    }


    /**
     * Get the console command options.
     */
    protected function getOptions()
    {
        return [];
    }


    protected function noFiles($found)
    {
        if ($found === false) {
            $this->info(sprintf('... no file found.'));
        } else {
            $this->info(sprintf('... found %s new entries.', $found));
        }
    }

}