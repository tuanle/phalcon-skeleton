<?php

namespace Support\Http;

use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;

class HandlesRouteMiddlewares
{
    /**
     * Handles the before-middleware that is registered to route
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        if ($dispatcher->wasForwarded()) {
            return true;
        }

        if ($dispatcher->getDI()->getRouter()->getMatchedRoute()) {
            $routeGroup = $dispatcher->getDI()->getRouter()->getMatchedRoute()->getGroup();

            if ($routeGroup
                &&
                method_exists($routeGroup, 'getBeforeMiddlewares')
                &&
                ($beforeMiddlewares = $routeGroup->getBeforeMiddlewares())
            ) {
                foreach ($beforeMiddlewares as $middleware => $params) {
                    (new $middleware($dispatcher))->handle($params);
                }
            }
        }

        return true;
    }

    /**
     * Handles the after-middleware that is registered to route
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     */
    public function afterDispatch(Event $event, Dispatcher $dispatcher)
    {
        if ($dispatcher->wasForwarded()) {
            return true;
        }

        if ($dispatcher->getDI()->getRouter()->getMatchedRoute()) {
            $routeGroup = $dispatcher->getDI()->getRouter()->getMatchedRoute()->getGroup();

            if ($routeGroup
                &&
                method_exists($routeGroup, 'getAfterMiddlewares')
                &&
                ($afterMiddlewares = $routeGroup->getAfterMiddlewares())
            ) {
                foreach ($afterMiddlewares as $middleware => $params) {
                    (new $middleware($dispatcher))->handle($params);
                }
            }
        }

        return true;
    }
}
