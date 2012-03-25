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

		
		$this->getAllProducts();
		// Tell the view that we're an Index controller.
		$this->addViewVariable("c", "Product");
	}


	private function getAllProducts() {
		$sqlStatement = 'SELECT  `PRODUCT`.`CODE`,`PRODUCT`.`PHOTOGRAPH`, `PRODUCT`.`STOCK_LEVEL`, `PRODUCT`.`REORDER_LEVEL`, `PRODUCT`.`DOWNLOAD_COUNT`, `PRODUCT`.`UNIT_PRICE`, `PRODUCT`.`WHOLESALER_CODE`,`PRODUCT`.`WHOLESALE_COST`,`PRODUCT`.`DESCRIPTION`,`PRODUCT`.`TITLE`,`PRODUCT`.`CATEGORY`, FROM PRODUCT';
		$result = Database::execute($sqlStatement);
		$result = $result->fetchAll();
		 
		$this->addViewVariable('wholesalers', $result);
	}
}