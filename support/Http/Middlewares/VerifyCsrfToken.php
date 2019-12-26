<?php

namespace Support\Http\Middlewares;

use Phalcon\Mvc\Dispatcher;
use Support\Http\Contracts\Middleware;
use Support\Exceptions\InvalidCsrfTokenException;

class VerifyCsrfToken implements Middleware
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

    public function handle(array $params = [])
    {
        if ($this->dispatcher->getDI()->get('request')->isPost()) {

            if ($this->dispatcher->getDI()->get('request')->isAjax()) {
                $verified = $this->dispatcher->getDI()->get('security')->checkToken('_csrf', null, false);
            } else {
                $verified = $this->dispatcher->getDI()->get('security')->checkToken('_csrf');
            }

            if ( ! $verified) {
                throw new InvalidCsrfTokenException;
            }
        }

        return true;
    }
}
