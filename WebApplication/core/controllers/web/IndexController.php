<?php
/**
 * The main index page.
 * @author Samuel Giles
 * @package application-controller
 * @subpackage application-controller-web
 * @version 0.4
 */
class IndexController extends Controller {
    
	public function __construct() {
		$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'index';
		
        
        // Tell the view that we're an Index controller.
		$this->addViewVariable("c", "Index");
	}
}