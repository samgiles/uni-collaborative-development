<?php
/**
 * The view engine.  Handles creating the interface and outputting the interface.
 * @author Samuel Giles
 * @package core
 */
class View {
	
	/**
	 * The Controller that this View wil interact with.
	 * @var unknown_type
	 */
	protected $_controller;
	
	/**
	 * The name of the skin that this view is going to use.  Conceptually this is the folder name that contains the layout and content fragments.
	 * @var string
	 */
	protected $_skinName;
	protected $_layoutName;
	
	protected $_contentName;
	
	
	
	public function __construct( $controller){
		$this->_controller = $controller;
		$this->_skinName = $controller->getSkin();
		$this->_layoutName = $controller->getLayout();
		$this->_contentName = $controller->getContent();
	}
	
	/**
	 * Magic method if the method doesn't exist we'll call the method in the pagemodel.  Allows us to use the following form in the View fragments:  <code><?php echo $this->dtd(); ?></code>
	 * This example gets the dtd variable from the page model providing the dtd key has been set.
	 * @param $name The name of the object.
	 */
	public function __call($name){
		if (!method_exists($this, $name)){
			return $this->_controller->getPageModel()->$name();
		}
	}
	
	public function includeController($controllerName, $requestArray) {
		$requests = array('c' => $controllerName) + $requestArray;
		$controller = Dispatch::get($requests, array());
		array_merge($_GET, $requests);
		$view = new View($controller);
		$view->render();
	} 
	
	/** 
	 * Renders the View.
	 */
	public function render(){
		$path = dirname(__FILE__) . '/skins/' . $this->_skinName . '/layout/' . $this->_layoutName . '.phtml';
		include ($path); 
	}
	
	private function content(){
		$path = dirname(__FILE__) . '/skins/' . $this->_skinName . '/content/' . $this->_contentName . '.phtml';
		include ($path); 
	}
}