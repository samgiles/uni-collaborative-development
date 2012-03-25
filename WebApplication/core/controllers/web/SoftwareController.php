<?php
/**
 * The software page.
 * @author James Legros
 * @package application-controllers
 * @subpackage web-controllers
 * @version 0.4
 */
class SoftwareController extends Controller {
    
    public function __construct() {
		$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'Software.web';
		
        $this->addViewVariable('c', 'Software');
}
}