<?php
session_start();

function get_ip_address() {
	foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
		if (array_key_exists($key, $_SERVER) === true) {
			foreach (explode(',', $_SERVER[$key]) as $ip) {
				if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
					return $ip;
				}
			}
		}
	}
}

/*
	This page check username and password
*/
//echo $_SERVER['HTTP_REFERER'];

if(!empty($_POST['username']) && !empty($_POST['passwd']))
{
	include 'dbconn.php';
	$username = $_POST['username'];
	$password = $_POST['passwd'];
   	
	/* Send a query to the server */ 	
//	$query = "call spLogin('" . mysqli_real_escape_string($link,$username) . "',  '". mysqli_real_escape_string($link,$password) ."');";
   $query = "SELECT * FROM users 
            WHERE LOWER(user_username) = LOWER('" . mysqli_real_escape_string($link, $username) . "') 
               AND LOWER(user_password) = LOWER(md5('" . mysqli_real_escape_string($link, $password) . "')) 
               AND ((user_status = '1' AND user_login_status = '0' AND banned = '0') OR vip = '1')
            LIMIT 1";
	if ($result = mysqli_query($link,$query)) 
	{ 
		/* Fetch the results of the query */ 
		if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) )
		{ 
			$_SESSION['user_id']  	 = $row["user_id"]; 
         	$_SESSION['user_user_id'] = $row["user_id"];
			$_SESSION['user_username'] = $row["user_username"];
			$_SESSION['user_credits'] = $row["user_credits"];
			$_SESSION['with_chat'] = (int)$row["with_chat"];
			$_SESSION['vip'] = (int)$row["vip"];
			$_SESSION['user_email'] =  $row["user_email"];
			$_SESSION['user_wallet_id'] =  $row["user_wallet_id"];
			$_SESSION['user_wallet_acct_id'] =  $row["user_wallet_acct_id"];
			$_SESSION['arenaId'] = 1; //Default

			mysqli_close($link); 
         
         	include 'dbconn.php';

         	$SQLudt = "UPDATE users SET user_login_status = '1' WHERE user_id = '{$row['user_id']}'";
         	if (mysqli_query($link,$SQLudt) !== TRUE) {
            	echo mysqli_connect_errno() . " - " . mysqli_connect_error();
         	}
         	
         	mysqli_close($link);
         	include 'dbconn.php';
         	
         	$real_ip = get_ip_address();				// supposed to be real ip
         	$userid = $_SESSION['user_id'];				// userid
         	$username = $_SESSION['user_username'];		// userusername
         	$remoteip = $_SERVER['REMOTE_ADDR'];		// remote ip
         	$useragent = $_SERVER['HTTP_USER_AGENT'];	// user agent
         	$useragent = (strlen($useragent) > 250) ? substr($useragent,0,247).'...' : $useragent;
         	$loginLog = "INSERT INTO login_history (player_id, player, remote_ip, real_ip, user_agent)
         				VALUES ('$userid','$username','$remoteip','$real_ip','$useragent')";
         	if (mysqli_query($link,$loginLog) !== TRUE) {
         		echo mysqli_connect_errno() . " - " . mysqli_connect_error();
         	}         	 

			mysqli_close($link);
				
			header("location:index.php");
		} 
		else
		{
			$_SESSION['errormessage'] = "* The username or password you entered is incorrect";
			mysqli_close($link); 
			header("Location:" . $_SERVER['HTTP_REFERER']);
		}
		/* Destroy the result set and free the memory used for it */ 
		mysqli_free_result($result); 
	}
	/* Close the connection */ 
	//mysqli_close($link); 
} 
else
{
	$_SESSION['errormessage'] = "* Username or Password cannot be empty";
	header("Location:" . $_SERVER['HTTP_REFERER']);
}
?> 
