<?php
/**
 * A mock controller, the name is irrelevant.
 * @author Samuel Giles
 * @package unit-tests
 */
class AnObscureController extends Controller {
}

/**
 * A mock controller.
 * @author Samuel Giles
 * @package unit-tests
 */
class IndexController extends Controller {
}

/**
 * Tests the Dispatcher
 * @author Samuel Giles
 * @package unit-tests
 */
class DispatchTests extends PHPUnit_Framework_TestCase {
  
  /**
   * Test's the application dispatch method.
   * */
  public function testDispatch() {
    $controller = Dispatch::get(array('c' => 'AnObscure'), array());
    $this->assertTrue($controller !== NULL);
    $this->assertInstanceOf('AnObscureController', $controller);
    
    // No controller specified.
    $controller = Dispatch::get(array(), array());
    $this->assertTrue($controller instanceof IndexController);
  }

}