<?php
include_once "./genfunc/globalstart.php";
if ($loggedin) {
	if (isset($_SESSION['usergroup'])) {
		if (strcasecmp($_SESSION['usergroup'], "iscclient") != 0) {
			if (isset($_POST['usertodel'])) {
				if (deluser(decrypt($_POST['usertodel']))) {
					echo "<script async type=\"text/JavaScript\">alert('".decrypt($_POST['usertodel'])." removed successfully! Redirecting...');window.location.replace('../edocuments/corrusers.php');</script>";
				} else {
					echo "<script async type=\"text/JavaScript\">alert('".decrypt($_POST['usertodel'])." failed to be removed! Redirecting...');window.location.replace('../edocuments/corrusers.php');</script>";
				}
			} else {
				Echo "No user selected<BR>";
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