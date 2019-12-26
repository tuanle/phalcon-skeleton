<?php

namespace Support\Providers;

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;
use Phalcon\Session\Adapter\Files as FileSession;

class SessionServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers the service
     */
    public function register(DiInterface $di)
    {
        // Session
        $di->setShared('session', function () use ($di) {
            $connectionType = config('session.driver');

            if ($connectionType == 'file') {
                $session = new FileSession();
            }

            return $session;
        });
    }
}
