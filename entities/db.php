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
          $vars = parse_ini_file("../entities/variables.ini.php", TRUE);
          $dbvars = $vars["Database"];
         self::$db = new PDO('mysql:host='.$dbvars["host"].';dbname='.$dbvars["name"].';charset=UTF8',$dbvars["user"],$dbvars["password"]);
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
