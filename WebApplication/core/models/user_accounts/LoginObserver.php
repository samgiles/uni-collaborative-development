<?php
/**
 * An abstract object that can be used to observer a Login object, this will receive notifications of a login action regardless of it failing or passing.
 * @author Samuel Giles
 * @package user-accounts
 * @version 1.0
 * @abstract
 */
abstract class LoginObserver extends Observer {
	
	/**
	 * The Login object.
	 */
	private $_login;
	
	/**
	 * Creates a new observer and attaches itself to the Observable
	 * @param Login $login The login object to observe.
	 */
	public function __construct(Login $login) {
		$this->_login = $login;
		$this->_login->attach($this);
	}
	
	/**
	 * Update the LoginObserver with a new subject.
	 * @see Observer::update()
	 */
	public function update(Observable $subject) {
		if ($subject === $this->_login) {
			$this->handleUpdate($subject);
		}
	}
	
	abstract function handleUpdate(Login $login);
}