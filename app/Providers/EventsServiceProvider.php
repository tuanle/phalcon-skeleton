<?php

namespace App\Providers;

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;
use Phalcon\Events\Manager as EventsManager;

class EventsServiceProvider implements ServiceProviderInterface
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listeners = [
        /*
        |--------------------------------------------------------------------------
        | Dispatcher
        |--------------------------------------------------------------------------
        */
        'dispatch:beforeDispatchLoop' => [
            \Support\Session\StartSession::class,
        ],

        'dispatch:beforeDispatch' => [
            \Support\Http\HandlesRouteMiddlewares::class,
        ],

        'dispatch:beforeExecuteRoute' => [
            \Support\Http\HandlesControllerMiddlewares::class,
        ],

        'dispatch:afterExecuteRoute' => [
            \Support\Http\HandlesControllerMiddlewares::class,
        ],

        'dispatch:beforeException' => [
            \App\Exceptions\Handler::class,
        ],

        'dispatch:afterDispatch' => [
            \Support\Http\HandlesRouteMiddlewares::class,
        ],

        /*
        |--------------------------------------------------------------------------
        | DB
        |--------------------------------------------------------------------------
        */
        'db' => \App\Listeners\Database\QueryListener::class,
    ];

    /**
     * Registers the service
     */
    public function register(DiInterface $di)
    {
        $listeners = $this->listeners;

        $di->setShared('eventsManager', function() use ($listeners) {
            $eventsManager = new EventsManager;

            foreach ($listeners as $event => $handlers) {
                if (is_string($handlers)) {
                    $eventsManager->attach($event, (new $handlers));
                } else if (is_array($handlers)) {
                    foreach ($handlers as $handler) {
                        $eventsManager->attach($event, (new $handler));
                    }
                }
            }

            return $eventsManager;
        });
    }
}
