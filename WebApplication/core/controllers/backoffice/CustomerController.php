<?php
/**
 * Provides the interface for viewing the list of Customer.
 * @author Vishal Patel
 * @package application-controller
 * @version 0.2
 */
class CustomerController extends Controller {
    
    public function __construct() {
        $this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'Customer';
		
		$this->requiredAccess(AccessLevels::WAREHOUSE | AccessLevels::SUPERVISOR | AccessLevels::ADMIN);
        $this->getAllCustomer();
        // Tell the view that we're an Index controller.
		$this->addViewVariable("c", "Customer");
	}
	
	
	private function getAllCustomer() {
	  $sqlStatement =
	  $result = Database::execute($sqlStatement);
	  $result = $result->fetchAll();
	  
	  $this->addViewVariable('Customer', $result);
	}
}

/**
      $sqlStatement NEEDS ADDING TO FUNCTION!!! *\