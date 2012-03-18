<?php
include('PageModel.php');
/**
 * The base class for a controller.  Controllers, control the processing that will occur in a web request.
 * @author Samuel Giles
 */
abstract class Controller {
	
	/**
	 * The model for the page or output that this Conroller will interface with.
	 * @var PageModel
	 */
	private $_pageModel;
	
	/**
	 * The name of the skin that will be used to render this Controller's output.
	 * @var string
	 */
	protected $_skin;
	
	/**
	 * The name of the layout template that will be used to render this Controller's output, this will be relative to the skin name.
	 * @var string
	 */
	protected $_layout;
	
	/**
	 * The name of the content template that will be used to render this Controller's output, this will be relative to the skin name.
	 * @var string
	 */
	protected $_content;
    
	/**
	 * The required access level to run this controller.
	 * @var int
	 * TODO Remove tight coupling and dependency on AccessLevels
	 */
    protected $_requiredAccessLevel = AccessLevels::Anyone;
	
	/**
	 * Adds a new variable to the page model. This can then be used in the templates specified.
	 * @param string $key  The key of the variable that is to be added to the page model.
	 * @param mixed $value The value of the variable that is to be added to the page model.
	 */
	protected function addViewVariable($key, $value){
		// If a page model doesn't exist yet, create one.
		if (!isset($this->_pageModel) || is_null($this->_pageModel)){
			$this->_pageModel = new PageModel();
		}
		
		$this->_pageModel->addPageVariable($key, $value);
		return $this;
	}
    
	/**
	 * Set's the required access level for this controller given an integer.
	 * @param int $accessLevel
	 * TODO Remove tightly coupled dependence on a Session variable, and application specific settings.
	 */
    public function requiredAccess($accessLevel) {
      if ($accessLevel === 0) {
        return true; // OK.
      }
      // 001 <- Supervisor
      // 010 <- Warehouse
      // 100 <- General Staff
      // 111 <- Admin
      
      $login = Session::get('login');
      if ($login === NULL) {
        $this->_content = 'nopermission';
        return false;
      }
      
      $level = $login['access'];
      
      
      $hasPerms = $accessLevel & $level;  // Bitwise AND
      if ($hasPerms == $accessLevel) {
        // OK!
        return true;
      } else {
        // NOT OK :(
        $this->_content = 'nopermission';
        return false;
      }
    }
	
    /**
     * Get the skin that this controller will use to determine it's output templates.
     */
	public function getSkin(){
		return $this->_skin;
	}
	
	/**
	 * Get the layout template that will be used to render the controller.
	 */
	public function getLayout() {
		return $this->_layout;
	}
	
	/**
	 * Get the content template that will be used to render the controller.
	 */
	public function getContent(){
		return $this->_content;
	}
	
	/**
	 * Gets the PageModel for this controller.
	 */
	public function getPageModel(){
		return $this->_pageModel;
	}
}