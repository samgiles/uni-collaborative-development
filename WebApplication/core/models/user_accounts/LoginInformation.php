<?php
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
	
	public function getTag() {
		return $this->_tag;
	}
	
	public function addTag($key, $object) {
		$this->_tag[$key] = $object;
	}
}