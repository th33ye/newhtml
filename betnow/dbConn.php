<?php


/*
$dbServer="localhost";
$dbName="ABENMACH_SabongnowDev2";
$username="coredev";
$password="5aBong1aBen5";
*/

$dbServer="localhost";
$dbName="ABENMACH_SabongnowProd";
$username="coreprodadm";
$password="123CoreProdAdm890";

$connected = mysql_connect($dbServer, $username, $password);
if (!$connected)
{
	die("Cannot Connect to Database " . mysql_error());
}

mysql_select_db("$dbName", $connected);



?>
