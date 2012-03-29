<?php
/**
 * Provides the interface for viewing the list of Wholesalers.
 * @author Samuel Giles
 * @package application-controller
 * @version 0.2
 */
class WholesalerController extends Controller {
    
    public function __construct() {
    	$this->_skin = 'default';
		$this->_layout = 'main';
		$this->_content = 'wholesalers';
		
		$this->requiredAccess(AccessLevels::WAREHOUSE | AccessLevels::SUPERVISOR | AccessLevels::ADMIN);
        
        // Tell the view that we're an Index controller.
		$this->addViewVariable("c", "Wholesaler");
        if(isset($_POST['name'])) {
            $this->addWholesaler();
        }
<<<<<<< HEAD
=======
        
        $this->getAllWholesalers();
>>>>>>> e5a45ba324393508f1a97d2dadf62e6a017d3736
	}
	
	
	private function getAllWholesalers() {
	  $sqlStatement = 'SELECT  `WHOLESALER`.`CODE`,`WHOLESALER`.`NAME`, `WHOLESALER`.`CONTACT_NAME`, `WHOLESALER`.`CONTACT_NUMBER`, `ADDRESS`.`LINE_ONE`, `ADDRESS`.`LINE_TWO`, `ADDRESS`.`POST_CODE` FROM WHOLESALER, ADDRESS WHERE `WHOLESALER`.`ADDRESS_CODE` = `ADDRESS`.`CODE`';
	  $result = Database::execute($sqlStatement);
	  $result = $result->fetchAll();
	  
	  $this->addViewVariable('wholesalers', $result);
	}


    private function addWholesaler() {
<<<<<<< HEAD
    		$sqlStatement = "INSERT INTO `WHOLESALER`.`CODE`,`WHOLESALER`.`NAME`, `WHOLESALER`.`CONTACT_NAME`, `WHOLESALER`.`CONTACT_NUMBER`, `ADDRESS`.`LINE_ONE`, `ADDRESS`.`LINE_TWO`, `ADDRESS`.`POST_CODE` FROM WHOLESALER, ADDRESS WHERE `WHOLESALER`.`ADDRESS_CODE` = `ADDRESS`.`CODE values({$_POST['name']}, {$_POST['contact']}, {$_POST['contactnumber']}, {$_POST['addrlineone']},{$_POST['addrline2']}, {$_POST['postcode]})";
	        Database::execute($sqlStatement);
    }
=======
    	    $address = array();
    	    
    	    
    	    $address['LINE_ONE'] = $_POST['addrlineone'];
    	    $address['LINE_TWO'] = $_POST['addrlinetwo'];
    	    $address['POST_CODE'] =  $_POST['postcode'];

    	    $newaddr = Address::createFromArray($address);
    		$newaddr->save();
    		
    		$code = $newaddr->getCode();
    		
    		$sqlStatement = 'INSERT INTO WHOLESALER (NAME, ADDRESS_CODE, CONTACT_NAME, CONTACT_NUMBER)' . 
							"values('{$_POST['name']}', $code,'{$_POST['contact']}', '{$_POST['contactnumber']}')";

	        Database::execute($sqlStatement);
    }
}
>>>>>>> e5a45ba324393508f1a97d2dadf62e6a017d3736
