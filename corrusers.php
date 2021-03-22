<?php
include_once "./genfunc/globalstart.php";
include_once "./genfunc/regfunc.php";
if ($loggedin) {
	if (isset($_SESSION['usergroup'])) {
		if (strcasecmp($_SESSION['usergroup'], "iscclient") != 0) {
			include_once("./genfunc/shcoruss.php");
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