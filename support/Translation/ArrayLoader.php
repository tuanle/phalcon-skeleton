<?php

namespace Support\Translation;

use Phalcon\Translate\Adapter\NativeArray;

class ArrayLoader
{
    /**
     * @string
     */
    protected $language;

    /**
     * @string
     */
    protected $path;

    /**
     * Constructor
     */
    public function __construct(string $language, string $key)
    {
        $this->language = $language;

        $pieces = explode('.', $key);
        $pathPieces = array_slice($pieces, 0, -1); // Remove last element

        if (empty($pathPieces)) {
            $this->path = 'messages';
        } else {
            $this->path = implode('//', $pathPieces);
        }
    }

    /**
     * Get the array of translation
     *
     * @return NativeArray
     */
    public function getTranslation()
    {
        return new NativeArray([
            'content' => include $this->getTranslationFile()
        ]);
    }

    /**
     * Get the file which contains the translation array
     *
     * @return string
     */
    protected function getTranslationFile()
    {
        return BASE_PATH . '/resources/lang/' . $this->language . '/' . $this->path . '.php';
    }
}
