<?php
/**
 * A controller that can be used to display some products in a simple graphical list.
 * @author Samuel Giles
 * @package application-controllers
 * @subpackage web-controllers
 * @version 0.1.
 */
class LatestProductsController extends Controller {
 
 public function __construct() {
  $this->_skin = 'default';
  $this->_layout = 'empty';
  $this->_content = 'latestproducts';
  
  // Ideally we need to load from database some random titles.
  $this->addViewVariable('products', array(0 => Product::createFromId(2), 1 => Product::createFromId(3), 2 => Product::createFromId(4))); // $product is typeof Product.
 }
    
    
}