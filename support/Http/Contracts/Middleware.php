<?php

namespace Support\Http\Contracts;

use Phalcon\Mvc\Dispatcher;

interface Middleware
{
    public function __construct(Dispatcher $dispatcher);

    public function handle(array $params = []);
}
