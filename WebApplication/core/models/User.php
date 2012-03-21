<?php
/**
 * Stores information about a system user.
 * @author Samuel Giles
 * @package application-models
 */
class User {
	
	private $_logger;
	
	private $_code; // PK
	
	private $_firstname;
	private $_lastname;
	private $_phonenumber;
	private $_username;
	private $_passwordHash;
	private $_email;
	private $_address; // Address primarykey.
	
	/**
	 * Constructs a new User with empty values.
	 */
	public function __construct() {
		$this->_logger = Logger::GetLogger();
		$this->_code = null;
	}
	
	/**
	 * Saves a user, if the code is null, then the system user is inserted into the database, if not then the record is updated.
	 * @throws Exception
	 */
	public function save() {
		if ($this->_code === null) {
			// Will need to INSERT.
			$pdostatement = Database::execute("INSERT INTO SYSTEM_USER (F_NAME, L_NAME, PHONE_NUMBER, USERNAME, PASSWORD, EMAIL, ADDRESS_CODE) VALUES ('{$this->getFirstname()}', '{$this->getLastname()}', '{$this->getPhonenumber()}', '{$this->getUsername()}', '{$this->getPasswordHash()}', '{$this->getEmail()}', {$this->getAddress()->getCode()})");
		
			if ($pdostatement === false) {
				$this->_logger->logController("User->save(" . print_r($this, true) . ") INSERT returned false.", 'Model::User', 'Model - INSTANCE');
				throw new Exception("Query failed to execute correctly.");
			}
			
			$row = $pdostatement->fetch(PDO::FETCH_ASSOC);
			$this->_code = $row['CODE'];
		} else {
			// Will need to UPDATE.
			$pdostatement = Database::execute("UPDATE SYSTEM_USER SET F_NAME='{$this->getFirstname()}', L_NAME='{$this->getLastname()}', PHONE_NUMBER='{$this->getPhonenumber()}', USERNAME='{$this->getUsername()}', PASSWORD='{$this->getPasswordHash()}', EMAIL='{$this->getEmail()}', ADDRESS_CODE={$this->getAddress()->getCode()} WHERE CODE={$this->getCode()}");
			
			if ($pdostatement === false) {
				$this->_logger->logController("User->save(" . print_r($this, true) . ") UPDATE returned false.", 'Model::User', 'Model - INSTANCE');
				throw new Exception("Query failed to execute correctly.");
			}
		}
	}
	
	/**
	 * Sets the firstname of this User.
	 * @param string $fname
	 */
	public function setFirstname($fname) {
		$this->_firstname = $fname;
	} 
	
	/**
	 * Sets the lastname of this user.
	 * @param string $lname
	 */
	public function setLastname($lname) {
		$this->_lastname = $lname;
	}
	
	/**
	 * Sets the phone number of this user.
	 * @param string $number
	 */
	public function setPhoneNumber($number) {
		$this->_phonenumber = $number;
	}
	
	/**
	 * Sets the username of this User.
	 * @param string $username
	 */
	public function setUsername($username) {
		$this->_username = $username;
	}
	
	/**
	 * Sets the password of this user, sets using a plaintext password and converts to md5.
	 * @param string $password
	 */
	public function setPassword($password) {
		$this->_passwordHash = md5($password);
	}
	
	/**
	 * Sets the email of this User.
	 * @param string $email
	 */
	public function setEmail($email) {
		$this->_email = $email;
	}
	
	/**
	 * Sets the Address of the user.
	 * @param Address $address
	 */
	public function setAddress(Address $address) {
		$this->_address = $address;
	}
	
	/**
	 * Gets the code/primary key of the user.
	 */
	public function getCode() {
		return $this->_code;
	}
	
	/**
	 * Gets the firstname of the user.
	 */
	public function getFirstname() {
		return $this->_firstname;
	}
	
	/**
	 * Gets the lastname of the user.
	 */
	public function getLastname() {
		return $this->_lastname;
	}
	
	/**
	 * Gets the phonenumber of the user.
	 */
	public function getPhonenumber() {
		return $this->_phonenumber;
	}
	
	/**
	 * Gets the username of the user.
	 */
	public function getUsername() {
		return $this->_username;
	}
	
	/**
	 * Gets the hashed password for the user, if it's set yet.
	 */
	public function getPasswordHash() {
		return $this->_passwordHash;
	}
	
	/**
	 * Gets the email address of the user.
	 */
	public function getEmail() {
		return $this->_email;
	}
	
	/**
	 * Gets the address of this User.
	 * @return Address The address of this user.
	 */
	public function getAddress() {
		if ($this->_address instanceof  Address) {
			return $this->_address;
		}
		
		$this->_address = new Address($this->_address);
		return $this->_address;
	}
	
	/**
	 * Gets a user identified by a username.
	 * @param string $username The users username.
	 */
	public static function getByUsername($username) {
		
		$pdostatement = Database::execute('SELECT * FROM SYSTEM_USER WHERE USERNAME = "' . $username . '"');
		
		if ($pdostatement == false) {
			$this->_logger->logController("User::getUserByUsername($username) returned false.", 'Model::User', 'Model - STATIC');
			throw new Exception("Query failed to execute correctly.");
		}
		
		// Fetch one row into an associative array.
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		
		return User::createFromArray($result);
	}
	
	public static function usernameExists($username) {
		$pdostatement = Database::execute('SELECT COUNT(USERNAME) AS C FROM SYSTEM_USER WHERE USERNAME = "' . $username . '"');
		
		if ($pdostatement == false) {
			$this->_logger->logController("User::usernameExists($username) returned false.", 'Model::User', 'Model - STATIC');
			throw new Exception("Query failed to execute correctly.");
		}
		
		// Fetch one row into an associative array.
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		
		return ($result['C'] != 0);
	}
	
	/**
	 * Gets a User by their primary key.
	 * @param int $code
	 * @throws Exception
	 */
	public static function getByCode($code) {
		$pdostatement = Database::execute('SELECT * FROM SYSTEM_USER WHERE CODE = ' . $code);
		
		if ($pdostatement == false) {
			$this->_logger->logController("User::getUserByCode($code) returned false.", 'Model::User', 'Model - STATIC');
			throw new Exception("Query failed to execute correctly.");
		}
		
		// Fetch one row into an associative array.
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		
		return User::createFromArray($result);
	}
	
	/**
	 * Gets a user by address or finds an array of users with the address.
	 * @param Address $address
	 * @throws Exception
	 */
	public static function getByAddress(Address $address) {
		$pdostatement = Database::execute('SELECT * FROM SYSTEM_USER WHERE ADDRESS_CODE = ' . $address->getCode());
		
		if ($pdostatement == false) {
			$this->_logger->logController("User::getUserByAddress(". print_r($address, true) .") returned false.", 'Model::User', 'Model - STATIC');
			throw new Exception("Query failed to execute correctly.");
		}
		
		$users = array();
		
		$row = $pdostatement->fetch(PDO::FETCH_ASSOC);
    	do {
      		$users[] = User::createFromArray($row);
    	} while ($row = $pdostatement->fetch(PDO::FETCH_NUM));
		
    	if (count($users) === 1) {
    		return $users[0];
    	}
    	
		return $users;
	}
	
	/**
	 * Creates a User from an associative array with values the same as the database.  Make CODE null to create a new user.
	 * @param array $array
	 */
	public static function createFromArray(array $array) {
		$user = new User();
		
		$user->_code	     = $array['CODE'];
		$user->_firstname    = $array['F_NAME'];
		$user->_lastname     = $array['L_NAME'];
		$user->_phonenumber  = $array['PHONE_NUMER'];
		$user->_username     = $array['USERNAME'];
		$user->_passwordHash = md5($array['PASSWORD']);
		$user->_email		 = $array['EMAIL'];
		$user->_address 	 = $array['ADDRESS_CODE'];
		
		return $user;
	}
}