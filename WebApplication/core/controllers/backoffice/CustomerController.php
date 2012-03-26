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
      $sqlStatement = 'SELECT `CUSTOMER`.`CODE`,`CUSTOMER`.`USERNAME`, `CUSTOMER`.`F_NAME`, `CUSTOMER`.`L_NAME`, `CUSTOMER`.`PHONE_NUMBER`, `CUSTOMER`.`EMAIL`, `OFFICE`.`LOCATION`, `ADDRESS`.`LINE_ONE`, `ADDRESS`.`LINE_TWO`, `ADDRESS`.`POST_CODE`  FROM `SYSTEM_USER` su JOIN `STAFF` st ON `su`.`CODE` = `st`.`USER_CODE`, `OFFICE`, `ADDRESS` WHERE `st`.`OFFICE_CODE` = `OFFICE`.`CODE` AND `ADDRESS`.`CODE` = `su`.`ADDRESS_CODE`';
	  $result = Database::execute($sqlStatement);
	  $result = $result->fetchAll();
	  
	  $this->addViewVariable('Customer', $result);
	}
}