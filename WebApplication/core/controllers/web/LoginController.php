<?php
/**
 * Handles login and logout functionality and manages the session status of authenticated users.
 * @author Samuel Giles
 * @package application-controller
 * @subpackage application-controller-web
 */
class LoginController extends Controller {
    
 // On request with uname and pword POST variables, try and do Database authentication using the DB Auth adapter
 // On simple request with no POST/GET variables get the authentaication state of the current session. (i.e get if a user is logged in or not)
 	/**
 	 * Gets whether the LoginController successfully authenticated.
 	 * @var boolean
 	 */
	private $_hasAuthenticated = false;
	
	/**
	 * This flags the state of the authentication, if true then the authentication failed due to invalid details.
	 * @var boolean
	 */
 	private $_invalidDetails = false;
 	
 	/**
 	 * The object used for authentication.
 	 * @var Authenticate
 	 */
 	private $_auth;
 
 	/**
 	 * The login information that was retreived from this LoginController.
 	 * @var LoginInformation
 	 */
 	private $_loginInformation;
 
 	/**
 	 * Starts a new Login.
 	 * @param string $containerController The name of the controller that this Login was called from, if any, this mainly sets the value to redirtect back to.
 	 */
  	public function __construct($containerController = NULL) {
   		$this->_skin = 'default';
    	$this->_content = 'login';
    	$this->_layout = 'empty';
    
    	// Create a new Authentication object.
    	$this->_auth = new DBAuthenticate("SYSTEM_USER", "CODE", "USERNAME", "PASSWORD", array());  // Table name: SYSTEM_USER, Primary Key: CODE, Username attribute USERNAME , Password attrbute name PASSWORD. 
     
    	// Was a logout action received? if so logout and redirect to referer.
    	if (isset($_GET['logout'])) {
      		$this->actionLogout();
      		header("Location: " . $_SERVER['HTTP_REFERER']);
      		exit(0);
    	}
    
    	if ($containerController !== NULL) { // Used to redirect a user back to the previous page they were on when logging in.
    		$this->addViewVariable('setRedirect', $containerController);
    	}
    
   	 	// check for an authenticated session already.
    	$authInfo = $this->checkSession();
    
    	// If uname and pword set try login with those credentials.
    	if (isset($_POST['uname']) && isset($_POST['pword'])) {
    		$authInfo = $this->doLogin($_POST['uname'], $_POST['pword'], $_SERVER['REMOTE_ADDR']);
    	
   	 		if ($authInfo) {
    			$this->_hasAuthenticated = true;
    			$this->_invalidDetails = false;
    		} else {
    			$this->_hasAuthenticated = false;
    			$this->_invalidDetails = true;
    		}
    	}
    
   	 	$this->_loginInformation = $authInfo;

  		if (isset($_GET['go-to'])) {
      		header("Location: " . $_SERVER['HTTP_REFERER']);
      		exit(0);
    	}
    
    	$this->addViewVariable('invalidDetails', $this->_invalidDetails);
    	$this->addViewVariable('hasAuthenticated', $this->_hasAuthenticated); 
  	}
  
  	/**
  	 * Do the logout.
  	 */
  	private function actionLogout() {
  		$this->logout();
  	}
  
  
  	/**
  	 * Do a login using the username, password and a given ip address.
  	 * @param string $username The username to login with.
  	 * @param string $password The password to login with.
  	 * @param string $ipaddress The ip address the login request came from.
  	 */
  	private function doLogin($username, $password, $ipaddress) {
  		$login = new Login($this->_auth);
  		
  		$this->addLoginHandlers($login);
  	
  		return $login->handleLogin($username, $password, $ipaddress);
  	}
  
  	/**
  	 * Add listeners to the Login
  	 * @param Login $login
  	 */
 	private function addLoginHandlers(Login $login) {
  		// simply instantiating the object and passing in the Login object is enough to associate it
  		$securityHandler = new SecurityObserver($login);
  		$sessionHandler = new LoginSessionObserver($login); 	
 	}
  
 	/**
 	 * Check the session variable for a login.
 	 */
  	private function checkSession() {
   		$authInfo = false;
  	  	$loginDetails = Session::get('LOGIN');
      
  	  	// Session Hash doesn't exist if NULL
      	if ($loginDetails != NULL && $loginDetails instanceof LoginInformation) {
        	if ($loginDetails->getIpAdress() === $_SERVER['REMOTE_ADDR']) {
        	  	$authInfo = $loginDetails;
        	}
      	}
      
      	if ($authInfo) {
      		$this->_hasAuthenticated = true;
      	} else {
      		$this->_hasAuthenticated = false;
      	}
      	
      	return $authInfo;
  	}

  	/**
  	 * Logout.
  	 */
	private function logout() {
    	Session::clear();
	}

	/**
	 * Get whether this LoginController has authenticated.
	 * @return boolean
	 */
  	public function getAuthenticated() {
   		return $this->_hasAuthenticated;
  	}

  	/**
  	 * Gets the LoginInformation for this particular Login.
  	 * @return LoginInformation
  	 */
  	public function getLoginInformation() {
  		return $this->_loginInformation;
  	}
}