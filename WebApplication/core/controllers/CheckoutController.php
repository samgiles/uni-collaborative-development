<?php
class CheckoutController extends Controller {
    
	private $_cart;
	
    public function __construct() {
		$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'checkout';
		$this->_cart = new ShoppingCart();
		
		
		// Should probably move into new controller.
		if (isset($_GET['process'])) {
		  // Process payment...
		  // create new payment processor
		  $paymentProcessor = new PaymentProcessor();
		  $authorised = $paymentProcessor->authorisePayment(array()); // mock payment processor.
		  
		  // Create sales order, 
		  $order = new SalesOrder($this->_cart);
		  $order->update();
		  
		  $this->addViewVariable('paymentRecieved', $authorised);
		}
		
		$this->getDetails();
        
        
        
        // Tell the view that we're a Checkout controller.
		$this->addViewVariable("c", "Checkout");
	}
    
    private function getDetails() {
      // Get the current shopping cart.
      
      $this->addViewVariable('notLoggedIn', $this->_cart->unavailable());
      $this->addViewVariable('cartItems', $this->_cart->getItems());
    }
}