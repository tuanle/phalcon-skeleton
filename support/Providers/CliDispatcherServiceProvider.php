<?php

namespace Support\Providers;

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;
use Phalcon\Cli\Dispatcher as CliDispatcher;

class CliDispatcherServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers the service
     */
    public function register(DiInterface $di)
    {
        $di->setShared('dispatcher', function() {
            $dispatcher = new CliDispatcher();
            $dispatcher->setDefaultNamespace('App\Cli\Tasks');

            return $dispatcher;
        });
    }
}
