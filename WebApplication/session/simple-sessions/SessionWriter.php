<?php
/**
 * Provides an interface to a for reading and writing session data.
 * @author Samuel Giles
 * @package core
 * @subpackage core-sessions
 * @version 1.0
 */
abstract class SessionWriter {
  /**
   * Reads a session into the session object.
   * Virtual Function, implementation would need to be defined in the concrete super class.
   * @param string $hash The hash to read.
   */
  abstract public function read($hash);
  
  /**
   * Writes a session object.
   * Implementation would need to be defined in the concrete super class.
   * @param string $hash The value to write.
   * @param array $sessionObject The value to write.
   */
  abstract public function write($hash, $sessionObject);
  
  /**
   * Clears a session.
   * @param $hash The hash/key of the sessions.
   */
  abstract public function clear($hash);
  
  /**
   * Persists the session across HTTP requests.  Default is setcookie.
   * @param $keyIdentifier  The value that will dientify the session between http requests.
   */
  public function httpPersist($keyIdentifier, $sessionHash, $sessionExpires, $sessionPath) {
    setcookie($keyIdentifier, $sessionHash, $sessionExpires, $sessionPath === -1 ? $_SERVER['PATH_INFO'] : $sessionPath);
  }
  
  /**
   * Clears the http persistance.
   * @param string $keyIdentifier
   */
  public function httpClear($keyIdentifier) {
    unset($_COOKIE[$keyIdentifier]);
    setcookie($keyIdentifier, NULL, -1);
  }
  
  /**
   * Gets the key that was persisted.
   * @param string $keyIdentifier
   */
  public function getHttpPersistKey($keyIdentifier) {
      if (isset($_COOKIE[$keyIdentifier])) {
  	  return $_COOKIE[$keyIdentifier];
  	}
  	
    return NULL;
  }
}