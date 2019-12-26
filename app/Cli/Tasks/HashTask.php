<?php

namespace App\Cli\Tasks;

use Phalcon\Cli\Task;
use Phalcon\Security;
use Phalcon\Crypt;

class HashTask extends Task
{
    /**
     * This task helps to make the hash string from input string
     */
    public function makeAction(array $params)
    {
        $input = isset($params[0]) ? $params[0] : "";

        if ($input) {
            echo $this->security->hash($input) . PHP_EOL;
        }
    }
}
