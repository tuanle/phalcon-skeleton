<?php

namespace App\Cli\Tasks;

use Phalcon\Cli\Task;

class MainTask extends Task
{
    /**
     * Defines avaiable commands
     *
     * @var array
     */
    protected $commands = [
        'ExampleTask: Some examples about using task.' => [
            'php phalcon example' => 'This is an example task using main action',
            'php phalcon example testAction' => 'This is an example task using another action without parameters',
            'php phalcon example testParams 1 2 3' => 'This is an example task using another action with parameters',
        ],
        'HashTask: Task helps about hasing.' => [
            'php phalcon hash make example_string' => 'Make the hash string from "example_string" (generating password)',
        ],
    ];

    /**
     * This provides the main menu of commands if an command is not entered
     */
    public function mainAction()
    {
        echo 'Usage:' . PHP_EOL;
        echo '  php phalcon <command> <action> <parameters>' . PHP_EOL . PHP_EOL;

        echo 'Available commands:' . PHP_EOL;

        foreach ($this->commands as $task => $taskCommands) {
            list($taskName, $taskDescription) = explode(':', $task);
            echo PHP_EOL . sprintf('%-48s:%s', $taskName, $taskDescription) . PHP_EOL;
            foreach ($taskCommands as $command => $description) {
                echo sprintf('  %-46s: %s', $command, $description) . PHP_EOL;
            }
            echo PHP_EOL;
        }
    }
}
