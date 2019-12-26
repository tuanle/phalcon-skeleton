<?php

namespace Support\Http\Middlewares;

use Phalcon\Mvc\Dispatcher;
use Support\Http\Contracts\Middleware;
use Support\Exceptions\AuthenticationException;

class Authenticate implements Middleware
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * Constructor
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handle the incoming request
     */
    public function handle(array $params = [])
    {
        if (isset($params['excepts']) && is_array($params['excepts'])) {
            $currentRouteName = $this->dispatcher->getDi()->getRouter()->getMatchedRoute()->getName();
            if (in_array($currentRouteName, $params['excepts'])) {
                return true;
            }
        }

        if (!empty($params['guard'])) {
            $guard = $this->dispatcher->getDi()->getAuth()->guard($params['guard']);

            if (! $guard->user()) {
                throw new AuthenticationException($guard);
            }
        }

        return true;
    }
}
