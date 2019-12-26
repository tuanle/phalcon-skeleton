<?php

namespace Support\Auth\Contracts;

interface User
{
    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName();

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier();

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword();
}
