<?php
include_once "./genfunc/globalstart.php";
include_once "./genfunc/regfunc.php";
if (admincheck()) {
	header('Location: ../edocuments/index.php');
} else {
	echo "There are no admin users! Please, create one using the form below<BR>";
	include_once "./genfunc/register.php";
}
?>