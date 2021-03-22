<?php
include_once "./genfunc/globalstart.php";
if ($loggedin) {
	if (isset($_SESSION['usergroup'])) {
		if (strcasecmp($_SESSION['usergroup'], "iscclient") != 0) {
			if (isset($_POST['usertoenable'])) {
				if (enbuser(decrypt($_POST['usertoenable']))) {
					echo "<script async type=\"text/JavaScript\">alert('".decrypt($_POST['usertoenable'])." enabled successfully! Redirecting...');window.location.replace('../edocuments/corrusers.php');</script>";
				} else {
					echo "<script async type=\"text/JavaScript\">alert('".decrypt($_POST['usertoenable'])." failed to be enabled! Redirecting...');window.location.replace('../edocuments/corrusers.php');</script>";
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