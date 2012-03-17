<?php
/**
 * @author user
 *
 */
class Application {
	
	protected $_view;
	protected $_controller;
	
	private function __construct() {
		// Dispatch the application.
		$this->_controller = Dispatch::get($_GET, $_POST);
		
		// Create a view from the controller association.
		$this->_view = new View($this->_controller);
	}

	public static function run(){
		$app = new Application();
		$app->_view->render();
	}
	
}