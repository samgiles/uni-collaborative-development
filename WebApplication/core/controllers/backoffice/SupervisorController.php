<?php
/**
 * 
 * @author Vishal Patel
 * @package application-controllers
 */
class SupervisorController extends Controller {
    
    public function __construct() {
    	$this->_skin = 'default';
		$this->_layout = 'main2';
		$this->_content = 'Supervisor';
		
        // testing
        if (!$this->requiredAccess(AccessLevels::SUPERVISOR)) {
          return;
        }
	}
}