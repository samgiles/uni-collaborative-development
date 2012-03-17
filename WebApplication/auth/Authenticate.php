<?php
interface Authenticate {
	/**
	 * Authenticates an adapter.
	 */
	function authenticate($identity, $credentials);
}