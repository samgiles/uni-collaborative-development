<?php
class BackOfficeController extends Controller {
	public function __construct() {
		$this->_skin = 'default';
		$this->_content = 'backoffice';
		$this->_layout = 'main';
		
		$this->requiredAccess(AccessLevels::ADMIN | AccessLevels::GENERALSTAFF | AccessLevels::SUPERVISOR | AccessLevels::WAREHOUSE);
		
		$this->addViewVariable('c', 'BackOffice');
	}
}