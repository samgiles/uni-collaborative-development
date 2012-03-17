<?php
function autoLoad($className){
	include ("$className.php");
}

spl_autoload_register("autoLoad");