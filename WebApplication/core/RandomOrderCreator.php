<?php
/**
 * A small inefficient script that is used to generate loads of random sales data's
 * This isn't designed to be robust or anything, simply to be run once or twice for testing purposes.
 * @author Samuel Giles
 * @package tests
 * @version 0.4
 */

$dn = dirname(__FILE__);

$psdn = PATH_SEPARATOR . $dn; // Path separator and dn

// Set up the include paths.
$path = $dn .
'/com' . $psdn .
'/../auth' . $psdn .
'/../db' . $psdn .
'/../session' . $psdn .
'/../session/simple-sessions' . $psdn .
'/../session/simple-sessions/session_writers' . $psdn .
'/controllers' . $psdn .
'/controllers/web' . $psdn .
'/controllers/backoffice' . $psdn .
'/models' . $psdn .
'/models/user_accounts' . $psdn .
'/../auth/adapters';


set_include_path(get_include_path() . PATH_SEPARATOR . $path);


ini_set('display_errors', E_STRICT);
require('AutoLoad.php');
$time = microtime(true);

$timeNow = time();

for ($i = 0; $i < 100; ++$i) {
	$newTime = floor(rand(0, 640000));
	
	$sql = "INSERT INTO PURCHASE_INVOICE (DATE, CUSTOMER_CODE, PAYMENT_RECEIVED, POSTAGE_PRICE) VALUES (" . ($timeNow - $newTime) . ", 1, 1, 3.99)";
	$result = Database::execute($sql);
	$result = Database::execute("SELECT LAST_INSERT_ID() as CODE"); // Get the ID of the last inserted record.
	$result = $result->fetch(PDO::FETCH_ASSOC);
	$primaryKey = $result['CODE'];
	
	$a = 0;
	while ((rand(0, 10) < 8 && $a < 15) || $a < 1) {
		$a++;
		$quantity = rand(1, 6);
		$product = floor(rand(2, 10));
		$sql = "SELECT UNIT_PRICE FROM PRODUCT WHERE CODE=$product";
		$result = Database::execute($sql);
		
		$price = $result->fetchAll();
		$price = $price[0]['UNIT_PRICE'];
		
		$sql = "INSERT INTO PURCHASE_INVOICE_PRODUCT (PURCHASE_INVOICE_CODE, PRODUCT_CODE, QUANTITY, UNIT_PRICE) VALUES ({$primaryKey}, $product, $quantity, $price)";
		Database::execute($sql);
	}
}
echo "done in " . (microtime(true) - $time) . "s";