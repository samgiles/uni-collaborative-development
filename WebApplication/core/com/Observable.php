<?php
abstract class Observable {
	
	protected $_observers;
	
	public function __construct() {
		$this->_observers = new SplObjectStorage();
	}
	
	public function attach(Observer $observer) {
		$this->_observers->attach($observer);
	}
	
	public function detach (Observer $observer) {
		$this->_observers->detach($observer);
	}
	
	abstract public function notify();
}