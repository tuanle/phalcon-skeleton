<?php

namespace Support\Providers;

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;
use Support\View\Helper;

class ViewServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers the service
     */
    public function register(DiInterface $di)
    {
        $di->set('viewHelper', new Helper);

        $di->setShared('view', function () {
            $view = new View();

            $view->disableLevel([
                View::LEVEL_LAYOUT => true,
                View::LEVEL_MAIN_LAYOUT => true,
            ]);

            $view->setViewsDir(config('app.view.view_directory'));

            $view->registerEngines([
                '.volt' => function($view, $di)
                {
                    $volt = new Volt($view, $di);

                    $volt->setOptions([
                        'autoescape' => config('app.view.autoescape'),
                        'compiledPath' => config('app.view.compiled_path'),
                        'compiledSeparator' => config('app.view.compiled_separator'),
                        'compileAlways' => config('app.debug') ? true : false,
                    ]);

                    $volt->getCompiler()->addExtension($di->getViewHelper());

                    return $volt;
                }
            ]);

            return $view;
        });
    }
}
