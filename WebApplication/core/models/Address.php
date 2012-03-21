<?php
/**
 * Represents an Address
 * @author Samuel Giles
 * @package application-models
 */
class Address {
	
	private $_logger;
	
	private $_code; // PK
	private $_lineone;
	private $_linetwo;
	private $_postcode;
	
	public function __construct() {
		$this->_logger = Logger::GetLogger();
		$this->_code = null;
	}
	
	public function setLineone($lineone) {
		$this->_lineone = $lineone;
	}
	
	public function setLinetwo($linetwo) {
		$this->_linetwo = $linetwo;
	}
	
	public function setPostcode($postcode) {
		$this->_postcode = $postcode;
	}
	
	public function getCode() {
		return $this->_code;
	}
	
	public function getLineOne() {
		return $this->_lineone;
	}
	
	public function getLineTwo() {
		return $this->_linetwo;
	}
	
	public function getPostcode() {
		return $this->_postcode;
	}
	
	public static function getAddressByPostcode($postcode) {
		
		$pdostatement = Database::execute('SELECT * FROM ADDRESS WHERE POST_CODE = ' . $postcode);
		
		if ($pdostatement == false) {
			$this->_logger->logController("Address::getAddressByPostCode($postcode) returned false.", 'Model::Address', 'Model - STATIC');
			throw new Exception("Query failed to execute correctly.");
		}
		
		$address = array();
		
		$row = $pdostatement->fetch(PDO::FETCH_ASSOC);
    	do {
      		$address[] = Address::createFromArray($row);
    	} while ($row = $pdostatement->fetch(PDO::FETCH_NUM));
		
    	if (count($address) === 1) {
    		return $address[0];
    	}
    	
		return $address;
	}
	
	public static function getAddressByCode($code) {
		
		$pdostatement = Database::execute('SELECT * FROM ADDRESS WHERE CODE = ' . $code);
		
		if ($pdostatement == false) {
			$this->_logger->logController("Address::getAddressByCode($code) returned false.", 'Model::Address', 'Address - STATIC');
			throw new Exception("Query failed to execute correctly.");
		}
		
		// Fetch one row into an associative array.
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		
		return Address::createFromArray($result);
	}
	
	public static function createFromArray(array $array) {
		$address = new Address();
		$address->_code = $array['CODE'];
		$address->_lineone = $array['LINE_ONE'];
		$address->_linetwo = $array['LINE_TWO'];
		$address->_postcode = $array['POST_CODE'];
		return $address;
	}
}