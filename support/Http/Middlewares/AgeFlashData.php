<?php

namespace Support\Http\Middlewares;

use Phalcon\Mvc\Dispatcher;
use Support\Http\Contracts\Middleware;

class AgeFlashData implements Middleware
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
        $this->dispatcher->getDI()->get('flashInput')->ageFlashData();
        $this->dispatcher->getDI()->get('flashError')->ageFlashData();

        return true;
    }
}
