<?php

namespace Support\Providers;

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;
use Support\Translation\Translator;

class TranslationServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers the service
     */
    public function register(DiInterface $di)
    {
        $di->setShared('translation', function () {
            $appLocale = config('app.locale');
            $appFallbackLocale = config('app.fallback_locale');

            $translator = new Translator($appFallbackLocale, $appLocale);

            return $translator;
        });
    }
}
