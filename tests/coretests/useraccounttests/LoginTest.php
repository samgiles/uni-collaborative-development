<?php

class MockAuthenticator extends Authenticate {
	
	private $_pass;
	
	public function __construct($alwayspass) {
		$this->_pass = $alwayspass;
	}
	
	public function tryAuthenticate($identity, $credentials) {
		return $this->_pass;
	}
	
}

class MockObserver extends LoginObserver {
	
	public $handledUpdate = false;
	
	public function handleUpdate(Login $login) {
		$this->handledUpdate = $login;
	}
}

class LoginTest extends PHPUnit_Framework_TestCase {
	private $_failAuth;
	private $_passAuth;
	
	public function __construct() {
		$this->_failAuth = new MockAuthenticator(false);
		$this->_passAuth = new MockAuthenticator(true);
	}
	
	public function testHandleLogin() {
		$login = new Login($this->_failAuth);
		
		$this->assertFalse($login->handleLogin('username', 'password', 'ipaddress'));
		
		$login = new Login($this->_passAuth);
		
		$this->assertTrue($login->handleLogin('username', 'password', 'ipaddress'));
	}
	
	public function testGetLoginStatus() {
		$login = new Login($this->_failAuth);
		$login->handleLogin('username', 'password', 'ipaddress');
		
		$this->assertFalse($login->getLoginStatus());
		
		$login = new Login($this->_passAuth);
		$login->handleLogin('username', 'password', 'ipaddress');
		
		$this->assertTrue($login->getLoginStatus());
	}
	
	public function testGetLoginInformation() {
		$login = new Login($this->_failAuth);
		$login->handleLogin('username', 'password', 'ipaddress');
		
		$this->assertTrue($login->getLoginInformation() instanceof LoginInformation);
		
		$login = new Login($this->_passAuth);
		$login->handleLogin('username', 'password', 'ipaddress');
		
		$this->assertTrue($login->getLoginInformation() == NULL);
	}
	
	public function testObservable() {
		$login = new Login($this->_failAuth);
		
		$loginObserver = new MockObserver($login);
		
		$this->assertTrue($loginObserver->handledUpdate === false);
		$login->handleLogin('username', 'password', 'ipaddress');
		
		$this->assertTrue($loginObserver->handledUpdate === $login);
	}
}