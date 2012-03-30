<?php
/**
 * The software page.
 * @author James Legros, Samuel Giles
 * @package application-controller
 * @subpackage application-controller-web
 * @version 0.4
 */
class SoftwareController extends Controller {
    
    public function __construct() {
		$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'Software.web';
		
		$this->loadProducts();
		
		
		$this->addViewVariable('pageTitle', "Software");
        $this->addViewVariable('c', 'Software');
	}
	
	private function loadProducts() {
		
		$sql = "SELECT CODE FROM PRODUCT WHERE CATEGORY = 1";
		$result = Database::execute($sql);
		$result = $result->fetchAll();
		
		$products = array();
		foreach ($result as $prod) {
			$products[] = Product::createFromId($prod['CODE']);
		}
		$this->addViewVariable('products', $products);
	}
	
}