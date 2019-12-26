<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as AppController;

/**
 * Base controller for Admin
 */
class Controller extends AppController
{
    protected function onConstruct()
    {
        parent::onConstruct();

        /*
        $this->setBeforeMiddlewares([
            \Support\Http\Middlewares\Authenticate::class => ['guard' => 'admin'],
        ]);
        */
    }
}
