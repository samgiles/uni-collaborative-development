<?php
/**
 * A simple 404 error controller.
 * @author Samuel Giles
 * @package application_controller
 * @subpackage application_controller-web
 * @todo Generalise for any error not just 404.
 */
class ErrorController extends Controller {
	public function __construct() {
		$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'error.404';
	
	
		// Tell the view that we're an Index controller.
		$this->addViewVariable("c", "Error");
	}
}