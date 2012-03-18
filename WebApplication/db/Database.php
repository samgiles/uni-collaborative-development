<?php
/**
 * The Database object that enables SQL operations to be executed on a database from a singleton object.
 * @package database
 */
class Database {
	
	/**
	 * The PDO that is being used to connect to the database.
	 * @var PDO
	 */
	protected $_dbHandle;
     
	/**
	 * Static reference to the Database class, this is used to form the singleton object.
	 * @var Database
	 */
	protected static $_this;
     
	/**
	 * Gets a handle to the database connection.
	 * @returns PDO The PDO for the database connection.
	 */
	public static function GetHandle(){
		if (is_null(Database::$_this)){
	 		Database::$_this = new Database('@DBHOST', '@DBNAME', '@DBUNAME', '@DBPWORD');
	 	}
	 	
	 	return Database::$_this->_dbHandle;
	 }
	 
	 /**
	  * Constructs a new MySQL Database object.
	  * @param string $dbhost  The database host address
	  * @param string $dbname  The database name.
	  * @param string $uname   The database connectors user name.
	  * @param string $password The database connectors password.
	  * TODO Remove the tight coupling to the mysql implementation/dsn
	  */
	 private function __construct($dbhost, $dbname, $uname, $password){
	 	$this->_dbHandle = new PDO("mysql:host={$dbhost};dbname={$dbname}", $uname, $password);
	 }
	 
	 /**
	  * Allows an SQL statement to be executed on the database.
	  * @example DatabaseExample.php Example usage for SELECT statement.
	  * @param string $sqlStatement The SQL statement to execute.
	  * @returns PDOStatement
	  */
	 public static function execute($sqlStatement) {
	 	$pdoStatement = Database::GetHandle()->prepare($sqlStatement);
	 	$pdoStatement->execute();
	 	return $pdoStatement;
	 }
}