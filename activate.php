<?php

	$code= $_REQUEST['code'];
	if($code==''){
		header("location:sbnew_activate_message.php?code=0");
	}
	else
	{
		include 'dbconn.php';
		
		mysqli_query($link, "UPDATE users SET user_status = 1 WHERE user_activation_code = '". mysqli_real_escape_string($link, $code) ."'");
		if (mysqli_errno($link) == 0)
		{
			mysqli_close($link); 
			header("location:sbnew_activate_message.php?code=1");
		}
		else
		{
			mysqli_close($link); 
			header("location:sbnew_activate_message.php?code=2");
		}
	}
	
?>
