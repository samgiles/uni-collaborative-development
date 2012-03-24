<?php
class StaffController extends Controller {
    
    public function __construct() {
    	$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'Staff';
		
		$this->requiredAccess(AccessLevels::STAFF | AccessLevels::SUPERVISOR | AccessLevels::ADMIN);
        $this->getAllStaff();
        // Tell the view that we're an Index controller.
		$this->addViewVariable("c", "Staff");
	}
}