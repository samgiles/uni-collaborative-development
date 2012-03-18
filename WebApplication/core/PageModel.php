<?php
/**
 * The page model is used to store variables generated by a controller in a hash map, this is then passed to the View template to be rendered.
 * @author Samuel Giles
 * @package core
 */
class PageModel {
	
	protected $_pageVariables = array();
	
	/**
	 * Magic method used to retrieve a variable from the underlying hash map.  If the value does not exist NULL will be returned.
	 * @see http://uk.php.net/manual/en/language.oop5.overloading.php#object.call for more information on magic methods.
	 */
	public function __call($name, $args) {
		if (array_key_exists($name, $this->_pageVariables)){
			return $this->_pageVariables[$name];
		}
		
		return NULL;
	}
	
	/**
	 * Adds a key/value to the underlying hash map.
	 * @param string $key The key that will be used to refer to the variable.
	 * @param mixed $value The value of the variable.
	 */
	public function addPageVariable($key, $value){
		$this->_pageVariables[$key] = $value;
	}
}