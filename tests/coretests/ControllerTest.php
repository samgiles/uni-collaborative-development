<?php

class MockController extends Controller {
  
  public function __construct() {
    $this->_skin 	= 'skin-2';
    $this->_layout 	= 'index';
    $this->_content = 'test';
    
    $this->_mockController->addViewVariable('array', array());
    $this->_mockController->addViewVariable('object', new stdClass());
    $this->_mockController->addViewVariable('scalarint', 10);
    $this->_mockController->addViewVariable('scalarstring', 'String');
  }
}


class ControllerTest extends PHPUnit_Framework_TestCase {
  
  private $_mockController;	
	
  public function __construct() {
    $this->_mockController = new MockController();
  }
  
  public function testGetSkin() {
  	$this->assertTrue($this->_mockController->getSkin() === 'skin-2');
  }
  
  public function testGetLayout() {
    $this->assertTrue($this->_mockController->getLayout() === 'index');
  }
  
  public function testGetContent() {
    $this->assertTrue($this->_mockController->getContent() === 'test');
  }
  
  public function testAddViewVariable() {
    
    // Verify they were added to the underlying PageModel.
    $pageModel = $this->_mockController->getPageModel();
    
    $this->assertTrue($pageModel->array() === array());
    $this->assertTrue($pageModel->object() == new stdClass());
    $this->assertTrue($pageModel->scalarint() === 10);
    $this->assertTrue($pageModel->scalarstring() === 'String');
  }
  
  
}