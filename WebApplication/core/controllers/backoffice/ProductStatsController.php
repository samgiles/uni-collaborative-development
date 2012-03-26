<?php 
/**
 * Displays information of a product, providing an interface for the viewing of sales figures and and interface to edit product details.
 * @author Samuel Giles
 * @package application-controllers
 */
class ProductStatsController extends Controller {

	private $_product;

	private $_range;

	private $_report;

	public function __construct() {
		$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'productstats.backoffice';
		
		$this->requiredAccess(AccessLevels::GENERALSTAFF | AccessLevels::ADMIN | AccessLevels::SUPERVISOR);
		
		if (isset($_GET['pid'])){
			$this->_product = Product::createFromId($_GET['pid']);
			$this->addViewVariable('product', $this->_product);
		}
		
		
		if(isset($_POST['description'])) {
			// Update description
			$this->productUpdateDescription($_POST['description']);
		}
		
		if (isset($_POST['price'])) {
			$this->productUpdatePrice($_POST['price']);
		}
		
		if (isset($_POST['reorderlevel'])) {
			$this->productUpdateReorderLevel($_POST['reorderlevel']);
		}
		
		if (isset($_POST['reorder'])) {
			// Run wholesale order..
		}
		
		$this->_product->save();
		
	}
	
	private function productUpdateReorderLevel($level) {
		$this->_product->setReorderLevel($level);
	}
	
	private function productUpdatePrice($price) {
		$this->_product->setUnitPrice($price);
	}
	
	private function productUpdateDescription($description) {
		$this->_product->setDescription($description);
	}
}