<?php
#configuration file for the service

#general details
$host="localhost";
$username="username";
$password="password";
$db_name="database";

#main database (users, settings, .etc)
$mhost=$host;
$mdbname=$db_name;
$mport="";
$msocket="";

#documents database (where actual data is stored)
$dhost=$host;
$ddbname=$db_name;
$dport="";
$dsocket="";

#users' credentials for appropriate operations
#if separateusers is false - use iuser only
$separateusers=false;

#user with INSERT right
$iuser=$username;
$ipass=$password;

#user with DELETE right
$ruser=$username;
$rpass=$password;

#user with SELECT right
$suser=$username;
$spass=$password;

#user with UPDATE right
$uuser=$username;
$upass=$password;

#user for sessions handling
$sesuser=$username;
$sespass=$password;

?>