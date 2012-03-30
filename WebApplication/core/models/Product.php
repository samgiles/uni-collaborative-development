<?php
/**
 * 
 * @author Samuel Giles
 * @package application-core
 * @package application-core-models
 */
class Product {
    
    private $_code;
    
        /**
	 * 
	 */
    private $_photoPath;
    
            /**
     * 
	 */
    private $_stockLevel;
    
            /**
     * 
	 */
     private $_unitPrice;
    
            /**
     * 
	 */
     private $_description;
    
            /**
     * 
	 */
    private $_title;
    
            /**
     * 
	 */
    
    // Back Office stuff: i.e. Customers don't need to touch this.
    private $_reorderLevel;
    
            /**
     * 
	 */
    private $_downloadCount;
    
            /**
     * 
	 */
    private $_wholesalerCode;

            /**
     * 
	 */
    private $_wholesaleCost;
    
            /**
     * 
	 */
     private $_logger;
    
    private function __construct($recordId = NULL) {
     $this->_logger = Logger::getLogger();
     if ($recordId === NULL) {
      return;   
     }
     
     $this->_code = $recordId;
     $this->loadFromQuery();
    }
    
    
    public static function createFromId($recordId) {
     return new Product($recordId);   
    }
    
            /**
     * This
	 */
    
    public static function createFromTuple($dbTuple) {
      $prod = new Product();
      $prod->_code = $dbTuple['CODE'];
      $prod->_photoPath = $dbTuple['PHOTOGRAPH'];
      $prod->_unitPrice = $dbTuple['UNIT_PRICE'];
      $prod->_description = $dbTuple['DESCRIPTION'];
      $prod->_title = $dbTuple['TITLE'];
      $prod->_stockLevel = $dbTuple['STOCK_LEVEL'];
      $prod->_reorderLevel = $dbTuple['REORDER_LEVEL'];
      $prod->_downloadCount = $dbTuple['DOWNLOAD_COUNT'];
      $prod->_wholesalerCode = $dbTuple['WHOLESALER_CODE'];
      $prod->_wholesaleCost = $dbTuple['WHOLESALE_COST'];
      return $prod;
    }
    
    public function save() {
         if ($this->_code == NULL || !isset($this->_code)) {
         	// New
         } else {
         	// Update
         	// Will need to UPDATE.
         	$pdostatement = Database::execute("UPDATE PRODUCT SET STOCK_LEVEL='{$this->getStockLevel()}', UNIT_PRICE='{$this->getUnitPrice()}', DESCRIPTION='{$this->getDescription()}', REORDER_LEVEL='{$this->getReorderLevel()}' WHERE CODE={$this->getCode()}");
         		
         	if ($pdostatement === false) {
         		$this->_logger->logController("Product->save(" . print_r($this, true) . ") UPDATE returned false.", 'Model::Product', 'Model - INSTANCE');
         		throw new Exception("Query failed to execute correctly.");
         	}
         }
    }
    
    public function delete() {
    }
    
    public static function createNew() {
      
    }
    
    public function loadFromQuery() {
      $sql = 'SELECT * FROM PRODUCT WHERE CODE = ' . $this->_code;
      $this->_logger->info("Executing Query: $sql");
      $statement = Database::execute($sql); // $statement is a pdo statement.
      
      $result = $statement->fetchAll();
      $this->_photoPath = $result[0]['PHOTOGRAPH'];
      $this->_stockLevel = $result[0]['STOCK_LEVEL'];
      $this->_unitPrice = $result[0]['UNIT_PRICE'];
      $this->_description = $result[0]['DESCRIPTION'];
      $this->_title = $result[0]['TITLE'];
      
      $this->_reorderLevel = $result[0]['REORDER_LEVEL'];
      $this->_downloadCount = $result[0]['DOWNLOAD_COUNT'];
      $this->_wholesalerCode = $result[0]['WHOLESALER_CODE'];
      $this->_wholesaleCost = $result[0]['WHOLESALE_COST'];
    }
                /**
     * sets the Decription
     */
    public function setDescription($description) {
    	$this->_description = $description;
    }
                    /**
     * sets the ReorderLevel
     */
    public function setReorderLevel($level) {
    	$this->_reorderLevel = $level;
    } 
                        /**
     * sets the PhotoPath
     */
    public function setPhotoPath($path) {
    	$this->_photoPath = $path;
    }
                            /**
     * sets the StockLevel
     */
    public function setStockLevel($level) {
    	$this->_stockLevel = $level;
    }
                            /**
     * sets the UnitPrice
     */
    public function setUnitPrice($price) {
    	$this->_unitPrice = $price;
    }
                                /**
     * sets the Code
     */
    public function getCode() {
      return $this->_code;   
    }
                                    /**
     * sets the ReorderLevel
     */
    public function getReorderLevel() {
      return $this->_reorderLevel;
    }
    
    public function getDownloadCount() {
      return $this->_downloadCount;   
    }
    
    public function getWholesalerCode() {
      return $this->_wholesalerCode;   
    }
    
    public function getWholesaleCost() {
      return $this->_wholesaleCost;   
    }
    
    public function getPhotoPath() {
      return $this->_photoPath;
    }
    
    public function getStockLevel() {
      return $this->_stockLevel;
    }
    
    public function getUnitPrice() {
      return $this->_unitPrice;   
    }
    
    public function getDescription() {
      return $this->_description;   
    }
    
    public function getTitle() {
      return $this->_title;
    }
}