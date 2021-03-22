<?php
include_once "./genfunc/globalstart.php";



if (strcasecmp($_SESSION['usergroup'], "isadmin") == 0 or strcasecmp($_SESSION['usergroup'], "isisa") == 0) {
	$qres = query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT DISTINCT `username` FROM `ed__users` WHERE `parentid` NOT IN (SELECT DISTINCT `userid` FROM `ed__users`) AND `userid` != 1");
} elseif (strcasecmp($_SESSION['usergroup'], "isops") == 0) {
	$qres = query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT DISTINCT `username` FROM `ed__users` WHERE `parentid` NOT IN (SELECT DISTINCT `userid` FROM `ed__users`) AND `userid` != 1 AND `IsPClient` + `IsCClient` = '1'");
} else {
	$qres = "";
}
if (is_array($qres)) {
	echo "<b>Orphan users:</b><br>";
	foreach ($qres as $value) {
		echo $value['username']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		linkform("orphan".$value['username'], "/duser.php", "Delete user", array(array("usertodel", $value['username'])));
		echo "<BR>";
	}
	echo "<BR>";
}



if (strcasecmp($_SESSION['usergroup'], "isadmin") == 0 or strcasecmp($_SESSION['usergroup'], "isisa") == 0) {
	$qres = query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT `username` FROM `ed__users` WHERE `IsEnabled` = '0'");
} elseif (strcasecmp($_SESSION['usergroup'], "isops") == 0) {
	$qres = query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT `username` FROM `ed__users` WHERE `IsEnabled` = '0' AND `IsPClient` + `IsCClient` = '1'");
} else {
	$qres = "";
}
if (is_array($qres)) {
	echo "<b>Disabled users:</b><br>";
	foreach ($qres as $value) {
		echo $value['username']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		linkform("enable".$value['username'], "/edocuments/euser.php", "Enable user", array(array("usertoenable", $value['username'])));
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		linkform("orphan".$value['username'], "/edocuments/duser.php", "Delete user", array(array("usertodel", $value['username'])));
		echo "<BR>";
	}
	echo "<BR>";
}



if (strcasecmp($_SESSION['usergroup'], "isadmin") == 0 or strcasecmp($_SESSION['usergroup'], "isisa") == 0) {
	$qres = query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT `username` FROM `ed__users` WHERE `IsAdmin` + `IsISA` + `IsOps` + `IsPClient` + `IsCClient` = '0'");
} else {
	$qres = "";
}
if (is_array($qres)) {
	echo "<b>No usergroup setup:</b><br>";
	foreach ($qres as $value) {
		echo $value['username']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		linkformug("ug".$value['username'], "/edocuments/uguser.php", "Change usergroup", array(array("usertoupdug", $value['username'])));
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		linkform("orphan".$value['username'], "/edocuments/duser.php", "Delete user", array(array("usertodel", $value['username'])));
		echo "<BR>";
	}
	echo "<BR>";
}



if (strcasecmp($_SESSION['usergroup'], "isadmin") == 0 or strcasecmp($_SESSION['usergroup'], "isisa") == 0) {
	$qres = query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT `username` FROM `ed__users` WHERE `IsAdmin` + `IsISA` + `IsOps` + `IsPClient` + `IsCClient` > '1'");
} else {
	$qres = "";
}
if (is_array($qres)) {
	echo "<b>Multiple usergroups setup:</b><br>";
	foreach ($qres as $value) {
		echo $value['username']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		linkformug("ug".$value['username'], "/edocuments/uguser.php", "Change usergroup", array(array("usertoupdug", $value['username'])));
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		linkform("orphan".$value['username'], "/edocuments/duser.php", "Delete user", array(array("usertodel", $value['username'])));
		echo "<BR>";
	}
	echo "<BR>";
}



if (strcasecmp($_SESSION['usergroup'], "isadmin") == 0 or strcasecmp($_SESSION['usergroup'], "isisa") == 0) {
	$qres = query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT `ed__users`.`username` FROM `ed__users` WHERE (SELECT COUNT(`ed__users`.`userid`) FROM `ed__strikes` WHERE `ed__strikes`.`userid` = `ed__users`.`userid`) >= 5");
} elseif (strcasecmp($_SESSION['usergroup'], "isops") == 0) {
	$qres = query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT `ed__users`.`username` FROM `ed__users` WHERE `ed__users`.`IsPClient` + `ed__users`.`IsCClient` = '1' AND (SELECT COUNT(`ed__users`.`userid`) FROM `ed__strikes` WHERE `ed__strikes`.`userid` = `ed__users`.`userid`) >= 5");
} else {
	$qres = "";
}
if (is_array($qres)) {
	echo "<b>5 or more strikes:</b><br>";
	foreach ($qres as $value) {
		echo $value['username']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		linkform("enable".$value['username'], "/edocuments/euser.php", "Enable user", array(array("usertoenable", $value['username'])));
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		linkform("orphan".$value['username'], "/edocuments/duser.php", "Delete user", array(array("usertodel", $value['username'])));
		echo "<BR>";
	}
	echo "<BR>";
}



$qres = query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT `username` FROM `ed__users` WHERE `parentid` = '".$_SESSION['userid']."'");
if (is_array($qres)) {
	echo "<b>Child users:</b><br>";
	foreach ($qres as $value) {
		echo $value['username']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		linkform("ugo".$value['username'], "/edocuments/uguser.php", "Change group", array(array("usertoupdug", $value['username'])));
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		if (strcasecmp($_SESSION['usergroup'], "isops") == 0 or strcasecmp($_SESSION['usergroup'], "ispclient") == 0) {
			linkform("druseru".$value['username'], "/edocuments/druser.php", "Change rights", array(array("userdr", $value['username'])));
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		linkform("pcu".$value['username'], "/edocuments/passchange.php", "Change password", array(array("pcuser", $value['username'])));
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		linkform("enable".$value['username'], "/edocuments/euser.php", "Enable user", array(array("usertoenable", $value['username'])));
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		linkform("orphan".$value['username'], "/edocuments/duser.php", "Delete user", array(array("usertodel", $value['username'])));
		echo "<BR>";
	}
	echo "<BR>";
}



if (strcasecmp($_SESSION['usergroup'], "isadmin") == 0 or strcasecmp($_SESSION['usergroup'], "isisa") == 0) {
	$qres = query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT `username`, `userid`, `parentid` FROM `ed__users`");
} elseif (strcasecmp($_SESSION['usergroup'], "isops") == 0) {
	$qres = query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT `username`, `userid`, `parentid` FROM `ed__users` WHERE `IsPClient` + `IsCClient` = '1'");
} else {
	$qres = "";
}
if (is_array($qres)) {
	echo "<b>All users:</b><br>";
	foreach ($qres as $value) {
		echo $value['username']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		linkform("ugo".$value['username'], "/edocuments/uguser.php", "Change group", array(array("usertoupdug", $value['username'])));
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		if (strcasecmp($_SESSION['usergroup'], "isops") == 0) {
			linkform("druseru".$value['username'], "/edocuments/druser.php", "Change rights", array(array("userdr", $value['username'])));
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		linkform("pcu".$value['username'], "/edocuments/passchange.php", "Change password", array(array("pcuser", $value['username'])));
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		linkform("enable".$value['username'], "/edocuments/euser.php", "Enable user", array(array("usertoenable", $value['username'])));
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		linkform("orphan".$value['username'], "/edocuments/duser.php", "Delete user", array(array("usertodel", $value['username'])));
		echo "<BR>";
	}
	echo "<BR>";
}
?>