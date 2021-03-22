<?php
include_once "./genfunc/globalstart.php";
if ($loggedin) {
	if (isset($_SESSION['usergroup'])) {
		if (strcasecmp($_SESSION['usergroup'], "iscclient") != 0) {
			if (isset($_POST['usertoupdug'], $_POST['usergroup'])) {
				if (isset($_POST['encin'])) {
					$_POST['usertoupdug'] = encrypt($_POST['usertoupdug']);
				}
				if (uguser(decrypt($_POST['usertoupdug']), decrypt($_POST['usergroup']))) {
					echo "<script async type=\"text/JavaScript\">alert('".decrypt($_POST['usertoupdug'])." updated successfully! Redirecting...');window.location.replace('../edocuments/corrusers.php');</script>";
				} else {
					echo "<script async type=\"text/JavaScript\">alert('".decrypt($_POST['usertoupdug'])." failed to be updated! Redirecting...');window.location.replace('../edocuments/corrusers.php');</script>";
				}
			} else {
				echo "<script>function linksubm(formid) {
					document.getElementById(formid).submit();  
					return true;
					}</script>";
				echo "<form style=\"margin:0; padding:0; display:inline;\" method=\"POST\" action=\"".esc_url($_SERVER['PHP_SELF'])."\" id=\"userugupd\">";
				echo "<input type=\"hidden\" name=\"encin\" value=\"true\"/>";
				echo "Username: <input type=\"text\" name=\"usertoupdug\" ";
				if (isset($_POST['usertoupdug'])) {
					if (isset($_POST['encin'])) {
						$_POST['usertoupdug'] = encrypt($_POST['usertoupdug']);
					}
					echo "value=\"".decrypt($_POST['usertoupdug'])."\" ";
				}
				echo "/>";
				echo "<select id=\"usergroupselector\" name=\"usergroup\"";
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
						<option selected=true value=\"".encrypt("nope")."\">=(</option>";
				}
				echo "</select>";
				echo "</form>";
				echo "&nbsp;<a href=\"javascript:void(0);\" onclick=\"linksubm('userugupd');\">Update usergroup</a>";
			}
		} else {
			header('Location: ../edocuments/index.php');
		}
	} else {
		header('Location: ../edocuments/index.php');
	}
} else {
	header('Location: ../edocuments/index.php');
}
?>