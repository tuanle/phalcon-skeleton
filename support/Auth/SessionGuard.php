<?php

namespace Support\Auth;

use Phalcon\DiInterface;
use Phalcon\Di\InjectionAwareInterface;
use Phalcon\Config;
use Support\Auth\Contracts\Guard as GuardContract;
use Support\Auth\Contracts\UserProvider as UserProviderContract;
use Support\Auth\Contracts\User as UserContract;
use Support\Auth\ModelUserProvider;

class SessionGuard implements GuardContract, InjectionAwareInterface
{
    /**
     * @var DiInterface
     */
    protected $di;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var string
     */
    protected $guardName;

    /**
     * Build new guard instance
     */
    public function __construct(Config $config, string $guardName)
    {
        $this->guardName = $guardName;
        $this->config = $config;
    }

    /**
     * Get the unique name of guard in application
     *
     * @return string
     */
    public function guardName()
    {
        return $this->guardName;
    }

    /**
     * Get the guard name
     *
     * @return string
     */
    public function sessionName()
    {
        return 'login_' . $this->config->provider . '_' . sha1(static::class);
    }

    /**
     * Get currently logged in user
     *
     * @return UserContract
     */
    public function user()
    {
        if (!empty($this->user)) {
            return $this->user;
        }

        if (!($id = $this->getDi()->getSession()->get($this->sessionName()))) {
            return null;
        }

        if (!($user = $this->getUserProvider()->retrieveById($id))) {
            return null;
        }

        return $this->user = $user;
    }

    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param array $credentials
     * @return bool
     */
    public function attempt(array $credentials = [])
    {
        if (!($user = $this->getUserProvider()->retrieveByCredentials($credentials))) {
            return false;
        }

        if ($this->getDi()->getSecurity()->checkHash($credentials['password'], $user->getAuthPassword())) {
            $this->login($user);

            return true;
        }

        return false;
    }

    /**
     * Log a user into the application.
     *
     * @param UserContract $user
     * @return void
     */
    public function login(UserContract $user)
    {
        // Set current user
        $this->user = $user;

        // Write session
        $this->getDi()->getSession()->set($this->sessionName(), $user->getAuthIdentifier());
    }

    /**
     * Log a user out the application.
     *
     * @return void
     */
    public function logout()
    {
        $this->user = null;
        $this->getDi()->getSession()->remove($this->sessionName());
        $this->getDi()->getSession()->destroy();
    }

    /**
     * Get the provider for user base on the configuration
     *
     * @return UserProviderContract
     */
    public function getUserProvider()
    {
        $provider = config("auth.providers.{$this->config->provider}");

        switch ($provider->driver)
        {
            case 'model':
                return new ModelUserProvider($provider);
            default:
                throw new \Phalcon\Exception("UserProvider [$provider->driver] is not defined.");
        }
    }

    /**
     * implements InjectionAwareInterface
     */
    public function setDi(DiInterface $di)
    {
        $this->di = $di;
    }

    public function getDi()
    {
        return $this->di;
    }
}
