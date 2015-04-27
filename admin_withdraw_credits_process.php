<?php
session_start();
if ($_POST['userid'] <> "")
{

	$user_id = $_POST['userid'];
	$user_username = $_POST['username'];
	$amount = $_POST['amount'];
	$credits = $_POST['credits'];
	$dateSent = $_POST['dateSent'];
	$description = $_POST['description'];
	
	if ($amount > $credits)
	{
		$_SESSION['messageLoad'] = "Amount can't be greater than Credits";
		header("location:admin_withdraw_credits.php");
	}
	
//	$amount = $amount * 10;
/*	
	$dateRaw = date_parse($dateSent);
	$dateNew = $dateRaw['year']  . "-" . $dateRaw['month'] . "-". $dateRaw['day'];
	$dateSent = $dateNew;  
*/	
	
	// IN mtcn VARCHAR(10), IN senderName VARCHAR(100), IN senderAddress VARCHAR(100), IN sendDate DATETIME,
    // IN userName VARCHAR(15), IN loadCredits DOUBLE, IN userID INT)
//	include 'dbconn_normal.php'; // using mysql_connect								   
	include 'dbconn.php'; // using mysqli_connect
	
	$query = "UPDATE users SET user_credits = user_credits - " . $amount . " WHERE user_id = " .  $user_id . ";";	
   				
	if ($result = mysqli_query($link, $query)) 
	{
		$query = "call spLogHistory(". $user_id .", 0, 0, 0, 0, 13, ". $amount .", 0, 0, 'WITHDRAWAL MANUAL via WU MTCN', ". $user_id .");";
		if (mysqli_query($link, $query) == true) 
		{
			//mysqli_free_result($result); 
			mysqli_close($link);
			$_SESSION['messageLoad'] = "Withdrawal successful.";
			header("location:admin_withdraw_credits.php");
		}
		else
		{
			mysqli_close($link);
			$_SESSION['messageLoad'] = "Problem with withdrawal.";
			header("location:admin_withdraw_credits.php");
		}
				
	}
	else
	{
		mysqli_close($link);
		$_SESSION['messageLoad'] = "Problem with withdrawal.";
		header("location:admin_withdraw_credits.php");
	}
	
}
else
{
	header("location:admin_withdraw_credits.php");
}


?>


