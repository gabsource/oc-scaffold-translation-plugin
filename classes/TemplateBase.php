<?php namespace BnB\ScaffoldTranslation\Classes;

use BnB\ScaffoldTranslation\Models\Settings;
use Exception;

/**
 * Base class for scaffolding templates.
 *
 * The template simply provides a file mapping property.
 *
 * @package october\support
 * @author  Alexey Bobkov, Samuel Georges
 */
abstract class TemplateBase extends \October\Rain\Scaffold\TemplateBase
{

    protected $translated;


    /**
     * Static helper
     *
     * @param string $path Root path to output generated files
     * @param array  $vars Variables to pass to the stub templates
     *
     * @return void
     */
    public static function make($path, $vars = [], $force = false, $translated = false)
    {
        $self = new static($path, $vars);

        if ($force) {
            $self->setOverwrite(true);
        }

        if ( ! $translated) {
            $translated = ! ! Settings::get('default_mode', true);
        }

        $self->translated = $translated;

        return $self->makeAll();
    }


    /**
     * Make a single stub
     *
     * @param $stubName The source filename for the stub.
     *
     * @return void
     */
    public function makeStub($stubName)
    {
        if ( ! $this->translated) {
            return parent::makeStub($stubName);
        }

        if ( ! isset( $this->fileMap[$stubName] )) {
            return;
        }

        $sourceFile         = __DIR__ . '/templates/' . $stubName;
        $destinationFile    = $this->targetPath . '/' . $this->fileMap[$stubName];
        $destinationContent = $this->files->get($sourceFile);

        /*
         * Parse each variable in to the desintation content and path
         */
        foreach ($this->vars as $key => $var) {
            $destinationContent = str_replace('{{' . $key . '}}', $var, $destinationContent);
            $destinationFile    = str_replace('{{' . $key . '}}', $var, $destinationFile);
        }

        /*
         * Destination directory must exist
         */
        $destinationDirectory = dirname($destinationFile);
        if ( ! $this->files->exists($destinationDirectory)) {
            $this->files->makeDirectory($destinationDirectory, 0777, true);
        } // @todo 777 not supported everywhere

        /*
         * Make sure this file does not already exist
         */
        if ($this->files->exists($destinationFile) && ! $this->overwriteFiles) {
            throw new \Exception('Stop everything!!! This file already exists: ' . $destinationFile);
        }

        $this->files->put($destinationFile, $destinationContent);
    }

}