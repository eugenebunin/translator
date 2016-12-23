<?php namespace EugeneBunin\Translator;

use Illuminate\Translation\Translator as IlluminateTranslator;
use Illuminate\Support\Arr;

class Translator extends IlluminateTranslator
{

    /**
     * Get the JSON translation for a given key.
     *
     * @param  string  $key
     * @param  array   $replace
     * @param  string  $locale
     * @return string
     */
    public function getJson($key, array $replace = [], $locale = null)
    {
        $locale = $locale ?: $this->locale;
        $this->load('*', '*', $locale);
        $line = Arr::get($this->loaded['*']['*'][$locale], $key);
        if (! isset($line)) {
            $alternativeLine = $this->get($key, $replace, $locale);
            if ($alternativeLine != $key) {
                return $alternativeLine;
            }
        }
        return $this->makeJsonReplacements($line ?: $key, $replace);
    }

    /**
     * Make the place-holder replacements on a JSON line.
     *
     * @param  string  $line
     * @param  array   $replace
     * @return string
     */
    protected function makeJsonReplacements($line, array $replace)
    {
        preg_match_all('#:(?:[a-zA-Z1-9]*)#s', $line, $placeholders);
        $placeholders = $placeholders[0];
        foreach ($placeholders as $i => $key) {
            $line = str_replace_first(
                $key, isset($replace[$i]) ? $replace[$i] : $key, $line
            );
        }
        return $line;
    }
}
