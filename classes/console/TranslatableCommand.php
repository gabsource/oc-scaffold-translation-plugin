<?php
/**
 * october
 *
 * @author    Jérémy GAULIN <jeremy@bnb.re>
 * @copyright 2016 - B&B Web Expertise
 */

namespace BnB\ScaffoldTranslation\Classes\Console;

use BnB\ScaffoldTranslation\Classes\TranslationScanner;
use Lang;
use ReflectionClass;

trait TranslatableCommand
{

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->isTranslationModeActive()) {
            $this->comment(trans('bnb.scaffoldtranslation::lang.commands.disclaimer'));

            parent::handle();

            $this->info(trans('bnb.scaffoldtranslation::lang.commands.success',
                ['type' => $this->type, 'name' => $this->vars['author'] . '.' . $this->vars['name']]));
        } else {
            parent::handle();
        }
    }


    public function makeStub($stubName)
    {
        parent::makeStub($stubName);

        $translatedVars = $this->processTranslatedVars();

        foreach ($this->getScannedFiles() as $file) {
            TranslationScanner::instance()->with($translatedVars)->scanFile($file);
        }

        foreach ($this->getScannedFolders() as $folder) {
            TranslationScanner::instance()->with($translatedVars)->scan($folder);
        }
    }


    /**
     * Prepare translated variables for stubs.
     *
     * @return array
     */
    protected function processTranslatedVars()
    {

        $defaultLocale = Lang::getLocale();
        $locales       = TranslationScanner::loadPluginLocales();
        $vars          = array_merge_recursive([], $this->vars);

        foreach ($locales as $locale) {
            Lang::setLocale($locale);

            $vars = array_merge_recursive($vars, [$locale => $this->prepareTranslatedVars()]);
        }

        Lang::setLocale($defaultLocale);

        return $vars;
    }


    /**
     * Get the source file path.
     *
     * @return string
     */
    protected function getSourcePath(): string
    {
        if ($this->isTranslationModeActive()) {
            $className = get_class($this);
        } else {
            $className = get_parent_class($this);
        }

        $class = new ReflectionClass($className);

        return dirname($class->getFileName());
    }


    public function isTranslationModeActive()
    {
        return true;
    }

}