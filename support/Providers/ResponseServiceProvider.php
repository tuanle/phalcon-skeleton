<?php

namespace Support\Providers;

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;

class ResponseServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers the service
     */
    public function register(DiInterface $di)
    {
        // Response
        $di->set('response', function () {
            $response = new \Phalcon\Http\Response;

            $response->setHeader('X-XSS-Protection', '1; mode=block');
            $response->setHeader('X-Content-Type-Options', 'nosniff');
            $response->setHeader('X-Frame-Options', 'deny');

            return $response;
        });
    }
}
