<?php
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
     
     
     
    if (isset($_GET['logout'])) {
      // clear session.
      setcookie('logins', null); // removing this seems to break login/logout TODO: find out why
      $this->_auth->clear();
    }
     
    if ($containerController !== NULL) {
      $this->addViewVariable('setRedirect', $containerController);   
    }
     
    if (isset($_GET['go-to'])) {
         $this->_redirect = $_GET['go-to'];
    }
     
     
  // Check $_POST variables for uname AND pword.
  
  if (isset($_POST['uname']) and isset($_POST['pword'])) {
    // Do authentication with username and password.
    $this->_hasAuthenticated = $this->tryAuthenticate($_POST['uname'], $_POST['pword']);
    
    if (!$this->_hasAuthenticated) {
      $this->_invalidDetails = true;  
    }
    
  } else {
    // If no uname and password variable set simply check for current authentication.
    $this->_hasAuthenticated = $this->tryAuthenticate(null, null);
  }
  
  $this->addViewVariable('invalidDetails', $this->_invalidDetails); 
  $this->addViewVariable('hasAuthenticated', $this->_hasAuthenticated);
  $this->addViewVariable('redirect', $this->_redirect);
 }
    
  private function tryAuthenticate($uname, $pword) {
   // Create an Authenticate object.  The Authenticate interface implements a single method: function authenticate($identity (i.e. Username), $credentials (i.e. Password));
   return $this->_auth->authenticate($uname, $pword);
  }
  
  public function getAuthenticated() {
    return $this->_hasAuthenticated;
  }
  

}