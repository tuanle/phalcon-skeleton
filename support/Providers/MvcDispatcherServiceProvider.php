<?php

namespace Support\Providers;

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;

class MvcDispatcherServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers the service
     */
    public function register(DiInterface $di)
    {
        $di->setShared('dispatcher', function () {
            $dispatcher = new MvcDispatcher();
            $dispatcher->setEventsManager($this->getShared('eventsManager'));

            return $dispatcher;
        });
    }
}
