<?php
abstract class SessionWriterTest extends PHPUnit_Framework_TestCase {
  protected $_writer;	
	
  public function __construct(SessionWriter $writer) {
    $this->_writer = $writer;
  }
}