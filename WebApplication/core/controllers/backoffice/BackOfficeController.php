<?php
/**
 * A simple page that outputs some links to pages in the backoffice.
 * @author Samuel Giles
 * @package application_controller
 * @subpackage application_controller-backoffice
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