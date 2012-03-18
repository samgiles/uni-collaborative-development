<?php
/**
 * Takes a web request and dispatches it appropriately using the parameters.
 * @author Samuel Giles
 * @package core
 */
class Dispatch {
	
	/**
	 * Dispatch a simple application that uses only a standard query string to identify the page.  
	 * With the controller defined by the {URI}?c={controllerName}&{restOfQueryString}
	 * @param  $requests  Typically the $_REQUESTS array.
	 * @param $posts Typically the $_POST array
	 * TODO Remove tightly coupled dependence on a query string - $_GET['c'] - in the determination of the controller.
	 */
	public static function get($requests, $posts){

		if (isset($requests['c'])){
			$controllerName = ((string)$requests['c']) . 'Controller';
			return new $controllerName();
		}
		return NULL; // TODO return 404 error controller.
	}
}