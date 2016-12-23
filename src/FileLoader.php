<?php namespace EugeneBunin\Translator;

use Illuminate\Translation\FileLoader as IlluminateFileLoader;

class FileLoader extends IlluminateFileLoader
{

    /**
     * Load the messages for the given locale.
     *
     * @param  string  $locale
     * @param  string  $group
     * @param  string  $namespace
     * @return array
     */
    public function load($locale, $group, $namespace = null)
    {
        if ($group == '*' && $namespace == '*') {
            return $this->loadJson($this->path, $locale);
        }
        if (is_null($namespace) || $namespace == '*') {
            return $this->loadPath($this->path, $locale, $group);
        }
        return $this->loadNamespaced($locale, $group, $namespace);
    }

    /**
     * Load a locale from a given JSON file.
     *
     * @param  string  $path
     * @param  string  $locale
     * @return array
     */
    protected function loadJson($path, $locale)
    {
        if ($this->files->exists($full = "{$path}/{$locale}.json")) {
            return (array) json_decode($this->files->get($full));
        }
        return [];
    }
}
