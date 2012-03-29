<?php
/**
 * The games page.
 * @author Sameul Giles
 * @package application-controllers
 * @subpackage web-controllers
 * @version 0.4
 */
class GamesController extends Controller {
    
    public function __construct() {
		$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'Software.web';
		
		$this->loadProducts();
		
		
		$this->addViewVariable('pageTitle', "Games");
        $this->addViewVariable('c', 'Games');
	}
	
	private function loadProducts() {
		
		$sql = "SELECT CODE FROM PRODUCT WHERE CATEGORY = 0";
		$result = Database::execute($sql);
		$result = $result->fetchAll();
		
		$products = array();
		foreach ($result as $prod) {
			$products[] = Product::createFromId($prod['CODE']);
		}
		$this->addViewVariable('products', $products);
	}
	
}