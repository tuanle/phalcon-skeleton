<?php

namespace App\Providers;

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;
use App\Services;
use App\Services\Interfaces as ServiceInterfaces;
use App\Repositories;
use App\Repositories\Interfaces as RepositoryInterfaces;

class AppServiceProvider implements ServiceProviderInterface
{
    /**
     * Application Services
     *
     * @var array
     */
    protected $applicationServices = [
        //
    ];

    /**
     * Application Repositories
     *
     * @var array
     */
    protected $applicationRepositories = [
        //
    ];

    /**
     * Registers the service
     */
    public function register(DiInterface $di)
    {
        // Registers application services
        foreach ($this->applicationServices as $interface => $service) {
            $di->set($interface, $service, true);
        }

        // Registers application repositories
        foreach ($this->applicationRepositories as $interface => $repository) {
            $di->set($interface, $repository);
        }
    }
}
