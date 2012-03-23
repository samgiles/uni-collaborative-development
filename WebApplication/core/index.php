<?php 
/**
 * This is the index file for the framework.  It provides an entry point to the application.
 * @package core
 */

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

// Set error level
ini_set('display_errors', E_STRICT);

// Start session handling
Session::start(new PDOSessionWriter(new PDO("@SESSIONDSN", '@SESSIONUNAME', '@SESSIONPWORD')));




/*
 * Run the application.
 */
Application::run();