<?php
/**
 * A simple payment processing service
 * @author Samuel Giles
 * @package application-core
 * @package application-core-models
 * @version 1.0
 */
class PaymentProcessor {
  
  /**
   * Implements a mock payment processing service.
   * @param array $paymentDetails An associative array containing payment details.
   */
  public function authorisePayment(array $paymentDetails) {
  	return true;
  }	

}