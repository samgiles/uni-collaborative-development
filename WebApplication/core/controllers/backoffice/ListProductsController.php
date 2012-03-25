<?php
/**
 * Provides the interface for viewing the list of ListProducts
 * @author Samuel Giles
 * @package application-controller
 * @version 0.2
 */
class ListProductsController extends Controller {

	public function __construct() {
		$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'products';

		//$this->requiredAccess(AccessLevels::WAREHOUSE | AccessLevels::SUPERVISOR | AccessLevels::ADMIN);
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