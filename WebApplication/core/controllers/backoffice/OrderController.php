<?php
/**
 * No Description TODO: Write Description
 * @author Nadeem Alam
 * @package application-controller
 * @subpackage application-controller-backoffice
 */
class OrderController extends Controller {
    
    public function __construct() {
		$this->_skin = 'default';
		$this->_layout = 'main2';
		$this->_content = 'CreateOrderBackOffice';
	}
}