<?php

/**
 * Created by IntelliJ IDEA.
 * User: link
 * Date: 2016-05-23
 * Time: 1:27 PM
 */
class ServiceLocator
{
    private static $services;

    public static function getLoginService() {
        if (!isset(self::$services['LoginService'])) {
            $userDAO = DAOFactory::getUserDAO();
            self::$services['LoginService'] = new LoginServiceImpl($userDAO);
        }
        return self::$services['LoginService'];
    }

}