<?php
/**
 * Manages and Displays the checkout.
 * @author Samuel Giles
 * @package application_controller
 * @subpackage application_controller-web
 * @version 0.4
 */
class CheckoutController extends Controller {
    
	private $_cart;
	
    public function __construct() {
		$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'checkout';
		$this->_cart = new ShoppingCart();
		
		$this->getDetails();
		
		// Should probably move into new controller.
		if (isset($_GET['process'])) {
		  // Process payment...
		  // create new payment processor
		  $paymentProcessor = new PaymentProcessor();
		  $authorised = $paymentProcessor->authorisePayment(array()); // mock payment processor.
		  
		  // Create sales order, 
		  $order = new SalesOrder($this->_cart);
		  $order->save();
		  
		  $this->addViewVariable('paymentRecieved', $authorised);
		  // Clear the cart.
		  $this->_cart->clear();
		}

        // Tell the view that we're a Checkout controller.
		$this->addViewVariable("c", "Checkout");
	}
    
    private function getDetails() {
      // Get the current shopping cart.
      
    	$sql = "SELECT SYS_USER_CODE FROM CUSTOMER WHERE CODE =" . $this->_cart->getCustomerCode();
    	$result = Database::execute($sql);
    	$result = $result->fetchAll();

	  $this->addViewVariable('customer', User::getByCode($result[0]['SYS_USER_CODE']));
      $this->addViewVariable('notLoggedIn', $this->_cart->unavailable());
      $this->addViewVariable('cartItems', $this->_cart->getItems());
    }
}