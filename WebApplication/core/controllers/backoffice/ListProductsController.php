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
		$sqlStatement = 'SELECT  * FROM PRODUCT';
		$result = Database::execute($sqlStatement);
		$result = $result->fetchAll();
		 
		$this->addViewVariable('products', $result);
	}
}