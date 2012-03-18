<?php
/**
 * An Authenticator, this allows an entity to be authenticated given a unique identifier such as a username and some credential such as a password.
 * @author Samuel Giles
 * @package authentication
 */
interface Authenticate {
	/**
	 * Authenticates an entity.
	 * @param $identity The identity of the entity.
	 * @param $credentials The credentials of the entity.
	 * @returns mixed Returns always FALSE on failure and may return Adapter specific information on success.
	 */
	function authenticate($identity, $credentials);
}