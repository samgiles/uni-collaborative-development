<?php
$result = Database::execute('SELECT NAME, COLOUR FROM FRUIT');

if ($result === FALSE) {
	// Database::execute failed and returned false
} else {
	// Database::execute was successful and returned not false, you can now use	the PDOStatement returned.
	$finalresult = $result->fetchAll();
	/*		
	 * 		$finalresult will then contain something like:
	 * 
	 * 		Array
	 *		(
     *			[0] => Array
     *   			   (
     *       				[NAME] => pear
     *       				[0] => pear
     *       				[COLOUR] => green
     *       				[1] => green
     *   			   )
     *			[1] => Array
     *   			   (
     *       				[NAME] => watermelon
     *       				[0] => watermelon
     *       				[COLOUR] => pink
     *       				[1] => pink
     *   			   )
	 *		)
	 * 		
	 */
}
?>