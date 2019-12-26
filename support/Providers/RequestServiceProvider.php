<?php

namespace Support\Providers;

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;

class RequestServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers the service
     */
    public function register(DiInterface $di)
    {
        // Request
        $di->set('request', new \Support\Http\Request);
    }
}
