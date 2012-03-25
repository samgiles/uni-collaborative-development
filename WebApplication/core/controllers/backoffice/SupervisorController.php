<?php
/**
 * Provides the interface for viewing the list of Wholesalers.
 * @author Vishal Patel
 * @package application-controller
 * @version 0.2
 */
class WholesalerController extends Controller {
    
    public function __construct() {
		$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'Supervisor';
		
		$this->requiredAccess(AccessLevels::SUPERVISOR | AccessLevels::SUPERVISOR | AccessLevels::ADMIN);
        $this->getAllWholesalers();
        // Tell the view that we're an Index controller.
		$this->addViewVariable("c", "Supervisor");
	}
	}