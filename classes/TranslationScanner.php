<?php namespace BnB\ScaffoldTranslation\Classes;

use October\Rain\Support\Traits\Singleton;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

class TranslationScanner
{

    use Singleton;

    protected $vars = [];

    protected $extensions = ['php', 'htm', 'yaml'];


    public function extensions($extensions = [])
    {
        $this->extensions = $extensions;

        return $this;
    }


    public function with($options = [])
    {
        $this->vars = $options;

        return $this;
    }


    /**
     * @param $path string a directory path to scan
     *
     * @return bool|int the number of new entries. Returns false if the file does not exists
     */
    public function scan($path)
    {
        $path = realpath($path);

        if ( ! $path || ! is_dir($path)) {
            return false;
        }

        $entriesCount = 0;

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path),
            RecursiveIteratorIterator::SELF_FIRST);

        if (count($this->extensions) > 0) {
            $extensions = [];

            foreach ($this->extensions as $extension) {
                $extensions[] = '^.+\.' . $extension . '$';
            }
            $iterator = new RegexIterator($iterator, '/' . join('|', $extensions) . '/i',
                RecursiveRegexIterator::GET_MATCH);
        }

        foreach ($iterator as $name => $file) {
            $entriesCount += +$this->scanFile($name);
        }

        return $entriesCount;
    }


    /**
     * @param $path string a file path to scan
     *
     * @return bool|int the number of new entries. Returns false if the file does not exists
     */
    public function scanFile($path)
    {

        $path = realpath($path);

        if ( ! $path || ! is_file($path)) {
            echo $path;

            return false;
        }

        $entriesCount = 0;
        $entries      = [];
        $matches      = [];
        $content      = file_get_contents($path);

        if (preg_match_all($this->pattern(), $content, $matches)) {
            $entries = array_merge($entries, $matches[0]);
        }

        if (count($entries) > 0) {
            $locales = $this->availableLocales();

            foreach ($locales as $locale) {
                $translations = $this->readLocale($locale);

                foreach ($entries as $entry) {
                    $entriesCount += $this->addIfMissing($entry, $translations, $locale);
                }

                $this->writeLocale($locale, $translations);
            }
        }

        return $entriesCount;
    }


    /**
     * @param string $entry        entry to test
     * @param array  $translations current translations
     * @param string $locale       current language
     *
     * @return int
     * @throws \Exception
     */
    protected function addIfMissing($entry, &$translations, $locale)
    {

        $missing = false;
        $key     = explode('::', $entry);
        $parts   = explode('.', $key[1]);
        // Remove 'locale'
        array_shift($parts);

        $array = $translations;
        foreach ($parts as $part) {
            if ( ! is_array($array)) {
                throw new \Exception($entry . ' is colliding with an existing entry: an array was expected but another item was found');
            }
            if ( ! array_key_exists($part, $array)) {
                $missing = true;
                break;
            }
            $array = $array[$part];
        }

        if ($missing) {
            $array = &$translations;
            foreach ($parts as $part) {
                if ( ! is_array($array)) {
                    $array[$part] = [];
                }
                $array = &$array[$part];
            }
            $array = $this->value($entry, $locale);

            return 1;
        }

        return 0;
    }


    /**
     * @param string $entry  entry key
     * @param string $locale current language
     *
     * @return mixed a default value, fallback to entry key if not provided
     */
    public function value($entry, $locale)
    {
        if (isset( $this->vars[$locale] ) && is_array($this->vars[$locale]) && isset( $this->vars[$locale][$entry] )) {
            return $this->vars[$locale][$entry];
        }

        return $entry;
    }


    /**
     * @return string the base path of the languages files, created if missing
     * @throws \Exception if the path is not a directory
     */
    protected function localePath()
    {
        $path = base_path() . '/plugins/' . strtolower($this->vars['author']) . '/' . strtolower($this->vars['plugin']) . '/lang';

        if ( ! file_exists($path)) {
            mkdir($path);
        }

        if ( ! is_dir($path)) {
            throw new \Exception($path . ' must be a directory');
        }

        return $path;
    }


    /**
     * @return string the pattern to match translation keys
     */
    protected function pattern()
    {
        return '/' . strtolower($this->vars['author']) . '.' . strtolower($this->vars['plugin']) . '::lang.[a-zA-Z0-9_.]+/';
    }


    /**
     * @return array the list of available language codes
     */
    protected function availableLocales()
    {
        $locales = ['en', config('app.locale', 'en'), config('app.fallback_locale', 'en')];

        $iterator = new RecursiveDirectoryIterator($this->localePath());

        foreach ($iterator as $name => $dir) {
            $name = basename($name);
            if ($name !== '.' && $name !== '..') {
                $locales[] = $name;
            }
        }

        return array_unique($locales);
    }


    /**
     * @param string $locale language code
     *
     * @return array the translation array
     */
    protected function readLocale($locale)
    {
        $path = $this->localePath() . '/' . $locale . '/lang.php';

        if ( ! file_exists($path)) {
            return [];
        }

        return include $path;
    }


    /**
     * @param string $locale       the language code to write
     * @param array  $translations the entries to write
     */
    protected function writeLocale($locale, $translations)
    {
        $path = $this->localePath() . '/' . $locale;

        if ( ! file_exists($path)) {
            mkdir($path);
        }

        $path = $path . '/lang.php';

        if ( ! file_exists($path)) {
            file_put_contents($path, <<<PHP
<?php

return [];
PHP
            );
        }

        $contents   = file_get_contents($path);
        $newContent = '';

        foreach ($translations as $key => $array) {
            $newContent .= PHP_EOL . '    \'' . $key . '\' => ' . $this->output($array);
        }

        $newContent = <<<PHP
return [$newContent
];
PHP;
        file_put_contents($path, preg_replace('/return.+$/s', $newContent, $contents));
    }


    /**
     * @param array $arrayOrLeaf item to print
     * @param int   $level       indentation level
     *
     * @return string pretty printed node
     */
    protected function output($arrayOrLeaf, $level = 1)
    {
        if ( ! is_array($arrayOrLeaf)) {
            return '\'' . addcslashes($arrayOrLeaf, '\'') . '\',';
        }

        $content = '';
        $spacer  = str_repeat('    ', $level);

        foreach ($arrayOrLeaf as $key => $array) {
            $content .= PHP_EOL . $spacer . '    \'' . $key . '\' => ' . $this->output($array, $level + 1);
        }

        return <<<PHP
[$content
$spacer],
PHP;

    }


    /**
     * @return array the plugin locales list
     */
    public static function loadPluginLocales()
    {
        $locales = [];

        $iterator = new RecursiveDirectoryIterator(base_path() . '/plugins/bnb/scaffoldtranslation/lang');

        foreach ($iterator as $name => $dir) {
            $name = basename($name);
            if ($name !== '.' && $name !== '..') {
                $locales[] = $name;
            }
        }

        return array_unique($locales);
    }

}