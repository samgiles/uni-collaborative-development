<?php 
/**
 * This is the index file for the framework.  It provides an entry point to the application.
 * @author Samuel Giles
 * @package core
 */

// Turn debugging on or off.
$debug = false;


$dn = dirname(__FILE__);

$psdn = PATH_SEPARATOR . $dn; // Path separator and dn

// Set up the include paths.
$path = $dn . 
		'/com' . $psdn .
		'/../auth' . $psdn . 
		'/../db' . $psdn . 
		'/../session' . $psdn . 
		'/../session/simple-sessions' . $psdn . 
		'/../session/simple-sessions/session_writers' . $psdn . 
		'/controllers' . $psdn . 
		'/controllers/web' . $psdn . 
		'/controllers/backoffice' . $psdn . 
		'/models' . $psdn . 
		'/models/user_accounts' . $psdn .
		'/../auth/adapters';


set_include_path(get_include_path() . PATH_SEPARATOR . $path);

// Set locale specifics
date_default_timezone_set('UTC');
setlocale(LC_MONETARY, 'en_GB');

// Include the AutoLoad function.
require_once ('AutoLoad.php');
require_once("Logger.php");

if (!$debug) {
	require_once('ErrorHandler.php');
}

// Set error level
ini_set('display_errors', $debug ? E_STRICT : E_ERROR);

// Dont start session if handling error.
if (isset($_POST['errreport'])) {
	$logger = Logger::GetLogger();
	$message = urldecode($_POST['errdesc'] ?: 'No Message');
	
	
	$errno = urldecode($_POST['errno']);
	$errstr = urldecode($_POST['errstr']);
	$errfile = urldecode($_POST['errfile']);
	$errline = urldecode($_POST['errline']);
	$erruri = urldecode($_POST['erruri']);
	
	$logger->error("Received Error Report\nCode:\t{$errno}\n__________________\nError:\t{$errstr}\n__________________\nFile:\t{$errfile}\nLine:\t{$errline}\nAt:\t{$erruri}\nUser Message:\t$message\n__________________\n");
}
	
Session::start(new PDOSessionWriter(new PDO("@SESSIONDSN", '@SESSIONUNAME', '@SESSIONPWORD')));


/*
 * Run the application.
 */
Application::run();