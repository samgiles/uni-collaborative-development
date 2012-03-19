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
      
      
      
      
      // This comes from the registration form...
      
      $fname = $_POST['fname']; // FNAME
      $lname = $_POST['lname']; // LNAME
      $uname = $_POST['uname']; // USERNAME
      $password = $_POST['password']; // PASSWORD
      $email = $_POST['email']; // EMAIL
      $addressLineOne = $_POST['addrlineone']; // ADDRESS LINE ONE.
      $addressLineTwo = $_POST['addrlinetwo']; // ADDRESS LINE TWO
      $postcode = $_POST['postcode']; // POSTCODE
      $password = md5($password);
      // First need to check username isn't taken..
      $result = Database::execute("SELECT * FROM SYSTEM_USER WHERE USERNAME = '$uname'");
      $result = $result->fetchAll(); // Gets an array of all the results of the sql query.
      
      if (count($result) > 0) {
        // Username already taken
        $this->addViewVariable('usernameTaken', true);
        // exit early.
        return;
      } else {
        // Username not taken.
        $this->addViewVariable('usernameTaken', false);
      }
      
      // Next we need to add in an address because the SYSTEM_USER table uses a foreign key reference to ADDRESS
      $stmt = Database::execute("INSERT INTO ADDRESS (NAME, LINE_ONE, LINE_TWO, POST_CODE) VALUES ('', '$addressLineOne', '$addressLineTwo', '$postcode')");

      $result = $stmt->fetch(PDO::FETCH_ASSOC); 
  
      $addressPrimaryKey = $result['CODE']; // Get the primary key of the inserted address to use on the insert into SYSTEM_USER table.
      
      echo "INSERT INTO SYSTEM_USER (F_NAME, L_NAME, PHONE_NUMBER, USERNAME, PASSWORD, EMAIL, ADDRESS_CODE) VALUES ('$fname', '$lname', '0123 456 7689', '$uname', '$password', '$email', {$addressPrimaryKey})";
      // finally we'll need to insert the details into the SYSTEM_USER table
       $result2 = Database::execute("INSERT INTO SYSTEM_USER (F_NAME, L_NAME, PHONE_NUMBER, USERNAME, PASSWORD, EMAIL, ADDRESS_CODE) VALUES ('$fname', '$lname', '0123 456 7689', '$uname', '$password', '$email', {$addressPrimaryKey})");
       $userPK = $result2->fetch(PDO::FETCH_ASSOC);
      
      // And then create a customer record in the CUSTOMER table using the primary 
      // key from the SYSTEM_USER insert (using the method above) give them a loyalty code of 1 for now and payment details as NULL (no need for this yet).
       $result3 = Database::execute("INSERT INTO CUSTOMER (SYS_USER_CODE, PAYMENT_DETAILS_CODE, LOYALTY_CODE) VALUES ('$userPK', NULL, 1");
      $result3->fetch(PDO::FETCH_ASSOC);
  }
}