<?php
class SearchController extends Controller {
 
 public function __construct() {
    $this->_skin = 'default';
    $this->_content = 'latestproducts';
    $this->_layout = 'main';
    
    
    // Check for a query -> 
    if (isset($_GET['q'])) {
      $query = $_GET['q'];  
    } else {
      $query = '';
    }
    
    // Set a flag to indicate to the view whether the query was empty.
    $empty = (strlen($query) <= 0);
    $this->addViewVariable('isEmptyQuery', $empty);
    
    if ($empty) {
     return;   
    }

   

    $this->addViewVariable('products', $this->getResult($query));
    $this->addviewVariable('searchTerm', $query);
    $this->addviewVariable('c', 'Search');
 }
 
 
 private function getResult($searchTerm) {
   $orderby = '';
   if (isset($_GET['desc'])) {              /// Order by, the output is counter intuitive for the desc and asc flags for the search.
     $orderby = 'ORDER BY UNIT_PRICE ASC' ;
   } else if (isset($_GET['asc'])) {
     $orderby = 'ORDER BY UNIT_PRICE DESC';
   }
    
   $sql = "SELECT * FROM PRODUCT WHERE (TITLE LIKE '%$searchTerm%'  OR  DESCRIPTION LIKE '%$searchTerm%') $orderby";
   $stment = Database::execute($sql);
   $result = $stment->fetchAll();
   $product = array();
   
   foreach($result as $prod) {
     $product[] = Product::createFromTuple($prod);
   }
      Logger::getLogger()->info("Result: " . print_r($product, true));
   return $product;
 }
 
}