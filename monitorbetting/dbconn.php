<?php 


/* Connect to a MySQL server */ 
/*
$link = mysqli_connect( 
'localhost', 
'coreadm', 
'5aBong1aBen5',
'ABENMACH_Sabongnow', '3306'); 
*/


$link = mysqli_connect( 
'localhost', /* The host to connect to */ 
'coreprodadm', /* The user to connect as */ 
'123CoreProdAdm890', /* The password to use */ 
'ABENMACH_SabongnowProd', '3306'); 





if (!$link) 
{ 
//	print("Can't connect to MySQL Server. Errorcode: %s\n", mysqli_connect_error()); 
	echo("Can't connect to MySQL Server. Errorcode: %s\n" +  mysqli_connect_error()) ; 
	exit; 
} ?> 

