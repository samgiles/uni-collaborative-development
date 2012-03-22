<?php
/**
 * This class is designed to use a database to authenticate a user.
 * @author Samuel Giles
 * @package authentication
 */
class DBAuthenticate extends Authenticate {

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
	 * Information that is set on successful authentication.
	 */
	private $_authenticationInfo = null;
    
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
     * Gets the User access level of a user given a USER ID/CODE
     * @param int $uid
     */
    private function getUserAccessLevel($uid) {
      //TODO: Remove this, this shouldn't be here as it has nothing to do with authenticating a user and violates the SRP. Probably best to move into LoginController or something.
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
     */
	public function tryAuthenticate($identity, $credential) {
		
        if ($identity != NULL) {
          // Try and authenticate the identity and credential 
          $sqlStatement = $this->buildSqlStatement($identity);    
    	  $pdo = Database::execute($sqlStatement);
		
          $row = $pdo->fetch(PDO::FETCH_ASSOC);
            
          if ($row[$this->_credential] === md5($credential)){
              // Successful
              // TODO: Probably shouldn'y get the access level, here. Low Priority, this isn't as bad as setting a session variable here. 
              $accessLevel = $this->getUserAccessLevel($row['CODE']);
              
              $this->_authenticationInfo = new AuthenticationInformation(time(), $identity, array('dbid' => $row['CODE'], 'access' => $accessLevel, 'ip' => $_SERVER['REMOTE_ADDR']));
              
              $this->notify();
              return true;
          }
        } 
        $this->notify();
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
	
	public function notify() {
		foreach ($this->_storage as $observer) {
			$observer->update($this);
		}
	}
}