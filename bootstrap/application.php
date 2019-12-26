<?php

use Phalcon\Mvc\Application as MvcApplication;

class Application extends AbstractApplication
{
    /**
     * @var array
     */
    protected $configurationPaths  = [
        'app'         => 'config/app.php',
        'database'    => 'config/database.php',
        'session'     => 'config/session.php',
        'auth'        => 'config/auth.php',
        'filesystems' => 'config/filesystems.php',
    ];

    /**
     * Initializes the main application
     */
    protected function initApplication()
    {
        $this->application = new MvcApplication($this->di);

        $this->di->set('app', $this->application);

        $this->registerProviders();
    }

    /**
     * Registers application's providers
     */
    protected function registerProviders()
    {
        $providers = config('app.providers');

        foreach ($providers as $provider) {
            $this->di->register(new $provider);
        }
    }

    /**
     * Runs the main application
     */
    protected function runApplication()
    {
        try {
            $response = $this->application->handle();
            $response->send();
        } catch (\Exception $e) {
            if (config('app.debug')) {
                throw $e;
            }

            $response = $this->di->get('response');
            $response->setContent('<html><body><h1>500 Internal Server Error</h1></body></html>');
            $response->send();
        }
    }
}
