<?php
/**
 * Provides an abstract interface for an Observer object.  To be used when implementing an Observer pattern.
 * @author Samuel Giles
 * @package core-com
 * @subpackage core
 * @version 0.2
 */
abstract class Observer {
	abstract public function update (Observable $subject);
}