<?php

namespace Support\Exceptions;

use Phalcon\Exception as PhalconException;

class ModelNotFoundException extends PhalconException
{
    public function __construct($message = 'No query results', $code = 404, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
