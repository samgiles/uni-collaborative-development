<?php
class LatestProductsController extends Controller {
 
 public function __construct() {
  $this->_skin = 'default';
  $this->_layout = 'empty';
  $this->_content = 'latestproducts';
  
  // Ideally we need to load from database some random titles.
  $this->addViewVariable('products', array(0 => Product::createFromId(1), 1 => Product::createFromId(2))); // $product is typeof Product.
 }
    
    
}