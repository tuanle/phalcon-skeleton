<?php

namespace Support\Api;

class Request
{
    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var array
     */
    protected $formParams;

    /**
     * @var string
     */
    protected $sink;

    /**
     * Constructor
     */
    public function __construct(string $method, string $uri, array $formParams, $sink = null)
    {
        $this->method     = $method;
        $this->uri        = $uri;
        $this->sink       = $sink;
        $this->formParams = $formParams;
    }

    public function method()
    {
        return $this->method;
    }

    public function uri()
    {
        return $this->uri;
    }

    public function formParams()
    {
        return $this->formParams;
    }

    public function sink()
    {
        return $this->sink;
    }
}
