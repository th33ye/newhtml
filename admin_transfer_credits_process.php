<?php
session_start();
if ($_POST['frm_userid'] <> "")
{
    //sender
	$frm_user_id = $_POST['frm_userid'];
	$frm_user_username = $_POST['frm_username'];
    $frm_user_credits = $_POST['frm_credits'];
    
    //receiver
    $to_user_id = $_POST['to_userid'];
    $to_user_username = $_POST['to_username'];
    
	$amount = $_POST['amount'];
	//$credits = $_POST['credits'];
	$dateSent = $_POST['dateSent'];
	//$description = $_POST['description'];
	
	if ($amount > $frm_user_credits)
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
    //withdrawal stage
	$query = "UPDATE users SET user_credits = user_credits - " . $amount . " WHERE user_id = " .  $frm_user_id . ";";	
	if ($result = mysqli_query($link, $query)) 
	{
        $wMsg = "TRANSFERRED CREDITS TO " . $to_user_username;
        $chSql = "INSERT INTO credithistory (credit_hist_user_id, credit_hist_amount, credit_hist_trans_id, credit_hist_comments, credit_hist_created_by, credit_hist_date_created) VALUES ('$frm_user_id', '$amount', '13', '$wMsg', '$frm_user_id', NOW())";
		//$query = "call spLogHistory(". $frm_user_id .", 0, 0, 0, 0, 13, ". $amount .", 0, 0, ". $wMsg .", ". $frm_user_id .");";
		if (mysqli_query($link, $chSql) == true) 
		{
            // loading stage - will happen only when withdrawal is successful
            $lquery = "UPDATE users SET user_credits = user_credits + " . $amount . " WHERE user_id = " .  $to_user_id . ";";
            if (mysqli_query($link, $lquery) == true) 
            {
                $wMsg = "TRANSFERRED CREDITS FROM " . $frm_user_username;
                $wuSql = "INSERT INTO westernunion (user_id, wu_mtcn_no, wu_mtcn_date, wu_amount, wu_sendername, wu_date_created) 
                            VALUES ('" . $to_user_id . "', 'VIRTUAL', NOW(), '" . $amount . "', '" . $wMsg . "', NOW())";
                if (mysqli_query($link, $wuSql) == true)
                {                
                    //mysqli_free_result($result); 
                    mysqli_close($link);
                    $_SESSION['messageLoad'] = "Credits Transfer successful.";
                    header("location:admin_transfer_credits.php");
                }
            }
		}
		else
		{
			mysqli_close($link);
			$_SESSION['messageLoad'] = "Problem with Credits Transfer.";
			header("location:admin_transfer_credits.php");
		}
	}
	else
	{
		mysqli_close($link);
		$_SESSION['messageLoad'] = "Problem with Credits Transfer.";
		header("location:admin_transfer_credits.php");
	}
}
else
{
	header("location:admin_transfer_credits.php");
}


?>


