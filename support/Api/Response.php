<?php

namespace Support\Api;

class Response
{
    /**
     * @var bool
     */
    protected $success;

    /**
     * @var int
     */
    protected $code;

    /**
     * @var array
     */
    protected $data;

    /**
     * Constructor
     */
    public function __construct(bool $success, int $code, array $data)
    {
        $this->success = $success;
        $this->code = $code;
        $this->data = $data;
    }

    public function success()
    {
        return $this->success;
    }

    public function code()
    {
        return $this->code;
    }

    public function data()
    {
        return $this->data;
    }
}
