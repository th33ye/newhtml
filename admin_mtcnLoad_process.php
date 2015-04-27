<?php
session_start();

if ( isset($_SESSION['admin_username']) &&
	($_SESSION['admin_username'] <> "") &&
	!empty($_POST['mtcn']) )
{
	$user_id = $_POST['userid'];
	$user_username = $_POST['username'];
	$mtcn = $_POST['mtcn'];
	$senderAmount = $_POST['senderAmount'];
   $bonusPoint = $_POST['bonusPoint'];
   $totPoint = $senderAmount + $bonusPoint;
	$dateSent = $_POST['dateSent'];
	$senderName = $_POST['senderName'];
	$senderAddress = $_POST['senderAddress'];

//	$senderAmount = $senderAmount * 10;
//	echo $dateSent;
//	$dateSent = date_create_from_format('j-m-Y', $dateSent);
//	echo date_format('Y-m-d', $dateSent);
//	$dateRaw = date_parse($dateSent);

//	$dateNew = $dateRaw['year'] . "-" . $dateRaw['month'] . "-". $dateRaw['day'];
//	$dateSent = $dateNew;  


	
	// IN mtcn VARCHAR(10), IN senderName VARCHAR(100), IN senderAddress VARCHAR(100), IN sendDate DATETIME,
    // IN userName VARCHAR(15), IN loadCredits DOUBLE, IN userID INT)
								   
	include 'dbconn.php';  
//	using mysqli_connect
	// update westernunion table based on load provided
	$wuIQuery = "INSERT INTO westernunion (user_id,
               wu_mtcn_no, 
					wu_mtcn_date, 
					wu_amount,
               wu_bonus_credit, 
					wu_sendername, 
					wu_senderaddress) 
				VALUES('$user_id',
               '$mtcn', 
					'$dateSent', 
					'$senderAmount', 
               '$bonusPoint',
					'$senderName', 
					'$senderAddress')";

//	$query = "call spLoadCreditsWU('". $mtcn ."', '" .  $senderName ."', '" . $senderAddress ."', '" . $dateSent ."', '" . $user_username ."', ". 
//							$senderAmount .", " . $user_id . ");";
//	
	if ($wuResult = mysqli_query($link,$wuIQuery)) 
	{
		// update user_credits in Users table
		$uUQuery = "UPDATE users SET user_credits = user_credits + $totPoint WHERE user_id = $user_id";

		if ($uResult = mysqli_query($link, $uUQuery))
		{
			//mysqli_free_result($result); 
			mysqli_close($link);
			$_SESSION['messageLoad'] = "Manual Loading Successful";
			header("location:admin_mtcn_load_success.php");
		}
	}
	else
	{
		mysqli_close($link);
		echo ("Manual Loading Failed");
	}
	
}

?>

<body>
</body>
</html>
