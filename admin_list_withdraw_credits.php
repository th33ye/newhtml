<?php
/**
   Filename: admin_wu_loaded_credits.php
   Modified by: Phoenix
   Last Modification: 04/15/2011
**/

session_start();
if (isset($_SESSION['admin_username']) && $_SESSION['admin_username'] <> "" ) 
{
	//include('ipblocked.php');
	include 'dbconn.php';
	$usercount = 0;
	$activate_usercount = 0;
	$countrylist = "";
	$rake = 0;
	$wuSQuery = "SELECT c.id, u.user_username, c.credit_hist_amount, c.credit_hist_date_created 
               FROM credithistory c 
               LEFT JOIN users u
				ON c.credit_hist_user_id = u.user_id
			   WHERE DATE(credit_hist_date_created) >= DATE('2013-10-01') 
              ORDER BY c.id"; // c.credit_hist_date_created";
	//echo $query;
	if ($result = mysqli_query($link, $wuSQuery)) 
	{ 
		// Fetch the results of the query *
		$recId = 0;
		$bettor_count = 0;
		$rake = 0;
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
      {
//		   $recId = $recId + 1;
         $recId = $row["wu_id"];
         $sender = ucwords(strtolower($row["wu_sendername"]));
         $usd_amount = number_format($row["credit_hist_amount"],2);
			$rake = $rake + $row["usd_amount"];
         //$countrylist .= "<tr><td align='center'>$country_count</td><td align='right'>{$row["dateSent"]}</td><td align='right'>{$row["wu_mtcn_no"]}</td><td align='right'>$usd_amount</td><td align='left'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$sender</td></tr>"; 
			$countrylist .= "<tr><td align='right'>{$row["id"]}</td><td align='right'>{$row["user_username"]}</td><td align='right'>{$row["credit_hist_amount"]}</td><td>{$row["credit_hist_date_created"]}</td></tr>"; 
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
    		<h2>Withdrawn Credits</h2>
         <p>
         <table border ="1" width="100%">
            <tr>
               <td width="50" align="center"><strong>Reference #</strong></td> 
               <td align="center"><strong>Username</strong></td>
               <td align="center"><strong>Withdrawn Amount</strong></td>
               <td align="right"><strong>Date</strong></td>
            </tr>
            <tr><td colspan="6">&nbsp;</td></tr>
            <?php 
               echo $countrylist;
            ?>
            <tr><td colspan="6">&nbsp;</td></tr>
            <tr><td colspan="3" align="right"><strong>TOTAL &nbsp;&nbsp;&nbsp;</strong></td><td align="right"><strong><?php echo number_format($rake,2); ?></strong></td><td align="right"></td><td></td></tr>
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

