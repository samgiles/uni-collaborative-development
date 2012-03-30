<?php
/**
 * 
 * @author Samuel Giles
 *
 */
class BackOfficeController extends Controller {
	public function __construct() {
		$this->_skin = 'default';
		$this->_content = 'backoffice';
		$this->_layout = 'main';
		
		$this->requiredAccess(AccessLevels::GENERALSTAFF | AccessLevels::SUPERVISOR | AccessLevels::WAREHOUSE | AccessLevels::ADMIN);
		
		$this->addViewVariable('c', 'BackOffice');
	}
}