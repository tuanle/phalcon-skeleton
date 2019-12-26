<?php

namespace App\Exceptions;

use Phalcon\Mvc\Dispatcher;
use Support\Exceptions\Handler as BaseHandler;
use Support\Exceptions\InvalidCsrfTokenException;
use Support\Exceptions\AuthenticationException;
use Support\Exceptions\ValidationException;
use Support\Exceptions\NotFoundException;
use Support\Exceptions\ModelNotFoundException;

class Handler extends BaseHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
    ];

    /**
     * Handles when the request csrf token is invalid
     *
     * @param Dispatcher $dispatcher
     * @param InvalidCsrfTokenException $exception
     * @return bool
     */
    protected function csrfTokenException(Dispatcher $dispatcher, InvalidCsrfTokenException $exception)
    {
        if (domain() == 'partner') {
            $dispatcher->setNamespaceName('App\Http\Controllers\Partner');
        } else if (domain() == 'tenant') {
            $dispatcher->setNamespaceName('App\Http\Controllers\Tenant');
        } else if (domain() == 'admin') {
            $dispatcher->setNamespaceName('App\Http\Controllers\Admin');
        }

        $dispatcher->forward([
            'controller' => 'errors',
            'action' => 'invalidCsrf'
        ]);

        return false;
    }

    /**
     * Handles when the request is unauthenticated
     *
     * @param Dispatcher $dispatcher
     * @param AuthenticationException $exception
     * @return bool
     */
    protected function unauthenticated(Dispatcher $dispatcher, AuthenticationException $exception)
    {
        switch ($exception->getGuard()->guardName())
        {
            case 'partner':
                $dispatcher->getDI()->getResponse()->redirect(['for' => 'partner.auth.login'])->send();
                return false;
            case 'tenant':
                $dispatcher->getDI()->getResponse()->redirect(['for' => 'tenant.auth.login'])->send();
                return false;
            case 'admin':
                $dispatcher->getDI()->getResponse()->redirect(['for' => 'admin.auth.login'])->send();
                return false;
        }

        return parent::unauthenticated($dispatcher, $exception);
    }

    /**
     * Handles when the request data is not valid
     *
     * @param Dispatcher $dispatcher
     * @param ValidationException $exception
     * @return bool
     */
    protected function invalid(Dispatcher $dispatcher, ValidationException $exception)
    {
        $request = $exception->getRequest();
        $redirectUrl = $request->getRedirectUrl() ?: $request->getHTTPReferer();

        // Set the flash data
        $request->flashInputs();
        $request->flashErrors();

        // Redirect
        $dispatcher->getDI()->getResponse()->redirect($redirectUrl)->send();
        return false;
    }

    /**
     * Handles when the router can't found any route that matches with the request
     * or when the database query gets no results
     *
     * @param Dispatcher $dispatcher
     * @param ModelNotFoundException|NotFoundException|DispatcherException $exception
     * @return bool
     */
    protected function notFound(Dispatcher $dispatcher, \Exception $exception)
    {
        if (config('app.env') === 'local') {
            return parent::notFound($dispatcher, $exception);
        }

        if (domain() == 'partner') {
            $dispatcher->setNamespaceName('App\Http\Controllers\Partner');
        } else if (domain() == 'tenant') {
            $dispatcher->setNamespaceName('App\Http\Controllers\Tenant');
        } else if (domain() == 'admin') {
            $dispatcher->setNamespaceName('App\Http\Controllers\Admin');
        }

        $dispatcher->forward([
            'controller' => 'errors',
            'action' => 'notFound'
        ]);

        return false;
    }

    /**
     * Handles when the server is broken or returns unknown error
     *
     * @param Dispatcher $dispatcher
     * @param \Exception $exception
     * @return bool
     */
    protected function serverError(Dispatcher $dispatcher, \Exception $exception)
    {
        if (config('app.env') === 'local') {
            return parent::serverError($dispatcher, $exception);
        }

        if (domain() == 'partner') {
            $dispatcher->setNamespaceName('App\Http\Controllers\Partner');
        } else if (domain() == 'tenant') {
            $dispatcher->setNamespaceName('App\Http\Controllers\Tenant');
        } else if (domain() == 'admin') {
            $dispatcher->setNamespaceName('App\Http\Controllers\Admin');
        }

        $dispatcher->forward([
            'controller' => 'errors',
            'action' => 'serverError'
        ]);

        return false;
    }
}
