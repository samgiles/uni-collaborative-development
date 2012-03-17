<?php
class PageModel {
	
	protected $_pageVariables = array();
	
	public function __call($name, $args) {
		if (array_key_exists($name, $this->_pageVariables)){
			return $this->_pageVariables[$name];
		}
	}
	
	public function addPageVariable($key, $value){
		$this->_pageVariables[$key] = $value;
	}
}