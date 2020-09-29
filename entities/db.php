<?php

class DB {
    //put your code here
    private static $db = null;

    // Konstruktor privat machen, damit er nicht aufgerufen werden kann
    private function __construct() {
        ;
    }

    public static function getDB() {

       if (self::$db == NULL){
        try{
            require_once "../entities/variables.ini.php";
         self::$db = new PDO('mysql:host='.Variables::$DB_HOST.';dbname='.Variables::$DB_NAME.';charset=UTF8',Variables::$DB_USER,Variables::$DB_PASSWORD);
         self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e){
            echo $e->getMessage();
        }
       }
       return self::$db;
    }
}

?>
