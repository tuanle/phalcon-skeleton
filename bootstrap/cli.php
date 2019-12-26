<?php

use Phalcon\Cli\Console;
use Phalcon\Di\FactoryDefault\Cli as CliDI;

class CliApplication extends AbstractApplication
{
    /**
     * @var array
     */
    protected $arguments;

    /**
     * Initializes the main application
     */
    protected function initApplication()
    {
        $this->application = new Console($this->di);
        $this->di->setShared('console', $this->application);

        $this->registerProviders();

        $this->extractArguments();
    }

    protected function initDi()
    {
        $this->di = new CliDI();
        $this->di->set('config', $this->config);

        CliDI::setDefault($this->di);
    }

    /**
     * Registers application's providers
     */
    protected function registerProviders()
    {
        $providers = config('app.cli_providers');

        foreach ($providers as $provider) {
            $this->di->register(new $provider);
        }
    }

    /**
     * Process the console arguments
     */
    protected function extractArguments()
    {
        $this->arguments = [];

        if (true === isset($_SERVER['argv']))
        {
            foreach ($_SERVER['argv'] as $index => $argument)
            {
                if ($index === 1) {
                    $this->arguments['task'] = $argument;
                } elseif ($index === 2) {
                    $this->arguments['action'] = $argument;
                } elseif ($index >= 3) {
                    $this->arguments['params'][] = $argument;
                }
            }
        }
    }

    /**
     * Runs the main application
     */
    protected function runApplication()
    {
        try {
            // Handle incoming arguments
            $this->application->handle($this->arguments);
        } catch (\Phalcon\Exception $e) {
            fwrite(STDERR, $e->getMessage() . PHP_EOL);
            exit(1);
        } catch (\Throwable $throwable) {
            fwrite(STDERR, $throwable->getMessage() . PHP_EOL);
            exit(1);
        } catch (\Exception $exception) {
            fwrite(STDERR, $exception->getMessage() . PHP_EOL);
            exit(1);
        }
    }
}
