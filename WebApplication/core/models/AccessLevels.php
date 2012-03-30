<?php
/**
 * Determines the AccessLevels as bit flags.
 * @author Samuel Giles
 * @package application-core
 * @subpackage application-core-models
 * @version 0.8
 */
abstract class AccessLevels {
	
	/**
	 * The value that represent any user, i.e. the lowest permission level.		000
	 * @var int
	 */
  	const ANYONE = 0;
  	
  	/**
  	 * The value that represent an admin, the highest permission level.			111
  	 * @var int
  	 */
  	const ADMIN = 7;
  	
  	/**
  	 * The value that represents a supervisor.									001
  	 * @var int
  	 */
  	const SUPERVISOR = 1;
  	
  	/**
  	 * The value that represents a warehouse operator.							010
  	 * @var int
  	 */
  	const WAREHOUSE = 2;
  	
  	/**
  	 * The value that represents general staff.									100
  	 * @var int
  	 */
  	const GENERALSTAFF = 4;
}