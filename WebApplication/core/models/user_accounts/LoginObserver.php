<?php
abstract class LoginObserver extends Observer {
	
	/**
	 * The Login object.
	 */
	private $_login;
	
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