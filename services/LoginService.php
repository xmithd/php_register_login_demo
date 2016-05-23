<?php

interface LoginService
{
    /**
     * @param string $email The email given
     * @param string $password The given password
     * @return false if username/password don't match, otherwise an authentication token
     */
    function validateUsernamePassword(string $email, string $password);
    
    function createUser(string $email, string $display_name, string $pwd);
}