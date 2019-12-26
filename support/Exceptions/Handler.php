<?php

namespace Support\Exceptions;

use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatcherException;
use Support\Exceptions\InvalidCsrfTokenException;
use Support\Exceptions\AuthenticationException;
use Support\Exceptions\ValidationException;
use Support\Exceptions\NotFoundException;
use Support\Exceptions\ModelNotFoundException;

class Handler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * Triggered before the dispatcher throws any exception
     *
     * @param \Phalcon\Events\Event $event
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     * @param \Exception $exception
     */
    public function beforeException(Event $event, Dispatcher $dispatcher, \Exception $exception)
    {
        dd($exception);
        // Reports
        $this->report($dispatcher, $exception);

        // Handles
        return $this->handle($dispatcher, $exception);
    }

    /**
     * Reports the exception, for example, write to log
     *
     * @param Dispatcher $dispatcher
     * @param \Exception $exception
     * @return void
     */
    protected function report(Dispatcher $dispatcher, \Exception $exception)
    {
        foreach ($this->dontReport as $dontReportExceptionType) {
            if ($exception instanceof $dontReportExceptionType) {
                return true;
            }
        }

        $dispatcher->getDI()->getLog()->log($this->formatMessage($exception));
    }

    /**
     * Handle the exception, for example, redirect to 404 error page
     *
     * @param Dispatcher $dispatcher
     * @param \Exception $exception
     * @return mixed
     */
    protected function handle(Dispatcher $dispatcher, \Exception $exception)
    {
        if ($exception instanceof InvalidCsrfTokenException) {
            return $this->csrfTokenException($dispatcher, $exception);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($dispatcher, $exception);
        }

        if ($exception instanceof ValidationException) {
            return $this->invalid($dispatcher, $exception);
        }

        if ($exception instanceof NotFoundException) {
            return $this->notFound($dispatcher, $exception);
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->notFound($dispatcher, $exception);
        }

        if ($exception instanceof DispatcherException) {
            if (
                $exception->getCode() == Dispatcher::EXCEPTION_HANDLER_NOT_FOUND
                ||
                $exception->getCode() == Dispatcher::EXCEPTION_ACTION_NOT_FOUND
            ) {
                return $this->notFound($dispatcher, $exception);
            }
        }

        return $this->serverError($dispatcher, $exception);
    }

    /**
     * Handles when the request csrf token is invalid
     *
     * @param Dispatcher $dispatcher
     * @param InvalidCsrfTokenException $exception
     * @throws InvalidCsrfTokenException
     */
    protected function csrfTokenException(Dispatcher $dispatcher, InvalidCsrfTokenException $exception)
    {
        throw $exception;
    }

    /**
     * Handles when the request is unauthenticated
     *
     * @param Dispatcher $dispatcher
     * @param AuthenticationException $exception
     * @throws AuthenticationException
     */
    protected function unauthenticated(Dispatcher $dispatcher, AuthenticationException $exception)
    {
        throw $exception;
    }

    /**
     * Handles when the request data is not valid
     *
     * @param Dispatcher $dispatcher
     * @param ValidationException $exception
     * @throws ValidationException
     */
    protected function invalid(Dispatcher $dispatcher, ValidationException $exception)
    {
        throw $exception;
    }

    /**
     * Handles when the router can't found any route that matches with the request
     * or when the database query gets no results
     *
     * @param Dispatcher $dispatcher
     * @param ModelNotFoundException|NotFoundException|DispatcherException $exception
     * @throws ModelNotFoundException|NotFoundException|DispatcherException
     */
    protected function notFound(Dispatcher $dispatcher, \Exception $exception)
    {
        throw $exception;
    }

    /**
     * Handles when the server is broken or returns unknown error
     *
     * @param Dispatcher $dispatcher
     * @param \Exception $exception
     * @throws \Exception
     */
    protected function serverError(Dispatcher $dispatcher, \Exception $exception)
    {
        throw $exception;
    }


    /**
     * Format the exception's message to get more details
     *
     * @param DispatcherException $exception
     * @return string
     */
    protected function formatMessage(\Exception $exception)
    {
        return sprintf("%s: %s", get_class($exception), $exception->getMessage())
            . PHP_EOL
            . sprintf("File: %s (line: %s)", $exception->getFile(), $exception->getLine())
            . PHP_EOL
            . "Trace:"
            . PHP_EOL
            . $exception->getTraceAsString()
            . PHP_EOL;
    }
}
