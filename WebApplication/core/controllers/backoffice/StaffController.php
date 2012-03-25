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
	  $sqlStatement = 'SELECT `st`.`CODE`, `su`.`F_NAME`, `su`.`L_NAME`, `su`.`USERNAME`, `su`.`EMAIL`, `OFFICE`.`DEPT`, `OFFICE`.`LOCATION`, `ADDRESS`.`LINE_ONE`, `ADDRESS`.`LINE_TWO`, `ADDRESS`.`POST_CODE` FROM `SYSTEM_USER` su JOIN `STAFF` st ON `su`.`CODE` = `st`.`USER_CODE`, `OFFICE`, `ADDRESS` WHERE `st`.`OFFICE_CODE` = `OFFICE`.`CODE` AND `ADDRESS`.`CODE` = `su`.`ADDRESS_CODE`';
	  
	  /**
			Vish
			
			Alright mate, the problem with this is the SQL statement, to save you the time I wrote the one you need below and tested, it does work, if not make sure you copied it exactly.
			
			
			In the view in content use the fields that are in between SELECT and FROM for example:
			
			Where you've got :
			
			echo $Staff['CODE']
			
			you'd use that but for each field that's defined below:
			
			echo $Staff['F_NAME']
			echo $Staff['L_NAME'] etc.etc.
			
			Leave this here for documentation purposes delete comment above   - Sam.
			_________________________________________________________________________________________
			
			SELECT 
				`st`.`CODE`,
				`su`.`F_NAME`, 
				`su`.`L_NAME`, 
				`su`.`USERNAME`, 
				`su`.`EMAIL`, 
				`OFFICE`.`DEPT`,
				`OFFICE`.`LOCATION`,
				`ADDRESS`.`LINE_ONE`, 
				`ADDRESS`.`LINE_TWO`, 
				`ADDRESS`.`POST_CODE`
			FROM
				`SYSTEM_USER` su JOIN `STAFF` st ON `su`.`CODE` = `st`.`USER_CODE`,
				`OFFICE`,
				`ADDRESS`
			WHERE
				`st`.`OFFICE_CODE` = `OFFICE`.`CODE` AND
				`ADDRESS`.`CODE` = `su`.`ADDRESS_CODE`
				
			_________________________________________________________________________________________

	   */
	  $result = Database::execute($sqlStatement);
	  $result = $result->fetchAll();
	var_dump ($result);  
	  $this->addViewVariable('Staff', $result);
	
	}
}