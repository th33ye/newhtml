<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<?php
session_start();

	$_SESSION['user_user_id'] = null;
	$_SESSION['admin_id'] = null;
	$_SESSION['arenaId'] = null;
	$_SESSION['AdminUseOnly'] = null;

if (!empty($_POST['adminUserId']) && !empty($_POST['adminArenaId']) && !empty($_POST['adminId']))
{
	$_SESSION['user_user_id'] = $_POST['adminUserId'];
	$_SESSION['admin_user_id']  = $_POST['adminId'];
	$_SESSION['admin_arena_id']  = $_POST['adminArenaId'];
	$_SESSION['AdminUseOnly'] = "adminuseonly";
	
	/*
	
	$_SESSION['admin_username'] = $username;
    $_SESSION['admin_user_id'] = $user_id;
    $_SESSION['admin_arena_id'] = $arena_id;
	*/
	
	
	header("Location: " . "GameAdmin.php") ;
}
else if (!empty($_POST['userId']) && !empty($_POST['playerArenaId']))
{
	$_SESSION['user_user_id'] = $_POST['userId'];
	$_SESSION['arenaId'] = $_POST['playerArenaId'];
	header("Location: " . "GamePlayer.php");
}
else
{

	$_SESSION['user_user_id'] = null;
	$_SESSION['admin_id'] = null;
	$_SESSION['arenaId'] = null;
	$_SESSION['AdminUseOnly'] = null;
	//echo "invalid login";
	//echo $_POST['userId'] . "<br>" . $_POST['playerArenaId'];
}



?>

<body>
<form id="form1" name="form1" method="post" action="templogin.php">
  <label>User Id
  <input type="text" name="userId" id="userId" />
  </label>
  <label><br />
  Arena Id
  <input type="text" name="playerArenaId" id="playerArenaId" />
  <br />
  <input type="submit" name="Login" id="Login" value="Login as Player" />
  </label>
</form>


<form id="form2" name="form1" method="post" action="templogin.php">
  <label>User Id
  <input type="text" name="adminUserId" id="adminUserId" />
</label>
  <label><br />
  Admin Id
  <input type="text" name="adminId" id="adminId" />
  <br />
  ArenaId
  <input type="text" name="adminArenaId" id="adminArenaId" />
  <br />
  <input type="submit" name="Login2" id="Login2" value="Login as Admin" />
  </label>
</form>
<p>&nbsp;</p>
</body>
</html>
