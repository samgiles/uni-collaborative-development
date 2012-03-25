<?php
/**
 * Handles login and logout functionality and manages the session status of authenticated users.
 * @author Samuel Giles
 * @package controllers-web
 */
class LoginController extends Controller {
    
 // On request with uname and pword POST variables, try and do Database authentication using the DB Auth adapter
 // On simple request with no POST/GET variables get the authentaication state of the current session. (i.e get if a user is logged in or not)
 
 private $_hasAuthenticated = false;
 private $_invalidDetails = false;
 private $_auth;
 private $_redirect = false;
 
 private $_loginInformation;
 
  public function __construct($containerController = NULL) {
    $this->_skin = 'default';
    $this->_content = 'login';
    $this->_layout = 'empty';
    
    $this->_auth = new DBAuthenticate("SYSTEM_USER", "CODE", "USERNAME", "PASSWORD", array());  // Table name: SYSTEM_USER, Primary Key: CODE, Username attribute USERNAME , Password attrbute name PASSWORD. 
     
    if ($containerController !== NULL) { // Used to redirect a user back to the previous page they were on when logging in.
      $this->addViewVariable('setRedirect', $containerController);   
    }
     
    if (isset($_GET['go-to'])) {
      $this->_redirect = $_GET['go-to'];
    }
     
    if (isset($_GET['logout'])) {
      $this->actionLogout();
    }
    
    
    // check for an authenticated session already.
    $authInfo = $this->checkSession();
    
    if ($authInfo) {
    	$this->_hasAuthenticated = true;
    } else {
    	$this->_hasAuthenticated = false;
    }
    
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

     
    $this->addViewVariable('invalidDetails', $this->_invalidDetails); 
    $this->addViewVariable('hasAuthenticated', $this->_hasAuthenticated);
    $this->addViewVariable('redirect', $this->_redirect);
  }
  
  private function actionLogout() {
  	$this->logout();
  }
  
  
  private function doLogin($username, $password, $ipaddress) {
  	$login = new Login($this->_auth);
  	
  	$this->addLoginHandlers($login);
  	
  	return $login->handleLogin($username, $password, $ipaddress);
  }
  
  
  private function addLoginHandlers(Login $login) {
  	// simply instantiating the object and passing in the Login object is enough to associate it
  	$securityHandler = new SecurityObserver($login);
  	$sessionHandler = new LoginSessionObserver($login);
  	
  }
  
  
  private function checkSession() {
      $authInfo = false;
  	  $loginDetails = Session::get('LOGIN');

      // Session Hash doesn't exist if NULL
      if ($loginDetails != NULL && $loginDetails instanceof LoginInformation) {
        if ($loginDetails->getIpAdress() === $_SERVER['REMOTE_ADDR']) {
          $authInfo = $loginDetails;
        }
      }
    
    return $authInfo;
  }

  private function logout() {
      Session::clear();
  }

  public function getAuthenticated() {
    return $this->_hasAuthenticated;
  }

  public function getLoginInformation() {
  	return $this->_loginInformation;
  }
}