<?php
    // namespace App\classes;

    class DataBase {
        private static $pilote = 'mysql';
        private static $host = 'localhost';
        private static $dbname = 'mabagnole';
        private static $username = 'root';
        private static $password = '';

        private function __construct(){}

        static function getPilote(){
            return self::$pilote;
        }

        static function setPilote($pilote){
            if($pilote && $pilote!='')
                self::$pilote = $pilote;
        }

        static function getHost(){
            return self::$host;
        }

        static function setHost($host){
            if($host && $host!='')
                self::$host = $host;
        }

        static function getDbName(){
            return self::$dbname;
        }

        static function setDbName($dbname){
            if($dbname && $dbname!='')
                self::$dbname = $dbname;
        }

        static function setUserName($username){
            if($username && $username!='')
                self::$username = $username;
        }

        static function setPassword($password){
            if($password)
                self::$password = $password;
        }

        // Data Source Name
        static function getDSN(){
            return self::getPilote().':host='.self::getHost().';dbname='.self::getDbName();
        }
        
        static function getPDO(){
            return new PDO(self::getDSN(), self::$username, self::$password);
        }
    }
?>