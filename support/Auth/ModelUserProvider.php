<?php

namespace Support\Auth;

use Phalcon\Config;
use Support\Auth\Contracts\UserProvider as UserProviderContract;
use Support\Auth\Contracts\User as UserContract;

class ModelUserProvider implements UserProviderContract
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * Create new UserProvider for driver "model"
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  string $identifier
     * @return UserContract $user
     */
    public function retrieveById($identifier)
    {
        $model = $this->createModel();
        return $model->findFirstById($identifier);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param array $credentials
     * @return UserContract|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials)
            ||
            (count($credentials) === 1 && array_key_exists('password', $credentials))
        ) {
            return null;
        }

        $query = $this->createModel()->query();
        $bindings = [];

        foreach ($credentials as $key => $value) {
            if ($key != 'password') {
                $query->where("{$key} = :{$key}:");
                $bindings[$key] = $value;
            }
        }

        $query->bind($bindings);

        return $query->execute()->getFirst();
    }

    /**
     * Create a new instance of the model.
     *
     * @return \Phalcon\Mvc\Model
     */
    public function createModel()
    {
        $class = $this->config->model;

        return new $class;
    }
}
