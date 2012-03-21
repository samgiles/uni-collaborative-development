<?php
class Address {
	private $_code; // PK
	private $_lineone;
	private $_linetwo;
	private $_postcode;
	
	public function getCode() {
		return $this->_code;
	}
}