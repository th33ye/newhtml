<?php
session_start();
//clears all session
   include 'dbconn.php';

   $SQLudt = "UPDATE users SET user_login_status = '0' WHERE user_id = '{$_SESSION['user_id']}'";
   if (mysqli_query($link,$SQLudt) !== TRUE) {
      echo mysqli_connect_errno() . " - " . mysqli_connect_error();
   }

   mysqli_close($link); 

// unset all of the session variables
$_SERVER=array();
$_SESSION = array();   
// finally destroy the session
session_destroy();

header('Location:index.php');

?> 


