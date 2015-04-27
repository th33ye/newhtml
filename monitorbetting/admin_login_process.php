<?php
session_start();

if(!empty($_POST['username']) && !empty($_POST['password']))
{
	include 'dbconn.php';
	
	$username = $_POST['username'];
	$password = $_POST['password'];

	$username = mysqli_real_escape_string($link, $username);
	$pwd = mysqli_real_escape_string($link, md5($password));
	$aSQuery = "SELECT * FROM monitor_admin WHERE username = '$username' and password = '$pwd' LIMIT 1;";
	
//	$query = "call spAdminLogin('" . mysqli_real_escape_string($link,$username) . "',  '". mysqli_real_escape_string($link,$password) ."');";
	//echo $query;
	if ($result = mysqli_query($link,$aSQuery)) 
	{
		if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) )
		{
			$_SESSION['admin_id'] = $row["id"]; 
			$_SESSION['admin_username'] = $row["username"];
			mysqli_close($link); 
			header("location:menu.php");
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