<?php
/**
 * Order Confirmation Screen.
 * @author Hezekiah Lloyd Ball
 * @package application-controller
 * @subpackage application-controller-web
 * @version 0.0.1 - Not included yet -> TODO Set up redirect in CheckoutController on successful payment and order update.
 */
class ConfirmationController extends Controller {
    
    public function __construct() {
		$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'confirmation';
		
        
        // Tell the view that we're an Index controller.
		$this->addViewVariable("c", "Index");
	}
}