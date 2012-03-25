<?php
/**
 * PHP Test Controller.
 * 
 * TODO
 * 
 * @author Vishal Patel
 * @package application-controllers
 */
class CheckController extends Controller {
    
    public function __construct() {
    	$this->_skin = 'default';
		$this->_layout = 'main3';
		$this->_content = 'check';
		

	}
}