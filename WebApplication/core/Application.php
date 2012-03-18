<?php
/**
 * The main object for the Application
 * @author Samuel Giles
 */
class Application {
	
	/**
	 * The view that this application is rendering.
	 * @var View
	 */
	protected $_view;
	
	/**
	 * The Controller that this application is executing.
	 * @var Controller
	 */
	protected $_controller;
	
	/**
	 * Creates a new Application and dispatches it using the $_GET, and $_POST variables.
	 */
	private function __construct() {
		// Dispatch the application.
		$this->_controller = Dispatch::get($_GET, $_POST);
		
		// Create a view from the controller's association.
		$this->_view = new View($this->_controller);
	}
    
	/**
	 * Runs the application.
	 * First the application is dispatched, instantiating the Controller that has been requested, it is then passed into a View object ready to be rendered here.
	 */
	public static function run(){
		$app = new Application();
		$app->_view->render();
	}
}