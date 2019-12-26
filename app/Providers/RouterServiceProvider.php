<?php

namespace App\Providers;

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;
use Phalcon\Mvc\Router;

class RouterServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers the service
     */
    public function register(DiInterface $di)
    {
        $di->set('router', function() use ($di) {
            $router = new Router;
            $router->removeExtraSlashes(true);

            $routes = $di->getConfig()->path('app.domains');
            foreach ($routes as $route) {
                if ($route->get('enabled')
                    &&
                    ($routeFile = $route->get('route'))
                ) {
                    $router->mount(new $routeFile);
                }
            }

            return $router;
        }, true);
    }
}
