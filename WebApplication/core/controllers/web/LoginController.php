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
 
  public function __construct($containerController = NULL) {
    $this->_skin = 'default';
    $this->_content = 'login';
    $this->_layout = 'empty';
    
    $this->_auth = new DBAuthenticate("SYSTEM_USER", "CODE", "USERNAME", "PASSWORD", array());  // Table name: SYSTEM_USER, Primary Key: CODE, Username attribute USERNAME , Password attrbute name PASSWORD. 
     
    if ($containerController !== NULL) {
      $this->addViewVariable('setRedirect', $containerController);   
    }
     
    if (isset($_GET['go-to'])) {
      $this->_redirect = $_GET['go-to'];
    }
     
    if (isset($_GET['logout'])) {
      $this->logout();
    } else {
      $this->doLogin();
    }
     
    $this->addViewVariable('invalidDetails', $this->_invalidDetails); 
    $this->addViewVariable('hasAuthenticated', $this->_hasAuthenticated);
    $this->addViewVariable('redirect', $this->_redirect);
  }
  
  private function doLogin() {
    // Initialise variable.
    $authInfo = false;
    
    // Check $_POST variables for uname AND pword.
    if (isset($_POST['uname']) and isset($_POST['pword'])) {
      // Do authentication with username and password.
      $authInfo = $this->tryAuthenticate($_POST['uname'], $_POST['pword']);
    
      if ($authInfo !== FALSE) {
        Session::set('login', $authInfo);
      }
    
    } else {
      // If no uname and password variable set simply check for current authentication.
      $loginDetails = Session::get('login');

      // Session Hash doesn't exist if NULL
      if ($loginDetails != NULL) {
        if (array_key_exists('ip', $loginDetails) && $loginDetails['ip'] == $_SERVER['REMOTE_ADDR']) {
          $authInfo = $loginDetails;
        }
      } else {
        $this->_invalidDetails = true;
      }
    }
    
    $this->_hasAuthenticated = ($authInfo !== FALSE);
  }

  private function logout() {
      Session::clear();
  }
  
  private function tryAuthenticate($uname, $pword) {
   // Create an Authenticate object.  The Authenticate interface implements a single method: function authenticate($identity (i.e. Username), $credentials (i.e. Password));
  	return $this->_auth->tryAuthenticate($uname, $pword);
  }

  public function getAuthenticated() {
    return $this->_hasAuthenticated;
  }


}