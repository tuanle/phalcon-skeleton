<?php

namespace Support\Session;

use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;

class StartSession
{
    /**
     * Start the session
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     */
    public function beforeDispatchLoop(Event $event, Dispatcher $dispatcher)
    {
        $dispatcher->getDI()->get('session')->start();
    }
}
