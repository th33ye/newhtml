<?php
session_start();
if (isset($_SESSION['admin_username']) && $_SESSION['admin_username'] <> "" ) 
{
//	include 'dbconn_normal.php';
   include 'dbconn.php';
	$usercount = 0;
	$activate_usercount = 0;
	$countrylist = "";
//	$query = "SELECT sum(bet_sum_total_winnings) as rake , DATE_FORMAT(bet_sum_date_created,'%Y-%m-%d') as dateRake FROM betsummary where bet_sum_total_winnings > 0
//			group by DATE_FORMAT(bet_sum_date_created,'%Y-%m-%d');";	

   $rSQuery = "SELECT DATE_FORMAT(datereceived, '%Y-%m-%d') AS rakedate,
                  SUM(AmountGiven) AS winningcredits,
                  SUM(commissionamount) AS rake
               FROM sabongpointsbank
               GROUP BY DATE_FORMAT(datereceived, '%Y-%m-%d')";
//   echo $rSQuery;               
	if ($result = mysqli_query($link,$rSQuery)) 
	{ 
		// Fetch the results of the query *
		$country_count = 0;
		$bettor_count = 0;
		$rake = 0;
		while($row = mysqli_fetch_array($result))
		  {
		  	$country_count = $country_count + 1;
         $daily_winning = number_format($row['winningcredits'] + $row['rake'], 2);
         $daily_rake = number_format($row['rake'], 2);
         $tot_winning = $tot_winning + $row['winningcredits'] + $row['rake'];
         $tot_rake = $tot_rake + $row['rake'];
			$rake = $rake + $row["rake"];
//			$countrylist .= "<tr><td align='center'>" . $country_count . "</td><td align='right'> ". $row["dateRake"] ."</td><td align='right'> ". number_format($row["rake"], 2)."</td><td align='right'> ". number_format(($row["rake"]/10/10), 2)."</td></tr>"; 
         $countrylist .= "<tr><td align='center'>{$row['rakedate']}</td><td align='right'>$daily_winning</td><td align='right'>$daily_rake</td></tr>"; 
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
    		<h2>DAILY RAKE</h2>
         <p>
         <table border ="1" width="100%">
            <tr>
               <td width="100" align="center"><strong>Date</strong></td>
               <td width="100" align="right"><strong>Daily Winnings</strong></td>
               <td width="100" align="right"><strong>Daily Rake</strong></td>
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <?php 
               echo $countrylist;
            ?>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr>
               <td colspan="2" align="right">
                  <strong>TOTAL Winnings</strong>
               </td>
               <td align="right">
                  <strong><?php echo number_format($tot_winning,2); ?></strong>
               </td>
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr>
               <td colspan="2" align="right">
                  <strong>TOTAL Rake</strong>
               </td>
               <td align="right">
                  <strong><?php echo number_format(($tot_rake),2); ?></strong>
               </td>
            </tr>
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

