<?php

namespace Support\Auth\Contracts;

use Support\Auth\Contracts\User as UserContract;

interface UserProvider
{
    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed $identifier
     * @return UserContract|null|false
     */
    public function retrieveById($identifier);

    /**
     * Retrieve a user by the given credentials.
     *
     * @param array $credentials
     * @return UserContract|null|false
     */
    public function retrieveByCredentials(array $credentials);
}
