<?php

namespace Support\Translation;

use Phalcon\Exception;
use Support\Translation\ArrayLoader;

class Translator
{
    /**
     * @string
     */
    protected $language;

    /**
     * Instances the translator base on the language
     *
     * @param string $fallbackLanguage
     * @param string $language
     */
    public function __construct(string $fallbackLanguage, string $language = null)
    {
        $this->language = $language ?: $fallbackLanguage;

        if (! $this->language) {
            throw new Exception('The language for translator is not defined.');
        }
    }

    /**
     * Returns the translation string of the given key
     *
     * @param   string $translateKey
     * @param   array $placeholders
     * @return  string
     */
    public function translate($translateKey, $placeholders = null)
    {
        $pieces = explode('.', $translateKey);
        $key = !empty($pieces) && ($last = end($pieces)) ? $last : $translateKey;

        $apdater = new ArrayLoader($this->language, $translateKey);
        $translation = $apdater->getTranslation();

        return $translation->_($key, $placeholders);
    }
}
