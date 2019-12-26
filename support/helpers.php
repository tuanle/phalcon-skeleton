<?php

if (!function_exists('dump')) {
    /**
     * Dump the passed variables without end the script.
     *
     * @param  mixed
     * @return void
     */
    function dump()
    {
        array_map(function ($x) {
            $string = (new \Phalcon\Debug\Dump([], true))->variable($x);
            echo (PHP_SAPI == 'cli' ? strip_tags($string) . PHP_EOL : $string);
        }, func_get_args());
    }
}

if (!function_exists('dd')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed
     * @return void
     */
    function dd()
    {
        call_user_func_array('dump', func_get_args());
        die(1);
    }
}

if (!function_exists('config')) {
    /**
     * Get config by the path
     * Example: config('app')
     *
     * @return mixed|\Phalcon\Config
     */
    function config($path)
    {
        return \Phalcon\Di::getDefault()->getConfig()->path($path);
    }
}

if (!function_exists('__')) {
    /**
     * Returns the translation string of the given key
     *
     * @param   string $translateKey
     * @param   array $placeholders
     * @return  string
     */
    function __($translateKey, $placeholders = [])
    {
        try {
            $translator = \Phalcon\Di::getDefault()->get('translation');
            return $translator->translate($translateKey, $placeholders);
        } catch (\Exception $e) {
            return $translateKey;
        }
        return config("constant.{$key}");
    }
}

if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }

        if (($valueLength = strlen($value)) > 1 && $value[0] === '"' && $value[$valueLength - 1] === '"') {
            return substr($value, 1, -1);
        }

        return $value;
    }
}
