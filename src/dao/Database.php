<?php
declare(strict_types=1);
namespace pedacode\dao;

use pedacode\dao\DaoException;

class Database {
    private static \PDO $dtb;

    public static function getConnection() : \PDO {
        if (!isset(self::$dtb)) { // erreur gérée dans DaoPedacode.php
            if (file_exists("./param.ini")) {
                $param = parse_ini_file("./param.ini", true);
                extract($param['BDD']);
            } 
            else throw new DaoException("Fichier ou parametre BDD indisponibles", 8001);
            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";
            self::$dtb = new \PDO($dsn, $user, $password);
            self::$dtb->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$dtb;
    }
}