<?php
/**
 * october
 *
 * @author    Jérémy GAULIN <jeremy@bnb.re>
 * @copyright 2016 - B&B Web Expertise
 */

namespace bnb\scaffoldtranslation\classes\console;

interface TranslationAwareCommand
{

    /**
     * Build custom translated variables for the stub generation
     *
     * @return array
     */
    public function prepareTranslatedVars();


    /**
     * Get the list of files to scan for translation
     *
     * @return array
     */
    public function getScannedFiles();


    /**
     * Get the list of folders to scan recursively for translation
     *
     * @return array
     */
    public function getScannedFolders();
}