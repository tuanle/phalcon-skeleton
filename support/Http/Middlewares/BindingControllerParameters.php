<?php

namespace Support\Http\Middlewares;

use \ReflectionMethod;
use \ReflectionParameter;
use Phalcon\Mvc\Dispatcher;
use Support\Http\Contracts\Middleware;
use Support\Exceptions\UnauthorizedException;
use Support\Exceptions\ValidationException;
use Support\Exceptions\ModelNotFoundException;

class BindingControllerParameters implements Middleware
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * Constructor
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handles the binding
     *
     * @param array $params
     */
    public function handle(array $params = [])
    {
        $this->parameters = $this->dispatcher->getParams();

        $reflection = new ReflectionMethod($this->dispatcher->getControllerClass(), $this->dispatcher->getActiveMethod());
        $possibleParameters = $reflection->getParameters();

        foreach ($possibleParameters as $parameter) {
            $this->tryToBindParameter($parameter);
        }

        // Set the final parameters to dispatcher
        $this->dispatcher->setParams($this->parameters);
    }

    /**
     * Try to bind parameter to controller
     * If the parameter is raw value or isn't the class, we will do nothing
     *
     * @return void
     */
    protected function tryToBindParameter(ReflectionParameter $parameter)
    {
        if (
            ! method_exists($parameter, 'getClass')
            ||
            !$parameter->getClass()
            ||
            ! ($className = $parameter->getClass()->name)
        ) {
            return;
        }

        if (is_subclass_of($className, \App\Http\Requests\Request::class)) { // If the parameter is a request
            $this->bindRequest($parameter, $className);
        }

        if (is_subclass_of($className, \App\Models\Model::class)) { // If the parameter is a model
            $this->bindModel($parameter, $className);
        }
    }

    /**
     * Process and bind the request
     *
     * @param string $className
     * @return void
     */
    protected function bindRequest(\ReflectionParameter $parameter, string $className)
    {
        // Instances the request
        $request = new $className;
        $request->setDI($this->dispatcher->getDI());

        if (! $request->authorized()) {
            throw new UnauthorizedException;
        }

        if (! $request->isValid() && $request->autoRedirect()) {
            throw new ValidationException($request);
        }

        // Change the global request instance definition
        $this->dispatcher->getDI()->getService('request')->setDefinition($request);

        // Binding
        $this->parameters[$parameter->name] = $request;
    }

    /**
     * Process and bind the request
     *
     * @param string $className
     * @return void
     */
    protected function bindModel(\ReflectionParameter $parameter, string $className)
    {
        // Get the identifier from the origin parameter
        if (! ($identifier = $this->parameters[$parameter->name] ?? null)) {
            return;
        }

        $model = $className::findFirst([
            'id = :id: AND deleted_at IS NULL',
            'bind' => ['id' => $identifier]
        ]);

        if (! $model) {
            throw new ModelNotFoundException;
        }

        // Binding
        $this->parameters[$parameter->name] = $model;
    }
}
