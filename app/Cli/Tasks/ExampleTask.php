<?php

namespace App\Cli\Tasks;

use Phalcon\Cli\Task;

class ExampleTask extends Task
{
    /**
     * This is a example task
     */
    public function mainAction()
    {
        echo 'Hello Phalcon!' . PHP_EOL;
    }

    public function testActionAction()
    {
        echo 'Test action!' . PHP_EOL;
    }

    public function testParamsAction(array $params)
    {
        echo 'Test params!' . PHP_EOL;
        echo var_dump($params) . PHP_EOL;
    }
}
