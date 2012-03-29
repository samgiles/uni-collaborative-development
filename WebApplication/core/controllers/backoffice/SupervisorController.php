<?php
/**
 * Provides the interface for viewing the list of Supervisor.
 * @author Vishal Patel
 * @package application-controller
 * @version 0.2
 */
class SupervisorController extends Controller {
    
    public function __construct() {
        $this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'Supervisor';
		
		$this->requiredAccess(AccessLevels::SUPERVISOR | AccessLevels::ADMIN);
        $this->getAllSupervisor();
        // Tell the view that we're a Supervisor controller.
		$this->addViewVariable("c", "Supervisor");
	}
	
	
	private function getAllSupervisor() {
	  $sqlStatement = "";
	  $result = Database::execute($sqlStatement);
	  $result = $result->fetchAll();
	  
	  $this->addViewVariable('Supervisor', $result);
	}
}

/** $sqlStatement NEEDS ADDING TO FUNCTION!!! */