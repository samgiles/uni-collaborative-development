<?php
/**
 * TODO
 * @author Samuel Giles
 */
class ShoppingCartSession extends session_store {
	protected $_customerId;
	
	private $_logger;
	
	/**
	 * TODO
	 * @param unknown_type $key TODO
	 * @param unknown_type $customerId TODO
	 */
	public function __construct ($key, $customerId){
		parent::__construct();
		
		$this->_logger = Logger::GetLogger();
		$this->_logger->info('Session Id: ' . session_id());
		$this->_key = $key;
		$this->_customerId = $customerId;
		$_SESSION[$key] = $this;
	}

	/**
	 * TODO
	 * FUTURE Move into an account loggged in session handler.
	 */
	public function getCustomerCode() {
		return $this->_customerId;
	}
	
}