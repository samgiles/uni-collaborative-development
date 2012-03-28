<?php
/**
 * Defines an observable class, this can be oberved by Observer's.
 * @author Samuel Giles
 * @package core-com
 * @subpackage core
 * @version 0.2
 */
abstract class Observable {
	
	/**
	 * Maintains a list of registered Observers
	 * @var SplObjectStorage (Should only be storing objects that implement Observer)
	 */
	protected $_observers;
	
	/**
	 * Creates a new Observable and sets up the underlying storage mechanism.
	 */
	public function __construct() {
		$this->_observers = new SplObjectStorage();
	}
	
	/**
	 * Attach an observer to this observable to be notified of updates.
	 * @param Observer $observer The observer to attach
	 */
	public function attach(Observer $observer) {
		$this->_observers->attach($observer);
	}
	
	/**
	 * Detach an observer from this observable so it no longer is notified of updates.
	 * @param Observer $observer The observer to detach.
	 */
	public function detach (Observer $observer) {
		$this->_observers->detach($observer);
	}
	
	/**
	 * Notify notifies listeners of the updated Observable.
	 */
	abstract public function notify();
}