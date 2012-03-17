<?php
class WholesalerController extends Controller {
    
    public function __construct() {
		$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'wholesalers';
		
        $this->addViewVariable('wholesalers', array()); // testing with an emoty array..
        // Tell the view that we're an Index controller.
		$this->addViewVariable("c", "Wholesaler");
	}
}