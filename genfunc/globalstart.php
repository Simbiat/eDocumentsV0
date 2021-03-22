<?php
#include settings
include_once "./genfunc/config.php";
include_once "./genfunc/functions.php";
//$session = new session();
//$session->start_session('_s', false);
//$session->gc(1);
session_start([
    'cookie_lifetime' => 1200,
]);
$loggedin = login_check();
?>