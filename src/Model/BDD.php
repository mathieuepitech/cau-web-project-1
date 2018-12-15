<?php

namespace WebProjectFitness\Model;

use Exception;
use PDO;

class BDD {
    const SQL_SERVER = 'web3.pulseheberg.net';  // BDD Server
    const SQL_LOGIN = 'why7n0_fitness';         // BDD Login
    const SQL_PASSWORD = 'KpB728zu';            // BDD Password
    const SQL_DB = 'why7n0_fitness';            // BDD Name

//    const SQL_SERVER = 'localhost'; // BDD Server
//    const SQL_LOGIN = 'root';       // BDD Login
//    const SQL_PASSWORD = '';        // BDD Password
//    const SQL_DB = 'fitness';       // BDD Name

    private static $bdd;

    public function __construct() {
        try {
            $pdo_options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];

            self::$bdd = new PDO( 'mysql:host=' . self::SQL_SERVER . ';dbname=' . self::SQL_DB . ';charset=utf8',
                self::SQL_LOGIN, self::SQL_PASSWORD, $pdo_options );
        } catch ( Exception $e ) {
            die( 'Erreur : ' . $e->getMessage() );
        }
    }

    public static function instance() {
        return self::$bdd;
    }

    public static function lastInsertId() {
        return self::$bdd->lastInsertId();
    }
}

?>