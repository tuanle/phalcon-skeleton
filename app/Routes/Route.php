<?php

namespace App\Routes;

use Phalcon\Mvc\Router\Group as RouterGroup;
use Support\Http\Concerns\InteractsWithMiddleware;

class Route extends RouterGroup
{
    use InteractsWithMiddleware;
}
