<?php
$dn = dirname(__FILE__);

$psdn = PATH_SEPARATOR . $dn; // Path separator and dn

// Set up the include paths.
$path = $dn . '/../WebApplication/auth' . $psdn . '/../WebApplication/db' . $psdn . '/../WebApplication/session' . $psdn . '/../WebApplication/session/simple-sessions' . $psdn . '/../WebApplication/session/simple-sessions/session_writers' . $psdn . '/../WebApplication/controllers'  . $psdn . '/models' . $psdn . '/../WebApplication/auth/adapters' . $psdn . '/../WebApplication/core' . $psdn . '/../WebApplication/core/models';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

require_once 'AutoLoad.php';