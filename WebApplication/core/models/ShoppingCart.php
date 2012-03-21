<?php
/**
 * A Shopping Cart model that can persist across a single session and store basket information in the database.
 * @author Samuel Giles
 * TODO:  Update this when Product Models are created.
 * @package application-models
 */
class ShoppingCart {
	
	/**
	 * An associative array of items that are currently in the shopping basket.
	 * @var array
	 */
	private $_items;
	
	/**
	 * Logging object.
	 * @var Logger
	 */
	private $_logger;
	
	/**
	 * If the customer is logged in, then this will represent the customer code, if the user is not logged in then this will be NULL.
	 */
	public $_customerCode;
	
	/**
	 * Constructs a Shopping basket, loading the current users basket from the database.
	 * Enter description here ...
	 */
	public function __construct() {
		// Get the logger object.
		$this->_logger = Logger::GetLogger();
		
		// If the shopping cart session data is set then get the customer code from the ShoppingCartSession object.
        $login = Session::get('login');
		if ($login !== NULL) {
			$getCode = Database::execute("SELECT CODE FROM CUSTOMER WHERE SYS_USER_CODE = {$login['dbid']}");
			$result = $getCode->fetch(PDO::FETCH_ASSOC);
			$this->_customerCode = $result['CODE'];
			$this->_logger->info("Customer Code: " . $this->_customerCode);
		} else {
			$this->_customerCode = NULL;
            $this->_items = NULL;
            return;
		}
		// Load the Shopping cart from the database.
		$this->loadFromQuery();

	}
	
	public function clear() {
		$sql = 'DROP FROM SHOPPING_CART WHERE CUSTOMERCODE = ' . $this->_customerCode;
		Database::execute($sql);
		$this->_items = array();
	}
	
	public function getCustomerCode() {
	  return $this->_customerCode;
	}
	
    public function unavailable() {
      return $this->_customerCode === NULL;  
    }
    
	/**
	 * Gets an associative array containing the items in the shopping basket.
	 */
	public function getItems() {
		return $this->_items;
	}
	
	/**
	 * Removes a product from the shopping basket and consequently the database.
	 * @param int $productCode The product code to remove from the basket.
	 * @param int $quantity The quantity of the product to remove from the basket.
	 */
	public function removeProduct($productCode, $quantity) {
		
		$cartSQL = 'DELETE FROM SHOPPING_CART WHERE PRODUCTCODE = ' . $productCode . ' AND CUSTOMERCODE = ' . $this->_customerCode . ' LIMIT ' . $quantity; // Integrate with log in system.
		$statement = Database::execute($cartSQL);	
		
		$this->_logger->info('Executed Remove Statement: ' . $cartSQL);
		
		$this->_items[$productCode]['QUANTITY'] -= $quantity;
		
		if ($this->_items[$productCode]['QUANTITY'] <= 0) {
			unset($this->_items[$productCode]);
		}
	}
	
	/**
	 * Adds a product to the basket.
	 * @param unknown_type $productCode TODO
	 * @param unknown_type $quantity TODO
	 */
	public function addProduct($productCode, $quantity) {
		
		
		$values = '';
		
		$time = time();
		for ($i = 0; $i < $quantity; ++$i) {
			$values .= '(' . $this->_customerCode . ' , ' . $productCode . ', ' . $time .')';
			
			if ($i >= $quantity) {
				$values .= ',';
			}
		}
		
		$cartSQL = '
			INSERT INTO 
				SHOPPING_CART
				(CUSTOMERCODE, 
				 PRODUCTCODE, 
				 TIMESTAMP)
			VALUES ' . $values;
		
		$statement = Database::execute($cartSQL);
		$this->_logger->info('Executed INSERT statement. ' . $cartSQL);
		
		if (array_key_exists($productCode, $this->_items)) {
			$this->_items[$productCode]['QUANTITY'] += 1;
		} else {
			// Lazy.
			$this->loadFromQuery();
		}
	}
	
	public function checkCanAddToBasket($productCode, $quantity) {
		$sql = 'SELECT COUNT(TIMESTAMP) AS BASKET_QUANTITY, STOCK_LEVEL FROM SHOPPING_CART, PRODUCT WHERE SHOPPING_CART.PRODUCTCODE = ' . $productCode . ' AND PRODUCT.CODE = ' . $productCode;
		$statement = Database::execute($sql);
		
		$result = $statement->fetchAll();
		return ShoppingCart::checkStockLevels($result[0]['BASKET_QUANTITY'], $result[0]['STOCK_LEVEL'], $quantity);
	}
	
	
	public static function checkStockLevels($softLevel, $stockLevel, $quantity) {
		$level = $stockLevel - $softLevel;
		
		if ($level > 0) {
			$newLevel = $level - $quantity;
			if ($newLevel >= 0) {
				return $quantity;
			} else {
				return $quantity + $newLevel;
			}
		} else {
			return 0;
		}
	}
	
	/**
	 * TODO
	 * @see Model::loadFromQuery()
	 */
	public function loadFromQuery() {
        
		$cartSQL = 'SELECT 
					PRODUCT.CODE, PRODUCT.TITLE, PRODUCT.UNIT_PRICE, PRODUCT.STOCK_LEVEL, PRODUCT.PHOTOGRAPH
					FROM 
					SHOPPING_CART, PRODUCT 
					WHERE 
					SHOPPING_CART.PRODUCTCODE = PRODUCT.CODE AND (
					SHOPPING_CART.CUSTOMERCODE = ' . $this->_customerCode . ')';
		
		$statement = Database::execute($cartSQL);
		$result = $statement->fetchAll();
		$this->_logger->info("Loaded From Query: $cartSQL ---- " . print_r($result, true));
		
		$newResult = array();
		
		foreach($result as $value) {
			if (array_key_exists($value['CODE'], $newResult)) {
				$newResult[$value['CODE']]['QUANTITY'] += 1;
				continue;
			} else {
				$value['QUANTITY'] = 1;
				$newResult[$value['CODE']] = $value;
			}
		}
		
		$this->_logger->info("Loaded From Query: $cartSQL ---- " . print_r($newResult, true));
		
		$this->_items = $newResult;
	}
}