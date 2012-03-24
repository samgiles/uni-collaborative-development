<?php
class WholesalerController extends Controller {
    
    public function __construct() {
    	$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'wholesalers';
		
		$this->requiredAccess(AccessLevels::WAREHOUSE | AccessLevels::SUPERVISOR | AccessLevels::ADMIN);
        $this->getAllWholesalers();
        // Tell the view that we're an Index controller.
		$this->addViewVariable("c", "Wholesaler");
	}
}