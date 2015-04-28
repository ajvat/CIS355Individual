<?php
// filename: database.php, Anthony Vatter, cis355, 2015-04-26
// establishes the database connection
class Database
{
    private static $dbName = 'CIS355ajvatter';
    private static $dbHost = 'localhost';
    private static $dbUsername = 'CIS355ajvatter';
    private static $dbUserPassword = 'captainlokie5';
     
    private static $cont  = null;
     
    public function __construct() {
        die('Init function is not allowed');
    }
     
    public static function connect()
    {
       // One connection through whole application
       if ( null == self::$cont )
       {     
        try
        {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword); 
        }
        catch(PDOException $e)
        {
          die($e->getMessage()); 
        }
       }
       return self::$cont;
    }
     
    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>