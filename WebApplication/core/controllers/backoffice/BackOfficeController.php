<?php
class BackOfficeController extends Controller {
	public function __construct() {
		$this->_skin = 'default';
		$this->_content = 'backoffice';
		$this->_layout = 'main';
		
		$this->addViewVariable('c', 'BackOffice');
	}
}