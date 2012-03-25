<?php
/**
 * Listens to the Login object and sets a tag in the login information setting the required access.
 * @author Samuel Giles
 * @package user-accounts
 * @version 1.0
 **/
class SecurityObserver extends LoginObserver {
	
	public function handleUpdate(Login $login) {
		// Set the session variable on successful login.
		if ($login->getLoginStatus() === Login::LOGIN_STATUS_DENIED) {
			// don't set the session cookie, and exit early.
			// log failed login?
			return false;
		}
	
	
		// Get the users access level.
		$accessLevel = $this->getUserAccessLevel($login->getLoginInformation()->getIdentity());
		
		$login->getLoginInformation()->addTag('access-level', $accessLevel);
		
		return $accessLevel;
	}
	
	/**
	 * Gets the User access level of a user given a USER ID/CODE
	 * @param int $uid
	 */
	private function getUserAccessLevel($username) {
		//TODO: Remove this, this shouldn't be here as it has nothing to do with authenticating a user and violates the SRP. Probably best to move into LoginController or something.
		$sql = 'SELECT `STAFF`.`ACCESS_LEVEL_CODE` FROM STAFF, SYSTEM_USER WHERE `SYSTEM_USER`.`USERNAME` = "' . $username . '" AND `STAFF`.`USER_CODE` = `SYSTEM_USER`.`CODE`' ;
		$result = Database::execute($sql);
		$result = $result->fetchAll();
		if (count($result) <= 0) {
			// Non staff member.
			return AccessLevels::ANYONE; // Anyone can access.
		} else {
			return $result[0]['ACCESS_LEVEL_CODE'];
		}
	}
}