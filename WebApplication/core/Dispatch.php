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
	 */
	public static function get($requests){
		if (isset($requests['c'])){
			$controllerName = ((string)$requests['c']) . 'Controller';
			if (class_exists($controllerName, true)) {
				return new $controllerName();
			} else {
				return new ErrorController();
			}
		}
		return new IndexController(); // just default to this.
	}
}