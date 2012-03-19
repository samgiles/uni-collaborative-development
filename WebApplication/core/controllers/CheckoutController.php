<?php
class CheckoutController extends Controller {
    
    public function __construct() {
		$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'checkout';
		
        $this->getDetails();
        
        // Tell the view that we're a Checkout controller.
		$this->addViewVariable("c", "Checkout");
	}
    
    private function getDetails() {
      // Get the current shopping cart.
      $cart = new ShoppingCart();
      $this->addViewVariable('notLoggedIn', $cart->unavailable());
      $this->addViewVariable('cartItems', $cart->getItems());
    }
}