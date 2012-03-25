<?php 
/**
 * Gracefully handles errors so users are not presented with a call stack on error.
 * @author Samuel Giles
 * @package core
 */

function fatal_error_handler() {
	
	if (@is_array($error = @error_get_last())) {
		$code = $error['type'] ?: 0;
		$msg = $error['message'] ?: '';
		$file = $error['file']  ?: '';
		$line = $error['line'] ?: '';
		if ($code > 0) {
			error_handler($code, $msg, $file, $line);
		}
	}
	return false;
}

function error_handler($errno, $errstr, $errfile, $errline) {
	@ob_end_clean();
	include("error.phtml");
	
}

set_error_handler('error_handler');
register_shutdown_function('fatal_error_handler');