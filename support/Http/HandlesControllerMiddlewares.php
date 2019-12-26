<?php

namespace Support\Http;

use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;

class HandlesControllerMiddlewares
{
    /**
     * Handles the before-middleware that is registered to controller
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     */
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        if ($dispatcher->wasForwarded()) {
            return true;
        }

        $controller = $dispatcher->getActiveController();

        if ($controller
            &&
            method_exists($controller, 'getBeforeMiddlewares')
            &&
            ($beforeMiddlewares = $controller->getBeforeMiddlewares())
        ) {
            foreach ($beforeMiddlewares as $middleware => $params) {
                (new $middleware($dispatcher))->handle($params);
            }
        }

        return true;
    }

    /**
     * Handles the after-middleware that is registered to controller
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     */
    public function afterExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        $controller = $dispatcher->getActiveController();

        if ($controller
            &&
            method_exists($controller, 'getAfterMiddlewares')
            &&
            ($afterMiddlewares = $controller->getAfterMiddlewares())
        ) {
            foreach ($afterMiddlewares as $middleware => $params) {
                (new $middleware($dispatcher))->handle($params);
            }
        }

        return true;
    }
}
