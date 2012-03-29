<?php
/**
 * Stores information about a Salesrecord.
 * @author Samuel Giles
 * @package application-models
 */
 
class SalesRecord {
	
        /**
    *The base class for Salesrecord.  Salesrecord, control the processing that will occur in a web request.
	 */
    
	private $_product;
    
        /**
	 * The name of the product that will be used to render this Products output.
	 * @var string
	 */
    
	private $_startTime;
    
        /**
     * This is where the starttime
	 * @var string
	 */
    
	private $_days;
    
        /**
     * The name of t
     * @var string
	 */

	private $_figures;
	
	public function __construct(Product $product, $dayfrom, $monthfrom, $yearfrom, $numberOfDays, $overrideWithTime = null)  {
		$this->_product = $product;
		
		if ($overrideWithTime !== null) {
			$this->_startTime = $overrideWithTime;
		} else {
			$this->_startTime = mktime(0,0,0, $monthfrom, $dayfrom, $yearfrom);
		}
	
		$this->_days = $numberOfDays;
		$this->_figures = array();
	}
	
	public function run() {
		$this->_figures = array();
		
		for($i = 0; $i < $this->_days; ++$i) {
			$this->_figures[] = $this->getSalesForDate($this->_startTime + (86400 * $i));
		}
		return $this->_figures;
	}
	
	private function totalSql($start, $range, $productcode) {
		
		$sql = 
			'SELECT SUM(`PURCHASE_INVOICE_PRODUCT`.`QUANTITY` * `PURCHASE_INVOICE_PRODUCT`.`UNIT_PRICE`) AS TOTAL FROM `PURCHASE_INVOICE`, `PURCHASE_INVOICE_PRODUCT` WHERE `PURCHASE_INVOICE`.`CODE` = `PURCHASE_INVOICE_PRODUCT`.`PURCHASE_INVOICE_CODE` AND ' . 
			'`PURCHASE_INVOICE`.`DATE` > ' . $start . ' AND ' .
			'`PURCHASE_INVOICE`.`DATE` < '. ($start + $range) . ' AND ' .
			'`PURCHASE_INVOICE_PRODUCT`.`PRODUCT_CODE` = ' . $productcode . ' AND ' .
			'`PURCHASE_INVOICE`.`PAYMENT_RECEIVED` = 1'; 
		
		return $sql;
	}
	
	private function getSalesForDate($time) {

		$sql = $this->totalSql($time, 86400, $this->_product->getCode());
		
		$result = Database::execute($sql);
		
		$result = $result->fetchAll();
		
		if ($result) {
			return $result[0]['TOTAL'] ?: 0; // Coalesce to 0
		}
		
		return 0;
	}
}

