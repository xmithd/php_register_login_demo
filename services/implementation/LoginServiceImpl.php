<?php

require_once '../LoginService.php';
require_once '../../entities/UserEntity.php';
/**
 * Default implementation of the Login
 */
class LoginServiceImpl implements LoginService
{
   
    // TODO SESSION HANDLING
    private $userDAO;

    function __construct(UserDAO $userDAO)
    {
        $this->userDAO = $userDAO;
    }

    function validateUsernamePassword(string $email, string $password)
    {
        $res = $this->userDAO->getUserByEmail($email);
        if ($res && password_verify($password, $res['hashed_pwd'])) {
            return '3e424157a615b6a6912a9a510f0c3ef2045ebb77996a7018687a21d225fed1a4';
        } else {
            return false;
        }
    }

    function createUser(string $email, string $display_name, string $pwd)
    {
        $user = new UserEntity();
        $user->setDisplayName($display_name);
        $user->setEmail($email);
        $this->userDAO->saveUser($user, password_hash($pwd, PASSWORD_BCRYPT));
    }
}