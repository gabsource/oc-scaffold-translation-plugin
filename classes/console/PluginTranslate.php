<?php namespace BnB\ScaffoldTranslation\Classes\Console;

use BnB\ScaffoldTranslation\Classes\TranslationScanner;
use Illuminate\Console\Command;
use InvalidArgumentException;
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
    public function handle()
    {
        /*
         * Extract the author and name from the plugin code
         */
        $plugin = $this->argument('name');
        $parts      = explode('.', $plugin);

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

        collect([
            'behaviors',
            'classes',
            'console',
            'controllers',
            'components',
            'helpers',
            'models',
            'partials',
            'widgets',
            'formwidgets',
            'reportwidgets',
            'traits',
            'twig',
            'views',
        ])->each(function ($path) use ($destinationPath, $scanner, $vars) {
            $target = "{$destinationPath}/{$path}";

            if (is_dir($target)) {
                $this->info(sprintf("Scanning {$path}..."));
                $this->noFiles($scanner->with($vars)->scan($target));
            }
        });

        collect([
            'Plugin.php',
        ])->each(function ($path) use ($destinationPath, $scanner, $vars) {
            $target = "{$destinationPath}/{$path}";

            if (is_file($target)) {
                $this->info(sprintf("Scanning {$path}..."));
                $this->noFiles($scanner->with($vars)->scanFile($target));
            }
        });

        $this->info(sprintf('Successfully generated translation entries for plugin "%s"', $plugin));
    }


    /**
     * Get the console command arguments.
     */
    protected function getArguments()
    {
        return [
            [
                'name',
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