<?php
/**
 * Autoload.php sets up the autoloading for the application.
 * @package core
 */

/**
 * Used to autoload classes, this means we do not need to use include statements to find class definitions.
 * @param string $className
 */
function autoLoad($className){
	include ("$className.php");
}
// Register the autoload function with the SPL autoloader.
spl_autoload_register("autoLoad");