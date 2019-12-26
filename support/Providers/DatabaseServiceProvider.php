<?php

namespace Support\Providers;

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Profiler;

class DatabaseServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers the service
     */
    public function register(DiInterface $di)
    {
        // Database config
        $di->setShared('db', function () {
            $connectionType = config('database.default');

            if ($connectionType == 'mysql') {
                $connection = new Mysql(config('database.connections')->get($connectionType)->toArray());
            }

            if (config('app.debug_sql')) {
                $connection->setEventsManager($this->getShared('eventsManager'));
            }

            return $connection;
        });
    }
}
