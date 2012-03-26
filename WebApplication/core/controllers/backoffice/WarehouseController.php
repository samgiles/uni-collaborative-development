<?php
/**
 * Provides the interface for viewing the list of Warehouse.
 * @author Vishal Patel
 * @package application-controller
 * @version 0.2
 */
class WarehouseController extends Controller {
    
    public function __construct() {
    	$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'Warehouse';
		
		$this->requiredAccess(AccessLevels::WAREHOUSE | AccessLevels::SUPERVISOR | AccessLevels::ADMIN);
        $this->getAllWarehouse();
        // Tell the view that we're an Index controller.
		$this->addViewVariable("c", "Warehouse");
	}
	
	
	private function getAllWarehouse() {
	  $sqlStatement = "";
	  $result = Database::execute($sqlStatement);
	  $result = $result->fetchAll();
	  
	  $this->addViewVariable('Warehouse', $result);
	}
}

/**
      $sqlStatement NEEDS ADDING TO FUNCTION!!! */