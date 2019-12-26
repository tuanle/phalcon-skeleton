<?php

namespace App\Routes;

use App\Routes\Route as AppRoute;

class AdminRoute extends AppRoute
{
    /**
     * Initializes the route
     */
    public function initialize()
    {
        // Default paths
        $this->setPaths([
            'namespace' => 'App\Http\Controllers\Admin',
        ]);

        // Default hostname
        $this->setHostname(config('app.domains.admin.host'));

        // Set route middlewares
        $this->setBeforeMiddlewares([
            \Support\Http\Middlewares\VerifyCsrfToken::class => [],
            \Support\Http\Middlewares\AgeFlashData::class => [],
            \Support\Http\Middlewares\BindingControllerParameters::class => [],
        ]);

        // Add routes
        $this->addRoutes();
    }

    /**
     * Add routes
     */
    protected function addRoutes()
    {
        // Top page
        $this->addGet('/', 'Top::index')->setName('admin.top.index');
    }
}
