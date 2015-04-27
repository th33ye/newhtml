<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<title>Logout</title>
</head>


<body>
<table width="100%"> 
<tr>
<td align="center">
<h1>&nbsp;</h1>
<h1>&nbsp;</h1>
<h1>&nbsp;</h1>
<h1>&nbsp;</h1>
<h1>You have been logged out, Thank you for playing!</h1>
<p>&nbsp;</p>

<?php
	session_start();
   include 'dbConn.php';

   $SQLudt = "UPDATE users SET user_login_status = '0' WHERE user_id = '{$_SESSION['user_user_id']}'";
   if (mysql_query($SQLudt) !== TRUE) {
      echo mysql_connect_errno() . " - " . mysql_connect_error();
   }

   mysqli_close($link); 
   $_SESSION['user_user_id'] = null;
	$_SESSION['admin_id'] = null;
	$_SESSION['arenaId'] = null;
	$_SESSION['AdminUseOnly'] = null;
	session_destroy();
?>



  <input type="submit" name="RedirectToHome" id="RedirectToHome" value="Back to www.sabongnow.com home page" onclick="window.location='http://www.sabongnow.com'"/>

</form><p>&nbsp;</p></td>
</tr>
</table>

</body>
</html>
