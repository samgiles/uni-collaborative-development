<?php
class ErrorController extends Controller {
	public function __construct() {
		$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'error.404';
	
	
		// Tell the view that we're an Index controller.
		$this->addViewVariable("c", "Error");
	}
}