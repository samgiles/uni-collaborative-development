<?php
/**
 * No Description TODO: Write description
 * @author Nadeem Alam
 * @package application-controllers
 */
class StockCheckController extends Controller {
    
    public function __construct() {
        $this->_skin = 'default';
		$this->_layout = 'main2';
		$this->_content = 'stockcheck';
        
	}
}