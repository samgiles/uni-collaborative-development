<?php
class IndexController extends Controller {
    
	public function __construct() {
		$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'index';
		
        
        // Tell the view that we're an Index controller.
		$this->addViewVariable("c", "Index");
	}
}