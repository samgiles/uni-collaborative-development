<?php
require_once('SessionWriter.php');
/**
 * A Session object. A Session object must be started using the static method `start`.
 * @author Samuel Giles
 * @version 0.1
 * @package application-core
 * @subpackage application-core-sessions
 */
class Session {
	
	/**
	 * The name of the cookie that will store the session hash.
	 * @var string
	 */
	private static $HTTP_PERSIST_NAME = 'SESS';
	
	/**
	 * The array of objects stored in this session.
	 * @var array
	 */
	private $_objects;
	
	/**
	 * The hash that identifies this session.
	 * @var string
	 */
	private $_idHash;
  
	/**
	 * The session writer object that is used to read and write session data.
	 * @var SessionWriter
	 */
	private $_sessionWriter;
	
	/**
	 * On shutdown of the PHP engine the destructor of this Session is going to write the session data to using the writer, however for performance reasons, this flag will only be set when data
	 * is changed therefore we only write to the data whe n we need to.
	 * @var boolean
	 */
	private $_dontWrite = true;
  
	/**
	 * The instance of this Session
	 * @var Session
	 */
	private static $instance;
  
  /**
   * Starts a Session given a SessionWriter, this checks for a cookie that can identify a session with a client/request, if one hasn't been started yet then 
   * a cookie will be set.
   * @param SessionWriter $sessionWriter The SessionWriter that is used for reading and writing the sessions.
   * @param int $sessionExpires The time the session expires. This is a Unix timestamp so is in number of seconds since the epoch. If left as 0 or undefined the session will last until the client closes their browser/client.
   * @param string $sessionPath The path on the server in which the session will be available on. If set to '/', the session will be available within the entire domain. If set to '/foo/', the session is only be available within the /foo/ directory and all sub-directories such as /foo/bar/ of domain. The default value is the current directory that the session is started in.
   */
  public static function start(SessionWriter $sessionWriter, $sessionExpires = 0, $sessionPath = -1) {
    if (!isset(self::$instance) || self::$instance === NULL) {
        //We've got to tie a particular user to a Session, so we'll create a hash for them if we haven't already.
  	  $httpPersistedHash = $sessionWriter->getHttpPersistKey(Session::$HTTP_PERSIST_NAME);
      if ($httpPersistedHash !== NULL) {
        $new = false;
      } else {
        $httpPersistedHash = hash('sha256', $_SERVER['REMOTE_ADDR'] . time() . rand(0, 100));
        $sessionWriter->httpPersist(Session::$HTTP_PERSIST_NAME, $httpPersistedHash, $sessionExpires, $sessionPath === -1 ? dirname($_SERVER['REQUEST_URI']) : $sessionPath);
      	$new = true;
      }
      
      self::$instance = new Session($sessionWriter, $httpPersistedHash, $new);
  	}
  }
  
  /**
   * Constructs a new session writer with a given Writer and Hash.
   * @param SessionWriter $sessionWriter The session writer
   * @param string $hash The hash.
   * @param boolean $new Whether this is a new session or an existing session.
   */
  private function __construct(SessionWriter $sessionWriter, $hash, $new = false) {
  	$this->_sessionWriter = $sessionWriter;
  	$this->_idHash = $hash;
  	$this->_objects = array();
  	
  	if (!$new) {
      $this->_objects = $sessionWriter->read($hash);
      
      // check the session is still valid
      if (!isset($this->_objects)) {
      	// If it isn't its most likely been corrupted, just clear and start fresh.
      	$this->clearAll();
      }
      
  	}
  }
  
  /**
   * Destroys the Session and writes to the SessionWriter if needed.
   */
  public function __destruct() {
  	if ($this->_dontWrite === false) {
      $this->_sessionWriter->write($this->_idHash, $this->_objects);
  	}
  }

  /**
   * Get a value from the session store associated with the key.  Returns NULL if no value exists.
   * @param string $key
   */
  public static function get($key) {
    if (self::sessionStarted()) {
      $key = (string)$key;
      
      if (isset(self::$instance->_objects[$key])) {
        return self::$instance->_objects[$key];
      }
      
    }
    return NULL;
  }

  /**
   * Sets a value in the session store associated with a key.
   * @param string $key
   * @param mixed $value
   */
  public static function set($key, $value) {
    if (self::sessionStarted()) {
      self::$instance->_objects[$key] = $value;
      self::$instance->_dontWrite = false;
      return true;
    }
    return false;
  }
  
  /**
   * Clears all of the session objects.
   */
  private function clearAll() {
  	$this->_sessionWriter->clear($this->_idHash);
  	$this->_sessionWriter->httpClear(self::$HTTP_PERSIST_NAME);
  	$this->_dontWrite = true;
  	$this->_objects = array();
  }
  
  /**
   * Clears all of the session objects.
   */
  public static function clear() {
    if (self::sessionStarted()) {
      $session = self::$instance->clearAll();
      return true;
    }
    
    return false;
  }
  
  /**
   * Get's whether the session has started yet.
   */
  public static function sessionStarted() {
    if (self::$instance === NULL || !isset(self::$instance)) {
      trigger_error('Session not started, start session with `Session::start($sessionWriter)`', E_USER_NOTICE);
      return false;
    }
    
    return true;
  }
}