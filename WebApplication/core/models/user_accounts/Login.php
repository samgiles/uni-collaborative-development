<?php
/**
 * Manages the authentication and logging in of a user, a LoginObserver can register to recieve notifications on a login action.
 * @author Samuel Giles
 * @version 1.1
 * @package UserAccounts
 */
class Login extends Observable {
	
	/**
	 * This flag means access has been granted for the particular user.
	 * @var boolean true
	 */
	const LOGIN_STATUS_ACCESS = true;
	
	/**
	 * This flag means access has been denied for the particular user.
	 * @var boolean false
	 */
	const LOGIN_STATUS_DENIED = false;
	
	/**
	 * Stores the authentication method used for logging in
	 * @var Authenticate
	 */
	private $_authenticationMethod;
	
	/**
	 * Stores the current status of this login and will either be Login::LOGIN_STATUS_ACCESS or Login::LOGIN_STATUS_DENIED
	 * @var boolean
	 */
	private $_loginStatus = false;
	
	/**
	 * Stores additional information about the logged in user
	 * @var LoginInformation
	 */
	private $_loginInformation = false;
	
	/**
	 * Constructs a Login object that can be used to login using the specified authentication method.
	 * @param Authenticate $authenticationMethod
	 * @return Login A new Login object
	 */
	public function __construct(Authenticate $authenticationMethod) {
		parent::__construct();
		$this->_loginStatus = self::LOGIN_STATUS_DENIED;
		$this->_authenticationMethod = $authenticationMethod;
	}
	
	
	/**
	 * This handles a login action, and tries to verify a users credentials using the authentication method this Login object was created with.
	 * It then sets the status of this login and returns a boolean value, true for success false for failure.
	 * @param string $username The username of the entity that is being authenticated.
	 * @param string $password The Hashed password of the entity that is being authenticated.
	 * @param string $ipaddress The remote IP address of the entity being authenticated.
	 * @return boolean True for a successful login, false for a failure.
	 */
	public function handleLogin($username, $password, $ipaddress) {
		$isAuthorized = $this->_authenticationMethod->tryAuthenticate($username, $password);
		
		$this->setStatus($isAuthorized, $username, $ipaddress);
		
		return $isAuthorized;
	}
	
	/**
	 * Sets the status notifying any listeners.
	 * @param boolean $loginstatus The login status.
	 * @param string $user The entity's username.
	 * @param string $ip The entity's ip address.
	 * @return void
	 */
	private function setStatus($loginstatus, $user, $ip) {
		$this->_loginStatus = $loginstatus;
		
		if ($this->_loginStatus === true) {
			$this->_loginInformation = new LoginInformation(time(), $user, $ip, array());
		}
		
		$this->notify();
	}
	
	/**
	 * Get the login status.
	 * @return boolean returns either Login::LOGIN_STATUS_ACCESS or Login::LOGIN_STATUS_DENIED which are equivalent to boolean true and false values respectively.
	 */
	public function getLoginStatus() {
		return $this->_loginStatus;
	}
	
	/**
	 * Gets the additional login information.
	 * @return LoginInformation Additional login information for this login.
	 */
	public function getLoginInformation() {
		return $this->_loginInformation;
	}
	
	/**
	 * Update LoginObserver's attached with this Login object.
	 * @see Observable::notify()
	 * @return void
	 */
	public function notify() {
		foreach($this->_observers as $observer) {
			$observer->update($this);
		}
	}
}