<?php
/**
 * Represents an Address
 * @author Samuel Giles
 * @version 1.0
 * @package application-core
 * @subpackage application-core-models
 */
class Address {
    
	/**
	 * Logging object.
	 * @var Logger
	 */
	private $_logger;

	/**
	 * The primary key code of the address object.
	 * @var unknown_type
	 */
	private $_code; // PK
    
	/**
	 * The Lineone value of the address.
	 * @var unknown_type
	 */
	private $_lineone;
    
	/**
	 * The linetwo value of the address
	 * @var unknown_type
	 */
	private $_linetwo;
    
	/**
	 * The postcode of the address,
	 * @var unknown_type
	 */
	private $_postcode;
	
	/**
	 * Constructs a new Empty Address.
	 */
	public function __construct() {
		$this->_logger = Logger::GetLogger();
		$this->_code = null;
	}
	
	/**
	 * Saves the object, if the object's primary key is undefined, or null, then a row is inserted in the database, if it is defined the value is updated.
	 * @throws Exception
	 */
	public function save() {
		if ($this->_code == null) {
			// INSERT.
			$pdostatement = Database::execute("INSERT INTO ADDRESS (NAME, LINE_ONE, LINE_TWO, POST_CODE) VALUES ('', '{$this->getLineOne()}', '{$this->getLineTwo()}', '{$this->getPostcode()}')");
		
			if ($pdostatement === false) {
				$this->_logger->logController("Address->save(" . print_r($this, true) . ") INSERT returned false.", 'Model::Address', 'Model - INSTANCE');
				throw new Exception("Query failed to execute correctly.");
			}
			
			$pdostatement = Database::execute("SELECT LAST_INSERT_ID() as CODE"); // Get the ID of the last inserted record.
			$row = $pdostatement->fetch(PDO::FETCH_ASSOC);
			$this->_code = $row['CODE'];
		} else {
			// UPDATE
			$pdostatement = Database::execute("UPDATE ADDRESS SET NAME='', LINE_ONE='{$this->getLineOne()}', LINE_TWO='{$this->getLineTwo()}', POST_CODE='{$this->getPostcode()}' WHERE CODE = {$this->getCode()}");
			
			if ($pdostatement === false) {
				$this->_logger->logController("Address->save(" . print_r($this, true) . ") UPDATE returned false.", 'Model::Address', 'Model - INSTANCE');
				throw new Exception("Query failed to execute correctly.");
			}
		}
	}
	
	/**
	 * Set Lineone of the Address.
	 * @param string $lineone
	 */
	public function setLineone($lineone) {
		$this->_lineone = $lineone;
	}
	
	/**
	 * Set line two of the Address
	 * @param string $linetwo
	 */
	public function setLinetwo($linetwo) {
		$this->_linetwo = $linetwo;
	}
	
	/**
	 * Sets the postcode of the address.
	 * @param string $postcode
	 */
	public function setPostcode($postcode) {
		$this->_postcode = $postcode;
	}
	
	/**
	 * Gets the code of the address in the databse, the primary key.
	 */
	public function getCode() {
		return $this->_code;
	}
	
	/**
	 * Gets lineone of the address
	 */
	public function getLineOne() {
		return $this->_lineone;
	}

	/**
	 * Gets line two of the address
	 */
	public function getLineTwo() {
		return $this->_linetwo;
	}
	
	/**
	 * Gets the postcode of the address.
	 */
	public function getPostcode() {
		return $this->_postcode;
	}
	
	/**
	 * Gets an address or a list of addresses identified by the postcode.
	 * @param string $postcode
	 * @throws Exception
	 */
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
	
	/**
	 * Gets an address object by it's primary key.
	 * @param int $code
	 * @throws Exception
	 */
	public static function getAddressByCode($code) {
		
		if ($code instanceof Address) {
			return $code;
		}
		
		$pdostatement = Database::execute('SELECT * FROM ADDRESS WHERE CODE = ' . $code);
		
		if ($pdostatement == false) {
			$this->_logger->logController("Address::getAddressByCode($code) returned false.", 'Model::Address', 'Address - STATIC');
			throw new Exception("Query failed to execute correctly.");
		}
		
		// Fetch one row into an associative array.
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		
		return Address::createFromArray($result);
	}
	
	/**
	 * Creates an address object from a database tuple or an equivalent array.
	 * @param array $array
	 */
	public static function createFromArray(array $array) {
		$address = new Address();
		
	   if (isset($array['CODE'])) {
			$address->_code = $array['CODE'];
		} else {
			$address->_code = null;
		}

		$address->_lineone = $array['LINE_ONE'];
		$address->_linetwo = $array['LINE_TWO'];
		$address->_postcode = $array['POST_CODE'];
		return $address;
	}
}
