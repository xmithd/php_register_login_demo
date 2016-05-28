<?php

interface LoginService
{
    /**
     * @param string $email The email given
     * @param string $password The given password
     * @return false if username/password don't match, otherwise an authentication token
     */
    function validateUsernamePassword(string $email, string $password);

    /**
     * @param string $email the username's email (must be unique)
     * @param string $display_name (the display name)
     * @param string $pwd (the raw password [it should be hashed in the implementation before storage]
     * @return UserEntity An instance corresponding to this user.
     */
    function createUser(string $email, string $display_name, string $pwd);
}