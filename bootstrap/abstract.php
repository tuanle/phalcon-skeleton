<?php

use Phalcon\Di;
use Phalcon\Config;
use Dotenv\Dotenv;

abstract class AbstractApplication
{
    /**
     * @var \Phalcon\Cli\Console|\Phalcon\Mvc\Micro|\Phalcon\Mvc\Application
     */
    protected $application;

    /**
     * @var PhalconDi;
     */
    protected $di;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var array
     */
    protected $configurationPaths = [
        'app' => 'config/app.php',
    ];

    /**
     * Runs the application
     *
     * @return mixed
     */
    public function run()
    {
        $this->initLoader();
        $this->initEnvironment();
        $this->initConfigs();
        $this->initDi();
        $this->initApplication();

        // Runs
        $this->runApplication();
    }

    /**
     * Initializes the autoloader
     */
    protected function initLoader()
    {
        // Use the composer autoloader
        require_once BASE_PATH . '/vendor/autoload.php';
    }

    /**
     * Initializes the environment
     */
    protected function initEnvironment()
    {
        // Use application .env file
        Dotenv::create(BASE_PATH)->load();
    }

    /**
     * Initializes the configurations
     */
    protected function initConfigs()
    {
        $configurations = [];

        foreach ($this->configurationPaths as $key => $path) {
            $configurations[$key] = require BASE_PATH . '/' . $path;
        }

        $this->config = new Config($configurations);
    }

    protected function initDi()
    {
        $this->di = new Di();
        $this->di->set('config', $this->config);

        Di::setDefault($this->di);
    }

    abstract protected function initApplication();
    abstract protected function runApplication();
}
