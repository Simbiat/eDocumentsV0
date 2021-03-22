<?php
include_once "./genfunc/config.php";
include_once "./genfunc/functions.php";

//does not work on shared host
//$session = new session();
//$session->start_session('_s', true);
//$session->gc(1);

session_start([
    'cookie_lifetime' => 1200,
]);

// Unset all session values 
$_SESSION = array();
// get session parameters 
$params = session_get_cookie_params();
// Delete the actual cookie. 
setcookie(session_name(),
	'', time() - 42000, 
	$params["path"], 
	$params["domain"], 
	$params["secure"], 
	$params["httponly"]);
// Destroy session
//$session->destroy(session_id());
//$session->gc(1);

session_destroy();

brute_gc();
header('Location: ../edocuments/index.php');
?>