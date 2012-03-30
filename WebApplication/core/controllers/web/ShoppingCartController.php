<?php
/**
 * Handles the Shopping cart.
 * @author Samuel Giles
 * @package application_controller
 * @subpackage application_controller-web
 * @version 0.8
 * @todo Update and refactor to use the Product model.
 */
class ShoppingCartController extends Controller {
	
	private $_cart;
	
	public function __construct() {
		$this->_skin = 'default';
		$this->_content = 'cart';
		$this->_layout = 'cart';
		
        $this->_cart = new ShoppingCart();
        
        $this->addViewVariable('notLoggedIn', $this->_cart->unavailable());
        
		if (isset($_REQUEST['productid'])) {
			$productId = $_REQUEST['productid'];
			if (isset($_REQUEST['add'])) {
				// Add product.
				if (isset($_REQUEST['quantity'])) {
					$this->addItem($productId, $_REQUEST['quantity']);
				} else {
					$this->addItem($productId, 1);
				}
			} else if (isset($_REQUEST['remove'])) {

				if (isset($_REQUEST['quantity'])) {
					$this->removeItem($productId, $_REQUEST['quantity']);
				} else {
					$this->removeItem($productId, 1);
				}
			}
		}
		
		$this->addViewVariable('cart', $this->_cart->getItems());
	}
	
	public function addItem($itemId, $quantity) {	
		
		$this->cleanCarts();
		
		$amount = $this->_cart->checkCanAddToBasket($itemId, $quantity);
		
		if ($amount <= 0) {
			// Warn the user.
			$this->addViewVariable("warnOutOfStock", TRUE);
			return;
		} else if ($amount < $quantity) {
			$this->addViewVariable("warnNotEnoughStock", array('ORIGINAL' => $quantity, 'AMOUNT' => $amount));
		}
		
		$this->_cart->addProduct($itemId, $amount);
	}
	
	public function removeItem($itemId, $quantity) {
		$this->_cart->removeProduct($itemId, $quantity);
	}
	
	public function cleanCarts() {
		$time = time();
		Database::execute('DELETE FROM SHOPPING_CART WHERE (TIMESTAMP + 7200) <  ' . $time);
	}
}