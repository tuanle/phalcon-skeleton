<?php

namespace Support\Http\Concerns;

trait InteractsWithMiddleware
{
    /**
     * @var array
     */
    protected $beforeMiddlewares = [];

    /**
     * @var array
     */
    protected $afterMiddlewares = [];

    /**
     * Set or add before-middleware
     *
     * @param mixed $middlewares
     * @return void
     */
    protected function setBeforeMiddlewares($middlewares)
    {
        if (is_array($middlewares)) {
            foreach ($middlewares as $middleware => $params) {
                $this->beforeMiddlewares[$middleware] = $params;
            }
        }

        if (is_string($middlewares)) {
            $this->beforeMiddlewares[$middlewares] = [];
        }
    }

    /**
     * Set or add after-middleware
     *
     * @param mixed $middlewares
     * @return void
     */
    protected function setAfterMiddlewares($middlewares)
    {
        if (is_array($middlewares)) {
            foreach ($middlewares as $middleware => $params) {
                $this->afterMiddlewares[$middleware] = $params;
            }
        }

        if (is_string($middlewares)) {
            $this->afterMiddlewares[$middlewares] = [];
        }
    }

    /**
     * Get before-middlewares
     *
     * @return array
     */
    public function getBeforeMiddlewares()
    {
        return $this->beforeMiddlewares;
    }

    /**
     * Get after-middlewares
     *
     * @return array
     */
    public function getAfterMiddlewares()
    {
        return $this->afterMiddlewares;
    }
}
