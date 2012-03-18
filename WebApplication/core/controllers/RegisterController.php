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
      $uname = $_POST['username']; // USERNAME
      $password = $_POST['password']; // PASSWORD
      $email = $_POST['email']; // EMAIL
      $addressLineOne = $_POST['addrlineone']; // ADDRESS LINE ONE.
      $addressLineTwo = $_POST['addrlinetwo']; // ADDRESS LINE TWO
      $postcode = $_POST['postcode']; // POSTCODE
      
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
      $result = Database::execute("INSERT INTO ADDRESS (LINE_ONE, LINE_TWO, POST_CODE) VALUES ('$addressLineOne', '$addressLineTwo', '$postcode'");
      $result->fetch(PDO::FETCH_ASSOC); 
      
      $addressPrimaryKey = $result['CODE']; // Get the primary key of the inserted address to use on the insert into SYSTEM_USER table.
      
      
      // finally we'll need to insert the details into the SYSTEM_USER table
      
       $result2 = Database::execute("INSERT INTO SYSTEM_USER (LINE_ONE, LINE_TWO, POST_CODE) VALUES ('$addressLineOne', '$addressLineTwo', '$postcode'");
      $result2->fetch(PDO::FETCH_ASSOC); 
      
      // And then create a customer record in the CUSTOMER table using the primary 
      // key from the SYSTEM_USER insert (using the method above) give them a loyalty code of 1 for now and payment details as NULL (no need for this yet).
       $result3 = Database::execute("INSERT INTO CUSTOMER (LINE_ONE, LINE_TWO, POST_CODE) VALUES ('$addressLineOne', '$addressLineTwo', '$postcode'");
      $result3->fetch(PDO::FETCH_ASSOC); 
  }
}