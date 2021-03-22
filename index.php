<?php
include_once "./genfunc/globalstart.php";
include_once "./genfunc/config.php";
include_once "./genfunc/functions.php";
	echo "<!DOCTYPE html>
		<html>
			<head>
				<title>Secure Login: Log In</title>
				<link rel=\"stylesheet\" href=\"styles/main.css\" />
				<script type=\"text/JavaScript\" src=\"js/sha512.js\"></script> 
				<script type=\"text/JavaScript\" src=\"js/forms.js\"></script> 
			</head>
			<body>";
if (isset($_POST['username'], $_POST['p'])) {
	$username = $_POST['username'];
	$password = $_POST['p']; // The hashed password.
	$login = login($username, $password);
	if ($login === "succ") {
		//echo "Login success"; 
		header('Location: ../edocuments/index.php');
	} elseif ($login === "locked") {
		$errm = "User is locked out due to many incorrect login attempts. Please, contact administration";
	} elseif ($login === "brute") {
		$errm = "Wrong password";
	} elseif ($login === "dberr") {
		$errm = "Database error. Please, contact administration";
	} elseif ($login === "nouser") {
		$errm = "Incorrect or non-existent username";
	} elseif ($login === "disabled") {
		$errm = "User is disabled. Please, contact administration";
	} elseif ($login === "wrights") {
		$errm = "User has incorrect rights setup. Please, contact administration";
	} elseif ($login === "passress") {
		$errm = "Please, reset password!";
	} else {
		$errm = "Unidentified error";
	}
}




if ($loggedin) {
	if (isset($_SESSION['usergroup'])) {
		echo "Available features:<BR>";
		if (strcasecmp($_SESSION['usergroup'], "iscclient") != 0) {
			echo "<a href=\"".esc_url("/edocuments/nuser.php")."\">Create new user</a><BR>";
		}
		if (strcasecmp($_SESSION['usergroup'], "iscclient") != 0) {
			echo "<a href=\"".esc_url("/edocuments/corrusers.php")."\">List users</a><BR>";
		}
		if (strcasecmp($_SESSION['usergroup'], "isadmin") == 0 or strcasecmp($_SESSION['usergroup'], "isisa") == 0) {
			//echo "<a href=\"".esc_url("")."\">View DB log</a><BR>";
		}
		if (strcasecmp($_SESSION['usergroup'], "isadmin") != 0 and strcasecmp($_SESSION['usergroup'], "isisa") != 0) {
			echo "<a href=\"".esc_url("/edocuments/docgen.php")."\">View documents</a><BR>";
		}
		//echo "<a href=\"".esc_url("")."\">Send message</a><BR>";
	} else {
		Echo "Somethin went wrong during login. Please, try to relogin. If that does not help, please, contact administration.";
	}
	echo "<p>Change password <a href=\"".esc_url("/edocuments/passchange.php")."\">here</a>.</p>";
	echo "<p>If you are done, please <a href=\"".esc_url("/edocuments/logout.php")."\">log out</a>.</p>";
} else {
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        echo "			<form action=\"".esc_url($_SERVER['PHP_SELF'])."\" method=\"post\" name=\"login_form\">                      
					Username: <input type=\"text\" name=\"username\" /><BR>
					Password: <input type=\"password\" 
					name=\"password\" 
					id=\"password\"/><BR>
					<input autofocus type=\"button\" 
					value=\"Login\" 
					onclick=\"formhash(this.form, this.form.password);\" /> 
				</form>";
	if (isset($errm)) {
		echo $errm;
	}
}
//$_SESSION['something2'] = 'A value2.';
//echo $_SESSION['something2'];
//$_SESSION['something'] = 'A value.';
//echo $_SESSION['something'];
	echo "		</body>
		</html>";
?>