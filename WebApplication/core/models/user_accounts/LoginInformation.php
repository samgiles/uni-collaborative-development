<?php 
/**
 * This class is used to store login information and it is the object that is serialized by the Session's for session persistance.
 * It can hold additional key => value objects in the tage acessible via the getTag($key) and setTag($key, $value) methods.
 * @author Samuel Giles
 * @package user-accounts
 * @version 1.0
 */
class LoginInformation {
	
	private $_tag;
	private $_authTime;
	private $_identity;
	private $_ipAddress;
	
	public function __construct($authtime, $identity, $ipaddress, array $additional) {
		$this->_tag = $additional;
		$this->_authTime = $authtime;
		$this->_identity = $identity;
		$this->_ipAddress = $ipaddress;
	}
	
	public function getAuthTime() {
		return $this->_authTime;
	}
	
	public function getIpAdress() {
		return $this->_ipAddress;
	}
	
	public function getIdentity() {
		return $this->_identity;
	}
	
	public function getTag($key) {
		return $this->_tag[$key];
	}
	
	public function addTag($key, $object) {
		$this->_tag[$key] = $object;
	}
}