<?php
/**
 * Used to generate a JSON representation of sales figures for a Particular product.
 * @author Samuel Giles
 * @package application-controller
 * @subpackage application-controller-backoffice
 * @version 1.0
 */
class ProductAuditController extends Controller {

	private $_product;
	
	private $_range;
	
	private $_report;
	
	public function __construct() {
		$this->_skin = 'default';
		$this->_layout = 'empty';
		$this->_content = 'json/productaudit.json';
		
		if (!isset($_GET['pid'])) {
			$this->_content = 'json/error.json';
			$this->addViewVariable('errorMessage', "No product Id specified in request");
			return;
		}
		
		$this->_range = 7;
		
		$this->_product = Product::createFromId($_GET['pid']);
		
		if (isset($_GET['range'])){ // in number of days
			$this->_range = $_GET['range'];
		} else {
			$this->_range = 7; // 7 days
		}
		
		if (isset($_GET['day']) && isset($_GET['month']) && isset($_GET['year'])) {
			// Start
			$this->_report = new SalesRecord($this->_product, $_GET['day'], $_GET['month'], $_GET['year'], $this->_range);
			$timestamp = mktime(0, 0, 0, $_GET['month'], $_GET['day'], $_GET['year']);
		} else {
			// Use time and date 7 days ago from now.
			$timestamp = time() - 604800; // 604 800s number of secs in 7 days.
			$timestamp = $timestamp - ($timestamp % 86400); // round to previous midnight.
			$this->_report = new SalesRecord($this->_product, -1, -1, -1, $this->_range, $timestamp);
		}
		
		$this->addViewVariable('sales', $this->_report->run());
		$this->addViewVariable('startDate', date('d', $timestamp));
		$this->addViewVariable('startMonth', date('m', $timestamp));
		$this->addViewVariable('startYear', date('Y', $timestamp));
	}
}