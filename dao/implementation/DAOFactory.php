<?php

use \PDO;
/**
 * DAOFactory creates DAO instances.
 * It contains the database connection object as well.
 *
 */
class DAOFactory
{
    private static $conn; 

    public static function getPDO() {
        if (!isset(self::$conn)) {
            self::$conn = new PDO('mysql:host=localhost;dbname=pdo_example', 'authentapp','authentapp');
        }
        return self::$conn;
    }
    
    public static function getUserDAO() {
        return new UserDAOImpl(self::$conn);
    }

}