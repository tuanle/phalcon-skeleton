<?php

namespace Support\Providers;

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;
use Phalcon\Logger\Adapter\File as Logger;

class LoggingServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers the service
     */
    public function register(DiInterface $di)
    {
        $di->setShared('log', function () {
            $logger = new Logger(config('app.log_path'));
            return $logger;
        });
    }
}
