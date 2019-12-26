<?php

namespace Support\Auth\Contracts;

use Support\Auth\Contracts\UserProvider as UserProviderContract;
use Support\Auth\Contracts\User as UserContract;

interface Guard
{
    /**
     * Get the unique name of guard in application
     *
     * @return string
     */
    public function guardName();

    /**
     * Get the guard name
     *
     * @return string
     */
    public function sessionName();

    /**
     * Get currently logged in user
     *
     * @return UserContract
     */
    public function user();

    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param array $credentials
     * @return bool
     */
    public function attempt(array $credentials = []);

    /**
     * Log a user into the application.
     *
     * @param UserContract $user
     * @return void
     */
    public function login(UserContract $user);

    /**
     * Log a user out the application.
     *
     * @return void
     */
    public function logout();

    /**
     * Get the provider for user base on the configuration
     *
     * @return UserProviderContract
     */
    public function getUserProvider();
}
