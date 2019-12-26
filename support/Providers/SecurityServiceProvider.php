<?php

namespace Support\Providers;

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;
use Phalcon\Security;
use Phalcon\Crypt;

class SecurityServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers the service
     */
    public function register(DiInterface $di)
    {
        // Security
        $di->setShared('security', function () {
            $security = new Security;
            $security->setWorkFactor(12);
            return $security;
        });

        // Crypt
        $di->setShared('crypt', function() {
            $crypt = new Crypt;
            $crypt->setCipher(config('app.cipher'));
            $crypt->setKey(config('app.key'));
            return $crypt;
        });
    }
}
