<?php
/**
 * An abstract SessionWriter test for writing more than one Session writer test.
 * @author Samuel Giles
 * @package unit-tests
 */
abstract class SessionWriterTest extends PHPUnit_Framework_TestCase {
  protected $_writer;	
	
  public function __construct(SessionWriter $writer) {
    $this->_writer = $writer;
  }
}