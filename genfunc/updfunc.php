<?php
include_once './genfunc/config.php';
include_once './genfunc/functions.php';
 
$error_msg = "";
 
if (isset($_POST['username'], $_POST['p'])) {
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
		if (empty($error_msg)) {
			if (strcasecmp($_POST['username'], $_SESSION['username']) != 0) {
				if (strcasecmp($_SESSION['usergroup'], "isadmin") != 0 and strcasecmp($_SESSION['usergroup'], "isisa") != 0) {
					if (strcasecmp($_SESSION['usergroup'], "isops") == 0) {
						if (!checkifclient($username)) {
							echo "<script async type=\"text/JavaScript\">alert('Not enough rights! Redirecting...');window.location.replace('../edocuments/index.php');</script>";
							exit;
						}
					} else {
						if (!(strcasecmp($_SESSION['usergroup'], "ispclient") == 0 and checkparent($username))) {
							echo "<script async type=\"text/JavaScript\">alert('Not enough rights! Redirecting...');window.location.replace('../edocuments/index.php');</script>";
							exit;
						}
					}
				}
			}
        		$qres = query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT * FROM `ed__users` WHERE `username` = '$username' LIMIT 1");
			if (is_array($qres)) {
				if ($qres[0]['password'] === pass_hash($qres[0]['cumin'], $qres[0]['charoli'], $password, $qres[0]['cubeb'], $qres[0]['mace'])) {
					echo "<script async type=\"text/JavaScript\">alert('Can't reuse same password! Please, try again');</script>";
				} else {
					// Create a random salt
					$spices = spicing_up();
					// Create salted password 
					$newpassword = pass_hash($spices[0], $spices[1], $password, $spices[2], $spices[3]);
					// Insert the new user into the database
					if (query_runner($mhost, $mdbname, $mport, $msocket, $uuser, $upass, "UPDATE ed__users SET `cumin`='$spices[0]', `charoli`='$spices[1]', `password`='$newpassword', `cubeb`='$spices[2]', `mace`='$spices[3]', `isenabled`='1', `passres`='0' WHERE `username` = '$username'")) {
						login($username, $password);
						echo "<script async type=\"text/JavaScript\">alert('Password changed successfully! Redirecting...');window.location.replace('../edocuments/index.php');</script>";
					} else {
						
					}
				}
			}
		}
	} elseif ($qres === false) {
		echo "<script async type=\"text/JavaScript\">alert('Database error! Try again or contact administration');</script>";
	}
}
?>