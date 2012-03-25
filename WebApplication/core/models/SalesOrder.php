<?php
/**
 * 
 * @author Samuel Giles
 * @package application-models
 */
class SalesOrder {
  private $_basket;
  private $_custCode;
  
  public function __construct(ShoppingCart $cart) {
    $this->_basket = $cart;
    $this->_custCode = $cart->getCustomerCode();
  }
  
  public function save() {
    $sql = "INSERT INTO PURCHASE_INVOICE (DATE, CUSTOMER_CODE, PAYMENT_RECEIVED) VALUES (" . time() . ", {$this->_custCode}, 1)";
    $result = Database::execute($sql);
    $result = Database::execute("SELECT LAST_INSERT_ID() as CODE"); // Get the ID of the last inserted record.
    $result = $result->fetch(PDO::FETCH_ASSOC);
    $primaryKey = $result['CODE'];

    foreach($this->_basket->getItems() as $item) {
      // Get unit price
      $unitpriceSql = "SELECT UNIT_PRICE FROM PRODUCT WHERE CODE = {$item['CODE']}";
      $result = Database::execute($unitpriceSql);
      $result = $result->fetchAll();
      $price = $result[0]['UNIT_PRICE'];
       	
      $sql = "INSERT INTO PURCHASE_INVOICE_PRODUCT (PURCHASE_INVOICE_CODE, PRODUCT_CODE, QUANTITY, UNIT_PRICE) VALUES ({$primaryKey}, {$item['CODE']}, {$item['QUANTITY']}, {$price})";
      Database::execute($sql);
    }
  }
}