<?php
/**
 * An implementation of the session writer that writes the session data to a PDO data source.
 * @author Samuel Giles
 * @package application-core
 * @subpackage application-core-sessions
 */
class PDOSessionWriter extends SessionWriter {
	
  	/**
  	 * The PDO object used to connect to the database.
  	 * @var PDO
  	 */
  	private $_pdoObject;
  	
  	/**
  	 * The PDO statement for reading the datasource.
  	 * @var PDOStatement
  	 */
 	private $_pdoReadStatement = NULL;
 	
 	/**
 	 * The PDO statement used for writing the datasource
 	 * @var PDOStatement
 	 */
  	private $_pdoWriteStatement = NULL;
  	
  	/**
  	 * The PDO statement used for deleting from the datasource.
  	 * @var PDOStatement 
  	 */
 	private $_pdoDeleteStatement = NULL;
  
 	/**
 	 * Determines whether we're in the database yet or not.
 	 * @var boolean
 	 */
  	private $_inDatabase = false;
  
  	/**
  	 * Creates a new PDOSessionWriter with the given PDO object.
  	 * @param PDO $pdoObject
  	 */
 	public function __construct(PDO $pdoObject) {
    	$this->_pdoObject = $pdoObject;
    	$this->_pdoReadStatement = NULL;
    	$this->_pdoWriteStatement = NULL;
    	$this->_pdoDeleteStatement = null;
  	}

  	/**
  	 * (non-PHPdoc)
  	 * @see SessionWriter::read()
  	 */
  	public function read($hash) {
   	  	if ($this->_pdoReadStatement === NULL || !isset($this->_pdoReadStatement)) {
  	  		$this->_pdoReadStatement = $this->_pdoObject->prepare("SELECT `SESSION`.`VALUE` FROM `SESSION` WHERE `SESSION`.`KEY`=:hash LIMIT 1;");
  		}
    	$this->_pdoReadStatement->bindValue(':hash', $hash, PDO::PARAM_STR);
    	$this->_pdoReadStatement->execute();
    	$row = $this->_pdoReadStatement->fetch(PDO::FETCH_ASSOC);
    
    	// Below we're setting a flag so we know whether to make an INSERT or UPDATE SQL statement when we write the session back in.
   	 	if (!$row) {
      		$this->_inDatabase = false;
      		return NULL;
    	}
    
    	$this->_inDatabase = true;
    	$object = unserialize($row['VALUE']);
    	return $object;
 	}
	
 	/**
 	 * (non-PHPdoc)
 	 * @see SessionWriter::write()
 	 */
  	public function write($hash, $sessionObject) {
   	 	if ($this->_pdoWriteStatement === NULL) {
      		if ($this->_inDatabase) {
        		$this->_pdoWriteStatement = $this->_pdoObject->prepare("UPDATE `SESSION` `SESSION`.VALUE`=:object WHERE `SESSION`.`KEY`=:hash");
      		} else {
        		$this->_pdoWriteStatement = $this->_pdoObject->prepare("INSERT INTO SESSION VALUES (:hash, :object)");
      		}
    	}
    
    	$this->_pdoWriteStatement->bindValue(':hash', $hash, PDO::PARAM_STR);
    
    	$object = serialize($sessionObject);
    	$this->_pdoWriteStatement->bindValue(':object', $object, PDO::PARAM_LOB);
    
    	$this->_pdoWriteStatement->execute();
    	$this->_inDatabase = true;
    
    	return true; // Tidy up return interfaces.. We dont NEED to return anything but should probably tidy them up.
  	}
  
  	/**
  	 * (non-PHPdoc)
  	 * @see SessionWriter::clear()
  	 */
  	public function clear($hash) {
    	if ($this->_pdoDeleteStatement === NULL) {
      		$this->_pdoDeleteStatement = $this->_pdoObject->prepare("DELETE FROM `SESSION` WHERE `SESSION`.`KEY`=:hash");
    	}
    
    	if ($this->_inDatabase) {
      		$this->_pdoDeleteStatement->bindValue(':hash', $hash, PDO::PARAM_STR);
      		$this->_pdoDeleteStatement->execute();
      		return true;
    	} else {
      		return false;
    	}
  	}
}