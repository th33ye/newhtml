<?php
session_start();
require_once 'Swift-4.0.6/lib/swift_required.php';
//require_once '/hsphere/local/home/c125453/sabongnow.com/Swift-4.0.6/lib/swift_required.php';

function isValidEmail($email)
{
  $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$";
 
  if (eregi($pattern, $email)){
	 return true;
  }
  else {
	 return false;
  }   
}

function sendRegstrationEmail($sname, $pwd, $rndNo, $emailto)
{
	//Create the Transport
 	$from = "abenmachtech@gmail.com";
	$to = $emailto;
	$subject='Welcome to Sabong Now';
	$host = "smtp.gmail.com";
	$port = "465";
	$username = "abenmachtech@gmail.com";
	$password = "sabong$$$";
	
	/*
 	$from = "registration@sabongnow.com";
	$to = $emailto;
	$subject='Welcome to Sabong Now';
	$host = "mail.sabongnow.com";
	$port = "25";
	$username = "postmaster@sabongnow.com";
	$password = "4Q42GuP"; */
 	
	$body =  "Welcome Kabayang Sabongero, \n\n". 
			 "Someone with this email address " . $emailto . " has registered on our site at - \n".
			 "http://www.sabongnow.com \n\n".
			 "If you are not the one to have registered in our website, please disregard this message or delete this in your Inbox \n\n".

			 "Your account is currently INACTIVE. You cannot use it until you visit \n". 
			 "the following link or you may copy and paste the link in your browser's address bar: \n\n".
			 "http://www.sabongnow.com/activate.php?code=".$rndNo ." \n\n".
			 
 			 "Please keep this email for your record. Your account information is as follows: \n\n".
			 "************************************\n".
			 "Your username : " .$sname."\n".
			 "Your password : " .$pwd."\n".
			 "************************************"."\n\n".

			 
			 "MARAMING SALAMAT, \n". 
			 "www.sabongnow.com";
	$transport = Swift_SmtpTransport::newInstance($host, $port, 'ssl')
  		->setUsername($username)
  		->setPassword($password);
	$mailer = Swift_Mailer::newInstance($transport);
    /*
	$transport = Swift_SmtpTransport::newInstance($host, $port)
  		->setUsername($username)
  		->setPassword($password);
	$mailer = Swift_Mailer::newInstance($transport); */

	  //Create the Mailer using your created Transport
//	$mailer = Swift_Mailer::newInstance($transport);
	
	//Create a message
	$message = Swift_Message::newInstance($subject)
	  ->setFrom(array($from => 'Registration'))
	  ->setTo(array($to))
	  ->setBody($body)
	  ;
	  
	//Send the message
	$result = $mailer->send($message);
}

//include 'function.php';
function rand_str($length = 40, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890')
{
    // Length of character list
    $chars_length = (strlen($chars) - 1);

    // Start our string
    $string = $chars{rand(0, $chars_length)};
   
    // Generate random string
    for ($i = 1; $i < $length; $i = strlen($string))
    {
        // Grab a random character from our list
        $r = $chars{rand(0, $chars_length)};
       
        // Make sure the same two characters don't appear next to each other
        if ($r != $string{$i - 1}) $string .=  $r;
    }
   
    // Return the string
    return $string;
}


if(!empty($_POST['user_username']) && !empty($_POST['password']) && !empty($_POST['user_email']) )
{
	$username = $_POST['user_username'];
	$password = $_POST['password'];
	$user_email = $_POST['user_email'];
	$affiliate = $_POST['affiliate'];
	$myCountry = $_POST['country'];
	$hasEmail = 0;
	$hasUserName = 0;
	$rv = $_POST['rv'];
	$pass = $_POST['pass'];
	//echo ("rv: " . $rv . "<br>");
	//echo ("pass: " . $pass . "<br>");
	//$pass = $_REQUEST['pass'];
	
	if (isset($_SESSION['affiliateCode']))
	{
		$affiliateCode = "SBB"; 
	}
	else
	{
		$affiliateCode = "PCT";
	}
	
	if ($affiliate == "6" )
	{
		$affiliateCode = "SBB"; 
	}
	else
	{
		$affiliateCode = "PCT";
	}
	
	$status = 1; // set to zero if successfull
	
	if (isValidEmail($user_email) == false)
	{
		$_SESSION['registermessage'] = "Please provide a valid email. Please try again.";
		header("location:register.php"); // image validator is not correct!
	}
	else
	{
		include 'class.php';
		$passGen = new passGen(5);
		if($passGen->verify($pass, $rv)) //VALIDATE image for CAPTCHA
		{
			// Insert you code for processing the form here, e.g emailing the submission, entering it into a database. 
			$status = 0;  //image validator is correct!
			unset($_SESSION['security_code']);
			include 'dbconn.php'; // using mysqli_connect
//			include 'dbconn_normal.php'; // using mysql_connect
			// CHECK EMAIL IF EXIST
			$query = "SELECT user_email FROM users WHERE LOWER(user_email) = LOWER('" . mysqli_real_escape_string($link, $user_email) ."');";	

			if ($result = mysqli_query($link, $query)) 
			{ 
				// Fetch the results of the query *
				if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) )
				{
					$hasEmail = 1;
					$_SESSION['registermessage'] = "Email already exist. Please try again";
					mysqli_close($link);
					header("location:register.php"); 
				}
				
				// Destroy the result set and free the memory used for it 
				mysqli_free_result($result); 
			} 

			// CHECK USERNAME IF EXIST
			$query = "SELECT user_username FROM users WHERE LOWER(user_username) = LOWER('" . mysqli_real_escape_string($link, $username) ."');";	

			if ($result = mysqli_query($link, $query)) 
			{ 
				// Fetch the results of the query 
				if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) )
				{ 
					$hasUserName = 1;
					$_SESSION['registermessage'] = "Username already exist. Please try again";
					mysqli_close($link);
					header("location:register.php"); 
				} 
				
				// Destroy the result set and free the memory used for it 
				mysqli_free_result($result); 
			} 
			//mysqli_close($link);
			
			// Check if all information are complete and passed validation
			// if it passed validation insert new player
			
			if (($hasEmail ==0) && ($hasUserName == 0) && ($status == 0))
			{
				$rand = rand_str();
				$query3 = "call spInsertNewUser('" . mysqli_real_escape_string($link,$user_email) ."', '" .  mysqli_real_escape_string($link,$username) ."', '" . mysqli_real_escape_string($link,$password) ."', '" . $rand ."', '" . $affiliateCode ."', '". $myCountry ."');";
				
				if ($result3 = mysqli_query($link,$query3)) 
				{
					if ($row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC))
					{ 
						$retID =  $row3["LAST_INSERT_ID()"]; // assign returned userid 
						if ($retID <> 0) // check if there's a returned user id
						{
							$_SESSION['registermessage'] = "Successfully registered.";
							mysqli_close($link); 
							
							//INSERT HERE function to send email to user
							sendRegstrationEmail($username, $password, $rand, $user_email);
							header("location:register_success.php"); 
						}
						else
						{
							$_SESSION['registermessage'] = "<002> An error occurred while inserting Data. Please contact the Administrator.";
							mysqli_close($link); 
							header("location:register.php"); 
						}
					} 
					mysqli_free_result($result3); 
				}
				else
				{
					$_SESSION['registermessage'] = "<001> An error occurred. Please contact the Administrator.";
					mysqli_close($link); 
					header("location:register.php"); 
				}
			}
			// Close the connection 
			mysqli_close($link); 
		} 
		else 
		{
			// Insert your code for showing an error message here
			$status = 1;
			$_SESSION['registermessage'] = "Incorrect value on Image Validator. Please try again.";
			header("location:register.php"); // image validator is not correct!
		}
	
	}
} 

else
{
	header("location:register.php"); 
}
?> 


