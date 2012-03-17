<?php
/**
 * This class is designed to use a database to authenticate a user.
 * @author Samuel Giles
 *
 */
class DBAuthenticate implements Authenticate {

	protected $_table;
	protected $_identity;
	protected $_credential;
	protected $_additionalConditions;
	protected $_primaryKey;
    
	/**
	 * Constructs a new Database Authentication adapter.  This authenticates credentials against a database.
	 * @param string $table The table that holds credentials.
	 * @param string $identity The field name that contains the identity information eg. 'username'
	 * @param string $credential The field name that contains the credential information e.g 'paassword'
	 * @param array $additionalConditions An array of any more conditions as SQL conditions e.g. { "AND {field} != '{CONDITION}'", "OR {field} > {condition}" }
	 */
	public function __construct($table, $primaryKey, $identity, $credential, $additionalConditions) {
		$this->_table = $table;
		$this->_identity = $identity;
		$this->_credential = $credential;
		$this->_additionalConditions = $additionalConditions;
        $this->_primaryKey = $primaryKey;
        
	}
	
    public function clear() {
      Session::clear();
    }
    
    private function getUserAccessLevel($uid) {
      $sql = 'SELECT ACCESS_LEVEL_CODE FROM STAFF WHERE USER_CODE = ' . $uid;
      $result = Database::execute($sql);
      $result = $result->fetchAll();
      if (count($result) <= 0) {
        // Non staff member. 
        return AccessLevels::Anyone; // Anyone can access.
      } else {

        return $result[0]['ACCESS_LEVEL_CODE'];  
      }
    }
    
	public function authenticate($identity, $credential) {
		
        if ($identity != NULL) {
          // Try and authenticate the identity and credential 
          $sqlStatement = $this->buildSqlStatement($this->_identity, $identity, $this->_additionalConditions);    
    	  $pdo = Database::execute($sqlStatement);
		
          $row = $pdo->fetch(PDO::FETCH_ASSOC);
            
          if ($row[$this->_credential] === md5($credential)){
              // Successful
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
	
	protected function buildSqlStatement($identityFieldname, $identity, $conditions) {
		// Build an SQL statement
		$sqlStatement = 'SELECT * FROM ' . $this->_table . ' WHERE ' . $identityFieldname .  ' = "' . $identity . '"';
		if ($this->_additionalConditions) {
            $sqlStatement .= implode(" ", $this->_additionalConditions);
		}
		
		return $sqlStatement;
	}
}