<?php

namespace Support\Providers;

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;
use Phalcon\Debug as Debugger;

class DebuggingServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers the service
     */
    public function register(DiInterface $di)
    {
        if (config('app.debug')) {
            (new Debugger)->listen(true, true);
        }
    }
}
