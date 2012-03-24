<?php
class StaffController extends Controller {
    
    public function __construct() {
    	$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'Staff';
		
		$this->requiredAccess(AccessLevels::GENERALSTAFF | AccessLevels::SUPERVISOR | AccessLevels::ADMIN);
        $this->getAllStaff();
        // Tell the view that we're an Index controller.
		$this->addViewVariable("c", "Staff");
        
    } 
	
	private function getAllStaff() {
	  $sqlStatement = 'SELECT  `STAFF`.`CODE`, `NAME`,`ADDRESS`.`LINE_ONE`, `ADDRESS`.`LINE_TWO`, `ADDRESS`.`POST_CODE` FROM WHOLESALER, ADDRESS WHERE `WHOLESALER`.`ADDRESS_CODE` = `ADDRESS`.`CODE`';
	  $result = Database::execute($sqlStatement);
	  $result = $result->fetchAll();
	  
	  $this->addViewVariable('Staff', $result);
	}
}