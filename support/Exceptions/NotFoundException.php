<?php

namespace Support\Exceptions;

use Phalcon\Exception as PhalconException;

class NotFoundException extends PhalconException
{
    public function __construct($message = 'Page not found', $code = 404, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
