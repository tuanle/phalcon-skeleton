<?php

namespace Support\Auth;

use Phalcon\Config;
use Phalcon\Mvc\User\Component;
use Phalcon\Mvc\Dispatcher\Exception as DispatcherException;
use Support\Auth\SessionGuard;

class AuthManager extends Component
{
    /**
     * Build authentication guard
     */
    public function guard(string $name = null)
    {
        $name = $name ?: config('auth.defaults.guard');

        if (empty($guard = config("auth.guards.{$name}"))) {
            throw new DispatcherException("Configuration for guard [{$name}] is not existed.");
        }

        switch ($guard->driver)
        {
            case 'session':
                $sessionGuard = new SessionGuard($guard, $name);
                $sessionGuard->setDi($this->getDi());
                return $sessionGuard;
            default:
                throw new DispatcherException("The guard [{$guard->driver}] is not defined.");
        }
    }
}
