<?php

class PageModelTests extends PHPUnit_Framework_TestCase {
  
  /**
   * Test's the application dispatch method.
   * */
  public function testAddKeyValue() {
    $pagemodel = new PageModel();
    
    $pagemodel->addPageVariable('a', 'First Value');
  	$pagemodel->addPageVariable('b', array('a' => 0));
  	
  	return $pagemodel;
  }
	
  /**
   * 
   * Enter description here ...
   * @param PageModel $pageModel
   * @depends testAddKeyValue
   */
  public function testGetKeyValue(PageModel $pageModel) {
    $this->assertTrue($pageModel->doesntexist() === NULL);
    
    // Should be case sensitive keys.
    $this->assertTrue($pageModel->A() === NULL);
    
    $this->assertTrue($pageModel->a() === 'First Value');
    $this->assertTrue($pageModel->b() === array('a' => 0));
  }
}