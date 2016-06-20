<?php
ini_set('display_errors', 1);// For errors to be printed on screen for user or not
ini_set('display_startup_errors', 1);// For php start up errors during debugging
error_reporting(E_ALL);

class DBConnection{
	public static $dbConn = "";
	public static function createDbConn(){
		$host = 'localhost';
		$uName = 'root';
		$password = 'mindfire';
		$database = 'RestaurantDatabase2';

		self::$dbConn = new mysqli($host, $uName, $password, $database);

		if (self::$dbConn->connect_error) {
			die('Failed to connect to MySQL' .self::$dbConn->connect_error());
		}
		else{
			echo "connected to database";
		}
		return self::$dbConn;
	}

	public static function getDbConn(){
		if ("" == self::$dbConn) {
			echo 'New Connection';
			$connection = self::createDbConn();
		}
		else{	
			echo 'Connection Exist';
			$connection = self::$dbConn;
		}
		return $connection;
	}
}
$conn = DBConnection::getDbConn();
?>

