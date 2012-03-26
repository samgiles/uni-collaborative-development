<?php
class ProductListController extends Controller {
    
    public function __construct() {
		$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'product';
        

		
        if (isset($_GET['pid'])) {
          $product = Product::createFromId($_GET['pid']);
          $product = $this->addViewVariable('product', $product);
        } else {
          $this->addViewVariable('invalid_pcode', true);
        }
	}
}