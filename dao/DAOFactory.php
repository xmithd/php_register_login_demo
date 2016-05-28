<?php
require_once __DIR__.'/implementation/UserDAOImpl.php';
/**
 * DAOFactory creates DAO instances.
 * It contains the database connection (PDO) object as well.
 * OK for a single database on the same machine
 * All static methods for now.
 */
class DAOFactory
{
    private static $conn; 

    public static function getPDO() {
        if (!isset(self::$conn)) {
            //TODO get db info from external file (externalize config)
            self::$conn = new PDO('mysql:host=localhost;dbname=authentapp', 'authentapp','authentapp');
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn->setAttribute(PDO::ATTR_TIMEOUT, 30);
        }
        return self::$conn;
    }

    /**
     * @return UserDAO an instance that can be used right away
     */
    public static function getUserDAO() {
        return new UserDAOImpl(self::getPDO());
    }

}