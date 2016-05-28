<?php

require_once __DIR__.'/../dao/UserDAO.php';
require_once __DIR__.'/../dao/DAOFactory.php';
require_once __DIR__.'/../services/implementation/LoginServiceImpl.php';
/**
 * Service Locator
 * static for now.
 * Looks kinda 'ugly'. 
 * TODO Perhaps a container for DI would be a better idea.
 */
class ServiceLocator
{
    private static $services;

    /**
     * @return LoginService A ready to use LoginService implementation
     */
    public static function getLoginService() {
        if (!isset(self::$services['LoginService'])) {
            $userDAO = DAOFactory::getUserDAO();
            self::$services['LoginService'] = new LoginServiceImpl($userDAO);
        }
        return self::$services['LoginService'];
    }

}