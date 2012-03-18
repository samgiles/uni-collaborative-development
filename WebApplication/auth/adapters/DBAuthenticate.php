<?php
/**
 * This class is designed to use a database to authenticate a user.
 * @author Samuel Giles
 * @package authentication
 */
class DBAuthenticate implements Authenticate {

	/**
	 * The table name in the database used to store the authentication credentials.
	 * @var string
	 */
	protected $_table;
	
	/**
	 * The column in name the database table that represents the identity of the entity being authenticated i.e. A username is usually a key that uniquely identifies a user.
	 * @var string
	 */
	protected $_identity;
	
	/**
	 * The column name in the database table that represents the credential i.e. a password.
	 * @var string
	 */
	protected $_credential;
	
	/**
	 * These additional conditions holds an array of any more conditions as SQL conditions e.g. { "AND {field} != '{CONDITION}'", "OR {field} > {condition}" }
	 * @var array
	 */
	protected $_conditions;
	
	/**
	 * The column name of the primary key in the database table.
	 * @var string
	 */
	protected $_primaryKey;
    
	/**
	 * Constructs a new Database Authentication adapter.  This authenticates credentials against a database.
	 * @param string $table The table that holds credentials.
	 * @param string $identity The field name that contains the identity information eg. 'username'
	 * @param string $credential The field name that contains the credential information e.g 'paassword'
	 * @param array $conditions An array of any more conditions as SQL conditions e.g. { "AND {field} != '{CONDITION}'", "OR {field} > {condition}" }
	 */
	public function __construct($table, $primaryKey, $identity, $credential, $conditions) {
		$this->_table = $table;
		$this->_identity = $identity;
		$this->_credential = $credential;
		$this->_conditions = $conditions;
        $this->_primaryKey = $primaryKey;
        
	}
	
	/**
	 * Clears an authenticated session.
	 * TODO: Remove this, this shouldn't really belong in here, as it has nothing to do with Authenticating a user, and violates the SRP.
	 */
    public function clear() {
      Session::clear();
    }
    
    /**
     * Gets the User access level of a user given a USER ID/CODE
     * @param int $uid
     * TODO: Remove this, this shouldn't be here as it has nothing to do with authenticating a user and violates the SRP. Probably best to move into LoginController or something.
     */
    private function getUserAccessLevel($uid) {
      $sql = 'SELECT ACCESS_LEVEL_CODE FROM STAFF WHERE USER_CODE = ' . $uid;
      $result = Database::execute($sql);
      $result = $result->fetchAll();
      if (count($result) <= 0) {
        // Non staff member. 
        return AccessLevels::ANYONE; // Anyone can access.
      } else {

        return $result[0]['ACCESS_LEVEL_CODE'];  
      }
    }
    
    /**
     * Authenticates an entity with a given identity and credential.
     * @see Authenticate::authenticate()
     * TODO: Clean up this function, currently sets a session variable called 'login' that contains successful login information.
     */
	public function authenticate($identity, $credential) {
		
        if ($identity != NULL) {
          // Try and authenticate the identity and credential 
          $sqlStatement = $this->buildSqlStatement($identity);    
    	  $pdo = Database::execute($sqlStatement);
		
          $row = $pdo->fetch(PDO::FETCH_ASSOC);
            
          if ($row[$this->_credential] === md5($credential)){
              // Successful
              // TODO: Shouldn't set the Session here really as it defeats the SRP, creating side effects that may be unwanted.
              $accessLevel = $this->getUserAccessLevel($row['CODE']);
              Session::set('login', array('username' => $identity, 'time' => time(), 'dbid' => $row['CODE'], 'access' => $accessLevel, 'ip' => $_SERVER['REMOTE_ADDR']));
              return true;
          }
        } else {
          // Try and authenticate the cookie hash 
          
          $loginDetails = Session::get('login');

          // Session Hash doesn't exist if NULL
          if ($loginDetails != NULL) {
              if (array_key_exists('ip', $loginDetails) && $loginDetails['ip'] == $_SERVER['REMOTE_ADDR']) {
                return true;
              } else {
                return false;
              }
          } else {
            return false;   
          }
        }
        
        return false;

	}
	
	/**
	 * Builds the SQL statement used to Authenticate a user against the database.
	 * @param string $identity The entities actual identity.
	 */
	protected function buildSqlStatement($identity) {
		// Build an SQL statement
		$sqlStatement = 'SELECT * FROM ' . $this->_table . ' WHERE ' . $this->_identity .  ' = "' . $identity . '"';
		if ($this->_conditions) {
            $sqlStatement .= implode(" ", $this->_conditions);
		}
		
		return $sqlStatement;
	}
}