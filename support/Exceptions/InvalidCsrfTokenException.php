<?php

namespace Support\Exceptions;

use Phalcon\Exception as PhalconException;

class InvalidCsrfTokenException extends PhalconException
{
    public function __construct($message = 'Invalid CSRF Token', $code = 403, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
