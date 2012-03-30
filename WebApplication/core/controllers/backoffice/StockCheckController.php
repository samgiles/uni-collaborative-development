<?php
/**
 * No Description TODO: Write description
 * @author Nadeem Alam
 * @package application_controller
 * @subpackage application_controller-backoffice
 */
class StockCheckController extends Controller {
    
    public function __construct() {
        $this->_skin = 'default';
		$this->_layout = 'main2';
		$this->_content = 'stockcheck';
        
	}
}