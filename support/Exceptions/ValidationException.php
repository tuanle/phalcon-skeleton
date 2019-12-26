<?php

namespace Support\Exceptions;

use Phalcon\Exception as PhalconException;
use Phalcon\Http\Request;

class ValidationException extends PhalconException
{
    /**
     * Request
     */
    protected $request;

    public function __construct(Request $request, $message = 'The given data was invalid', $code = 422, $previous = null)
    {
        $this->request = $request;

        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the request that has exception
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}
