<?php
class ConfirmationController extends Controller {
    
    public function __construct() {
		$this->_skin = 'default';
		$this->_layout = 'empty';
		$this->_content = 'confirmation';
		
        
        // Tell the view that we're an Index controller.
		$this->addViewVariable("c", "Index");
	}
} 