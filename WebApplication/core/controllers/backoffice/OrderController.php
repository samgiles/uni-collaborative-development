<?php
/**
 * No Description TODO: Write Description
 * @author Nadeem Alam
 * @package application-controllers
 */
class OrderController extends Controller {
    
    public function __construct() {
		$this->_skin = 'default';
		$this->_layout = 'main2';
		$this->_content = 'CreateOrderBackOffice';
	}
}