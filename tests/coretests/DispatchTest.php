<?php
/**
 * A mock controller, the name is irrelevant.
 * @author Samuel Giles
 */
class AnObscureController extends Controller {
}

class DispatchTests extends PHPUnit_Framework_TestCase {
  
  /**
   * Test's the application dispatch method.
   * */
  public function testDispatch() {
    $controller = Dispatch(array('c' => 'AnObscure'), array());
    $this->assertTrue($controller !== NULL);
    $this->assertInstanceOf('AnObscureController', $controller);
    
    // No controller specified.
    $controller = Dispatch(array(), array());
    $this->assertTrue($controller === NULL);
  }
	
}