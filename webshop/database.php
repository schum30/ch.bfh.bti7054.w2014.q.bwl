<?php
class Database{
	private static $dbName = 'bwl';
	private static $dbHost = 'localhost';
	private static $dbUser = 'root';
	private static $dbPass = 'password';
	
	private static $cont = null;
	
	public function __construct() {
		die('Init function is not allowed');
	}
	
	public static function connect(){
		// One connection through whole application
		if ( null == self::$cont ){     
			try{
				self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUser, self::$dbPass); 
			}
			catch(PDOException $e){
				error_log("ERROR: could not reach database", 0);
			}
		}
		return self::$cont;
	}
	
	public static function disconnect(){
		self::$cont = null;
	}
	
}
?>