<?php
/**
   Filename: admin_top_gunner.php
   Modified by: Phoenix
   Last Modification: 04/15/2011
**/
session_start();
if (isset($_SESSION['admin_username']) && $_SESSION['admin_username'] <> "" ) 
{
	//include('ipblocked.php');
	include 'dbconn.php';
	$countrylist = "";
	$uSQuery = "SELECT UPPER(user_username) AS username,
                  user_credits,
                  UPPER(user_country) AS country,
                  LOWER(user_email) AS email
               FROM users 
               ORDER BY user_credits DESC LIMIT 10"; 
//	echo $uSQuery;
	if ($result = mysqli_query($link, $uSQuery)) 
	{
		// Fetch the results of the query *
		$rank = 0;
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
      {
		   $rank = $rank + 1;
         $credits = number_format($row["user_credits"],2);
			$countrylist .= "<tr><td align='center'>$rank</td><td align='left'>{$row["username"]}</td><td align='right'>$credits</td><td align='left'>&nbsp;&nbsp;&nbsp;{$row["country"]}</td><td align='left'>{$row["email"]}</td></tr>"; 
		  }
		
		// Destroy the result set and free the memory used for it 
		mysqli_free_result($result); 
	} 
}
else
{
	header('Location:admin_index.php');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sabong Now</title>
<link href="CFA.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="datetimepicker.js">

//Date Time Picker script- by TengYong Ng of http://www.rainforestnet.com
//Script featured on JavaScript Kit (http://www.javascriptkit.com)
//For this script, visit http://www.javascriptkit.com

</script>
</head>

<body class="body">
	<!--Site Wrapper -->
<div class="site-wrapper" align="center">
<!--Header -->
			<div class="header-wrapper"></div>
            <!--End Header -->
            
            <!--Navigation -->
 
	<!--End of Navigation -->
        
    <!--Body Wrapper -->
<table  class="body-wrapper" width="1000"border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3" align="center" class="bodyTop">&nbsp;</td>
    </tr>
  <tr>
    <td width="160" align="right" valign="top" class="LeftPanel">
    
    	<?php 
	  		include 'admin_leftnav.php'; 
	  	?>
    
    </td>
    <td width="650"  align="center" valign="top" class="content">
    
     <!--COntent -->		
    <div id="content">
    		<h2>Sabongnow.com Top Gunner</h2>
                                        
                                        <p>
                                        <table border ="0"  cellspacing="0" cellpadding="2">
                                        <tr>
                                        	<td width="25" align="center"><strong>Rank</strong></td>
                                            <td width="100" align="center"><strong>Username</strong></td>
                                            <td width="75" align="center"><strong>Credits</strong></td>
                                            <td width="150" align="center"><strong>Location</strong></td>
                                            <td width="200" align="center"><strong>Email</strong></td>
                                        </tr>
                                        
                                        <tr><td colspan="5">&nbsp;</td></tr>
                                         <?php 
										 	echo $countrylist;
										 ?>
                                         <tr><td colspan="5">&nbsp;</td></tr>
                                        </table>
                                        
                                        </p>
    </div>
    <!--End of Main Content -->
    
    </td>
    <!--LogIn Panel -->
    
    <td width="185" align="left" valign="top">
    	<?php
			if (isset($_SESSION['errormessage']))
			{
				
				if (isset($_SESSION['admin_username']) && $_SESSION['admin_username'] <> "" ) 
				{
					include 'admin_loginnav.php'; 
				}
				else
				{
					include 'admin_loginform.php'; 
				}
			}
			else
			{
				if (isset($_SESSION['admin_username']) && $_SESSION['admin_username'] <> "" ) 
				{
					include 'admin_loginnav.php'; 
				}
				else
				{
					include 'admin_loginform.php'; 
				} 
			}
			?>
    </td>
  </tr>
  <tr>
    <td colspan="3" align="center">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="3" align="center" class="bodyBottom">&nbsp;</td>
    </tr>
</table>
<!--End of Body Wrapper -->

<!--Footer Bar -->
<div class="FooterBar"></div>
<!--End of Footer Bar -->

<div class="footer">All Rights Reserved © 2010 - 2011 by www.sabongnow.com

</div>


  </div>
	<!--End of Site Wrapper -->
</body>
</html>

<?php 
if (isset($_SESSION['errormessage']))
{
	$_SESSION['errormessage'] = ""; 
}

if (isset($_SESSION['registermessage']))
{
	$_SESSION['registermessage'] = ""; 
}
?>

