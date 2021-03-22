<?php
include_once './genfunc/config.php';
include_once './genfunc/functions.php';
 
$error_msg = "";
 
if (isset($_POST['username'], $_POST['p'], $_POST['usergroup'])) {
	// Sanitize and validate the data passed in
	$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
	$password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
	if (strlen($password) != 128) {
		// The hashed pwd should be 128 characters long.
		// If it's not, something really odd has happened
		$error_msg .= '<p class="error">Invalid password configuration.</p>';
	}
	// check existing username
	$qres = query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT userid FROM ed__users WHERE username='$username' LIMIT 1");
	if (is_array($qres)) {
		$error_msg .= '<p class="error">A user with this username already exists</p>';
	} elseif ($qres === false) {
		$error_msg .= '<p class="error">Database error</p>';
	}
	if (empty($error_msg)) {
		// Create a random salt
		$spices = spicing_up();
		// Create salted password 
		$password = pass_hash($spices[0], $spices[1], $password, $spices[2], $spices[3]);
		// Insert the new user into the database
		$query = "INSERT INTO ed__users (`username`, `parentid`, `cumin`, `charoli`, `password`, `cubeb`, `mace`, `".decrypt($_POST['usergroup'])."`, `isenabled`, `rights`) VALUES ('$username', ";
		if (isset($_SESSION['userid'])) {
			$query = $query.$_SESSION['userid'];
		} else {
			$query = $query."0";
		}
		$query = $query.", '$spices[0]', '$spices[1]', '$password', '$spices[2]', '$spices[3]', 1, 1, '";
		if (strcasecmp(decrypt($_POST['usergroup']), "isops") == 0) {
			$query = $query."ALL";
		} else {
			$query = $query."NONE";
		}
		$query = $query."')";
		if (query_runner($mhost, $mdbname, $mport, $msocket, $iuser, $ipass, $query)) { 
			echo "<script async type=\"text/JavaScript\">alert('User created successfully!');</script>";
		} else {
			echo "<script async type=\"text/JavaScript\">alert('User creation failed!');</script>";
		}
	}
}
?>