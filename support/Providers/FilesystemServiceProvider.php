<?php

namespace Support\Providers;

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;
use Support\Filesystem\FilesystemManager;

class FilesystemServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers the service
     */
    public function register(DiInterface $di)
    {
        $di->setShared('filesystem', new FilesystemManager);
    }
}
