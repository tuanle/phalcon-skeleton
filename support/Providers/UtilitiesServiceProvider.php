<?php

namespace Support\Providers;

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;

class UtilitiesServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers the service
     */
    public function register(DiInterface $di)
    {
        // Flash message
        $di->setShared('flashSession', new \Phalcon\Flash\Session([
            'error'   => 'alert alert-danger',
            'success' => 'alert alert-success',
            'notice'  => 'alert alert-info',
            'warning' => 'alert alert-warning'
        ]));

        // Flash Input
        $di->set('flashInput', new \Support\Session\Flash\FlashInput);

        // Flash Error
        $di->set('flashError', new \Support\Session\Flash\FlashError);

        // Tag
        $di->setShared('tag', new \Phalcon\Tag);

        // Url
        $di->setShared('url', new \Phalcon\Mvc\Url);

        // Filter
        $di->setShared('filter', new \Phalcon\Filter);

        // Escaper
        $di->setShared('escaper', new \Phalcon\Escaper);

        // Cookie
        $di->setShared('cookies', new \Phalcon\Http\Response\Cookies);

        // Model Manager
        $di->setShared('modelsManager', new \Phalcon\Mvc\Model\Manager);

        // Model Metadata
        $di->setShared('modelsMetadata', new \Phalcon\Mvc\Model\MetaData\Memory);
    }
}
