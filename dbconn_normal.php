<?php 
/* Connect to a MySQL server */ 
$link2 = mysql_connect( 
	'localhost', /* The host to connect to */ 
	'coreadm', /* The user to connect as */ 
	'5aBong1aBen5'); /* The password to use */ 
	
	if (!$link2) 
	{ 
		echo("Can't connect to MySQL Server. Errorcode: %s\n" +  mysql_error()) ; 
		exit; 
	} 
	
	mysql_select_db("ABENMACH_Sabongnow", $link2);
?> 

