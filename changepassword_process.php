<?php
session_start();

if(!empty($_POST['password']) && !empty($_POST['cpassword']) )
{
	$cpassword = $_POST['cpassword'];
	$password = $_POST['password'];

	
	$rv = $_POST['rv'];
	$pass = $_POST['pass'];
	
	$status = 1; // set to zero if successfull
	$correct = 0;
	
		include 'class.php';
		$passGen = new passGen(5);
		if($passGen->verify($pass, $rv)) //VALIDATE image for CAPTCHA
		{
			// Insert you code for processing the form here, e.g emailing the submission, entering it into a database. 
			$status = 0;  //image validator is correct!
			unset($_SESSION['security_code']);
			include 'dbconn.php'; // using mysqli_connect
//			include 'dbconn_normal.php'; // using mysql_connect
			
			$query = "SELECT user_password 
                  FROM users 
                  WHERE user_password = md5('" . mysqli_real_escape_string($link, $cpassword) ."') 
                     AND user_email = '". $_SESSION['user_email'] ."' 
                     AND user_username = '". $_SESSION['user_username'] ."' ;";	
//			echo $query;
			if ($result = mysqli_query($link, $query)) 
			{ 
				// Fetch the results of the query *
				if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) )
				{ 
					//update password	
					$correct = 1;
				} 
				else
				{
					$_SESSION['registermessage'] = "Invalid Current Password. Please try again.";
					header("location:changepassword.php"); // image validator is not correct!
				}
				
				// Destroy the result set and free the memory used for it 
				mysqli_free_result($result); 
			} 
			
			if ($correct == 1)
			{
				//update password
				$query = "UPDATE users 
                        SET user_password = md5('". mysqli_real_escape_string($link, $password) ."')  
                     WHERE user_email = '". $_SESSION['user_email'] ."' 
                        AND user_username = '". $_SESSION['user_username'] ."' ;";	
				echo $query;
				if ($result = mysqli_query($link, $query)) 
				{
					header("location:changepassword_success.php");
				}
				else
				{
					$_SESSION['registermessage'] = "Problem with updating your record. Please try again.";
					header("location:changepassword.php"); // image validator is not correct!
				}
			}
						
		} 
		else 
		{
			// Insert your code for showing an error message here
			$status = 1;
			$_SESSION['registermessage'] = "Incorrect value on Image Validator. Please try again.";
			header("location:changepassword.php"); // image validator is not correct!
		}

		
	
} 

else
{
//	echo "dude";
	//header("location:changepassword.php"); 
}
?> 


