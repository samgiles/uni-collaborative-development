<?php 
/**
 * Used for registering new System Users.
 */
class RegisterController extends Controller {
  public function __construct() {
      $this->_skin = 'default';
	  $this->_layout = 'empty';
	  $this->_content = 'register';
      
      if (!isset($_POST['fname']) && !isset($_POST['lname'])) {  // If there are no details sent by the registration form exit.
        return;
      }
      
      $usernametaken = User::usernameExists($_POST['uname']);
      $this->addViewVariable('usernameTaken', $usernametaken);
      if ($usernametaken) {
      	return;
      }
      
      $creationFields = array();
	  $creationFields['F_NAME'] = $_POST['fname'];
	  $creationFields['L_NAME'] = $_POST['lname'];
	  $creationFields['PHONE_NUMER'] = '111 1111 1111';
	  $creationFields['USERNAME'] = $_POST['uname'];
	  $creationFields['PASSWORD'] = $_POST['password'];
	  $creationFields['EMAIL'] = $_POST['email'];
	  
	  $createAddress = array();
	  $createAddress['LINE_ONE'] = $_POST['addrlineone'];
	  $createAddress['LINE_TWO'] = $_POST['addrlinetwo'];
	  $createAddress['POST_CODE'] = $_POST['postcode'];
	  
	  $address = Address::createFromArray($createAddress);
	  $address->save();
	  
	  $creationFields['ADDRESS_CODE'] = $address;
      // This comes from the registration form...
      
	  $user = User::createFromArray($creationFields);
	  $user->save();
	  
      
      // And then create a customer record in the CUSTOMER table using the primary 
      // key from the SYSTEM_USER insert (using the method above) give them a loyalty code of 1 for now and payment details as NULL (no need for this yet).
      $result3 = Database::execute("INSERT INTO CUSTOMER (SYS_USER_CODE, PAYMENT_DETAILS_CODE, LOYALTY_CODE) VALUES ('{$user->getCode()}', NULL, 1)");
  }
}