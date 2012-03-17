<?php
/**
 * Takes a web request and dispatches appropriately.
 * @author Samuel Giles
 *
 */
class Dispatch {
	
	/**
	 * Dispatch a simple application that uses only a standard query string to identify the page.  
	 * With the controller defined by the {URI}?c={controllerName}&{restOfQueryString}
	 * @param  $requests  Typically the $_REQUESTS array.
	 * @param $posts Typically the $_POST array
	 */
	public static function get($requests, $posts){

		if (isset($requests['c'])){
			$controllerName = ((string)$requests['c'])."Controller";
			return new $controllerName();
		}
		
	}
}