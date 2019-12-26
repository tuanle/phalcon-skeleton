<?php

namespace Support\Exceptions;

use Phalcon\Exception as PhalconException;

class ApiRequestException extends PhalconException
{
    public function __construct($message = 'Api Server Error', $code = 500, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
