<?php
include_once "./genfunc/globalstart.php";
include_once "./genfunc/updfunc.php";

if ($loggedin) {
	echo "<!DOCTYPE html>
		<html>
			<head>
				<meta charset=\"UTF-8\">
  				<title>Secure Login: Registration Form</title>
				<script type=\"text/JavaScript\" src=\"js/sha512.js\"></script>
				<script type=\"text/JavaScript\" src=\"js/forms.js\"></script>
			</head>
			<body>
				<!-- Registration form to be output if the POST variables are not
				set or if the registration script caused an error. -->";
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        echo "			<ul>
					<li>Passwords must be at least 8 characters long</li>
					<li>Passwords must contain
 						<ul>
							<li>At least one upper case letter (A..Z)</li>
							<li>At least one lower case letter (a..z)</li>
							<li>At least one number (0..9)</li>
							<li>At least one special character from the set <b>!@#$%&*-_=+?)</b></li>
						</ul>
            				</li>
					<li>Your password and confirmation must match exactly</li>
				</ul>
				<form action=\"".esc_url($_SERVER['PHP_SELF'])."\" 
					method=\"post\" 
					name=\"registration_form\">
					Username: ";
					if (isset($_POST['pcuser'])) {
						echo decrypt($_POST['pcuser']);
					} else {
						echo $_SESSION['username'];
					}
					echo "<BR>
					Password: <input type=\"password\"
					name=\"password\" 
					id=\"password\"/><br>
					Confirm password: <input type=\"password\" 
                                     	name=\"confirmpwd\" 
                                     	id=\"confirmpwd\" /><br>
					<input type=\"button\" 
					value=\"Change password\" 
					onclick=\"return updformhash(this.form,
					'";
					if (isset($_POST['pcuser'])) {
						echo decrypt($_POST['pcuser']);
					} else {
						echo $_SESSION['username'];
					}
					echo "',
					this.form.password,
					this.form.confirmpwd);\" /> 
				</form>
			</body>
		</html>";
} else {
	header('Location: ../edocuments/index.php');
}
?>