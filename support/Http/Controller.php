<?php

namespace Support\Http;

use Phalcon\Mvc\Controller as PhalconMvcController;
use Support\Http\Concerns\InteractsWithMiddleware;

class Controller extends PhalconMvcController
{
    use InteractsWithMiddleware;

    protected function onConstruct()
    {
        // This function is used for replacing __construct()
    }

    /**
     * Quick setup the view
     *
     * @param string $template
     * @param array $vars
     * @return void
     */
    protected function view(string $template, array $vars = [])
    {
        foreach ($vars as $name => $var) {
            $this->view->setVar($name, $var);
        }

        $this->view->pick($template);
    }
}
