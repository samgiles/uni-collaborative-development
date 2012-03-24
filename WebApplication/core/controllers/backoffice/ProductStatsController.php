<?php 
class ProductStatsController extends Controller {

	private $_product;

	private $_range;

	private $_report;

	public function __construct() {
		$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'productstats.backoffice';
		
		
		if (isset($_GET['pid'])){
			$this->addViewVariable('product', Product::createFromId($_GET['pid']));
		}
	}
}