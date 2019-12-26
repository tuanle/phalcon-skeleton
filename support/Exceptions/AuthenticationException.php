<?php

namespace Support\Exceptions;

use Phalcon\Exception as PhalconException;
use Support\Auth\Contracts\Guard;

class AuthenticationException extends PhalconException
{
    /**
     * Guard
     */
    protected $guard;

    public function __construct(Guard $guard, $message = 'Unauthenticated', $code = 401, $previous = null)
    {
        $this->guard = $guard;

        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the guard that throws this exception
     *
     * @return Guard
     */
    public function getGuard()
    {
        return $this->guard;
    }
}
