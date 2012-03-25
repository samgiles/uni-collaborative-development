<?php
/**
 * This listens to the Login handler and sets a session variable depending on the result.
 * @author Samuel Giles
 * @package user-accounts
 * @version 1.0
 */
class LoginSessionObserver extends LoginObserver {
	
	public function handleUpdate(Login $login) {
		// Set the session variable on successful login.
		if ($login->getLoginStatus() === Login::LOGIN_STATUS_DENIED) {
			// don't set the session cookie, and exit early.
			return false;
		}
		
		// the login status is ok so set the session cookie.
		return Session::set('LOGIN', $login->getLoginInformation());
	}
	
}