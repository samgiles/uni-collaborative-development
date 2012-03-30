<?php
/**
 * A mock authentication object.
 * @author Samuel Giles
 * @package unit-tests
 * @subpackage unit-tests-mockobjects
 */
class MockAuthenticator extends Authenticate {
	
	private $_pass;
	
	public function __construct($alwayspass) {
		$this->_pass = $alwayspass;
	}
	
	public function tryAuthenticate($identity, $credentials) {		
		return $this->_pass;
	}
	
}

/**
 * A mock observer object
 * @author Samuel Giles
 * @package unit-tests
 * @subpackage unit-tests-mockobjects
 */
class MockObserver extends LoginObserver {
	
	public $handledUpdate = false;
	
	public function handleUpdate(Login $login) {
		$this->handledUpdate = $login;
	}
}

/**
 * Unit testing the login functionality.
 * @author Samuel Giles
 * @package unit-tests
 */
class LoginTest extends PHPUnit_Framework_TestCase {
    private $_failAuth;
	private $_passAuth;
	
	public function __construct() {
		$this->_failAuth = new MockAuthenticator(Login::LOGIN_STATUS_DENIED);
		$this->_passAuth = new MockAuthenticator(Login::LOGIN_STATUS_ACCESS);
	}

	
	public function testHandleLogin() {
		$login = new Login($this->_failAuth);
		
		$this->assertFalse($login->handleLogin('username', 'password', 'ipaddress'), "Try authenticated usng the failAuth object");
		
		$login = new Login($this->_passAuth);
		
		$this->assertTrue($login->handleLogin('username', 'password', 'ipaddress'), "The handle login should return true.");
	}
	
	public function testGetLoginStatus() {
		$login = new Login($this->_failAuth);
		
		$result = $login->handleLogin('username', 'password', 'ipaddress');
		
		
		$this->assertTrue($result !== true, "The handleLogin method was expected to return false.");
		
		$this->assertTrue($login->getLoginStatus() !== true, "The getLoginStatus method was expected to return false.");
		
		$login = new Login($this->_passAuth);
		$login->handleLogin('username', 'password', 'ipaddress');
		
		$this->assertTrue($login->getLoginStatus());
	}
	
	public function testGetLoginInformation() {
		$login = new Login($this->_failAuth);
		$login->handleLogin('username', 'password', 'ipaddress');
		
		$this->assertFalse($login->getLoginInformation() instanceof LoginInformation, "Should not have been an instanceof LoginInformation");
		
		$login = new Login($this->_passAuth);
		$login->handleLogin('username', 'password', 'ipaddress');
		
		$this->assertFalse($login->getLoginInformation() == NULL, "Login information should not have been null");
	}
	
	public function testObservable() {
		$login = new Login($this->_failAuth);
		
		$loginObserver = new MockObserver($login);
		
		$this->assertTrue($loginObserver->handledUpdate === false);
		$login->handleLogin('username', 'password', 'ipaddress');
		
		$this->assertTrue($loginObserver->handledUpdate === $login);
	}
}