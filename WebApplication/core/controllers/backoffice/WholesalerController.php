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
	
	
	private function getAllWholesalers() {
	  $sqlStatement = 'SELECT  `WHOLESALER`.`CODE`,`WHOLESALER`.`NAME`, `WHOLESALER`.`CONTACT_NAME`, `WHOLESALER`.`CONTACT_NUMBER`, `ADDRESS`.`LINE_ONE`, `ADDRESS`.`LINE_TWO`, `ADDRESS`.`POST_CODE` FROM WHOLESALER, ADDRESS WHERE `WHOLESALER`.`ADDRESS_CODE` = `ADDRESS`.`CODE`';
	  $result = Database::execute($sqlStatement);
	  $result = $result->fetchAll();
	  
	  $this->addViewVariable('wholesalers', $result);
	}
}