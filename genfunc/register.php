<?php
include_once "./genfunc/globalstart.php";
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
					<li>Usernames may contain only digits, upper and lower case letters and underscores</li>
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
					Username: <input type='text' 
					name='username' 
					id='username' /><br>
					Usergroup: <select id=\'usergroup\' name=\"usergroup\"";
	if (isset($_SESSION['usergroup'])) {
		if (strcasecmp($_SESSION['usergroup'], "iscclient") == 0) {
			echo "			 disabled>";
		} else {
			echo "			>";
		}
		if (strcasecmp($_SESSION['usergroup'], "isadmin") == 0 or strcasecmp($_SESSION['usergroup'], "isisa") == 0) {
			echo "				<option selected=true value=\"".encrypt("isadmin")."\">Admin</option>";
		}
		if (strcasecmp($_SESSION['usergroup'], "isadmin") == 0 or strcasecmp($_SESSION['usergroup'], "isisa") == 0) {
			echo "				<option selected=true value=\"".encrypt("isisa")."\">ISA</option>";
		}
		if (strcasecmp($_SESSION['usergroup'], "isisa") == 0) {
			echo "				<option selected=true value=\"".encrypt("isops")."\">Operator</option>";
		}
		if (strcasecmp($_SESSION['usergroup'], "isops") == 0 or strcasecmp($_SESSION['usergroup'], "ispclient") == 0) {
			echo "				<option selected=true value=\"".encrypt("ispclient")."\">Client Admin</option>";
		}
		if (strcasecmp($_SESSION['usergroup'], "ispclient") == 0) {
			echo "				<option selected=true value=\"".encrypt("iscclient")."\">Client Operator</option>";
		}
	} else {
		echo "			 disabled>
						<option selected=true value=\"".encrypt("isadmin")."\">Admin</option>";
	}
	echo "				</select><br>
					Password: <input type=\"password\"
					name=\"password\" 
					id=\"password\"/><br>
					Confirm password: <input type=\"password\" 
                                     	name=\"confirmpwd\" 
                                     	id=\"confirmpwd\" /><br>
					<input type=\"button\" 
					value=\"Register\" 
					onclick=\"return regformhash(this.form,
					this.form.username,
					this.form.password,
					this.form.confirmpwd,
					this.form.usergroup);\" /> 
				</form>
			</body>
		</html>";
?>