<?php
/**
 * Provides the interface for viewing the list of Customer.
 * @author Vishal Patel
 * @package application-controller
 * @subpackage application-controller-backoffice
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
      $sqlStatement = 'SELECT `CUSTOMER`.`CODE`,`su`.`USERNAME`, `su`.`F_NAME`, `su`.`L_NAME`, `su`.`PHONE_NUMBER`, `su`.`EMAIL`, `ADDRESS`.`LINE_ONE`, `ADDRESS`.`LINE_TWO`, `ADDRESS`.`POST_CODE`  FROM `SYSTEM_USER` su JOIN `CUSTOMER` ON `su`.`CODE` = `CUSTOMER`.`SYS_USER_CODE`, `ADDRESS` WHERE `ADDRESS`.`CODE` = `su`.`ADDRESS_CODE`';
	  $result = Database::execute($sqlStatement);
	  $result = $result->fetchAll();
	  
	  $this->addViewVariable('Customer', $result);
	}
}

/**
      $sqlStatement NEEDS ADDING TO FUNCTION!!! */