<?php
/**
 Filename: admin_bank_loaded_credits.php
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
	/*
	$wuSQuery = "SELECT wu_id, DATE_FORMAT(w.wu_mtcn_date,'%Y-%m-%d') AS dateSent, (w.wu_amount) AS usd_amount, UPPER(w.wu_mtcn_no) AS mtcn, w.*, UPPER(u.user_username) AS username 
      FROM westernunion w
      LEFT JOIN users u
         ON w.user_id = u.user_id
       WHERE w.wu_mtcn_no = 'MANUALOAD'
         OR w.wu_mtcn_no = 'MANUALLOAD'
         OR w.wu_mtcn_no = 'VIRTUALOAD'
         OR w.wu_mtcn_no = 'BNKTRANSFR'
         OR w.wu_mtcn_no = 'BNKTRNSFR'
         OR w.wu_mtcn_no = 'MANAUALOAD'
         OR w.wu_mtcn_no = 'BNKTRANSFR'
         OR w.wu_mtcn_no = 'BANKTRNSFR'
         OR w.wu_mtcn_no = 'bank trans'
         OR w.wu_mtcn_no = 'VIRTUAL'
         OR w.wu_mtcn_no = 'ADJUSTMENT'
         OR w.wu_mtcn_no = 'BANK'
      ORDER BY w.wu_date_created";
	 */
	$wuSQuery = "SELECT wu_id, DATE_FORMAT(w.wu_mtcn_date,'%Y-%m-%d') AS dateSent, 
					(w.wu_amount) AS usd_amount, 
					UPPER(w.wu_mtcn_no) AS mtcn, w.*, 
					UPPER(u.user_username) AS username 
      FROM westernunion w
      LEFT JOIN users u
         ON w.user_id = u.user_id
       WHERE (w.wu_mtcn_no = 'MANUALOAD'
         OR w.wu_mtcn_no = 'MANUALLOAD'
         OR w.wu_mtcn_no = 'VIRTUALOAD'
         OR w.wu_mtcn_no = 'BNKTRANSFR'
         OR w.wu_mtcn_no = 'BNKTRNSFR'
         OR w.wu_mtcn_no = 'MANAUALOAD'
         OR w.wu_mtcn_no = 'BNKTRANSFR'
         OR w.wu_mtcn_no = 'BANKTRNSFR'
         OR w.wu_mtcn_no = 'bank trans'
         OR w.wu_mtcn_no = 'VIRTUAL'
         OR w.wu_mtcn_no = 'ADJUSTMENT'
		 OR w.wu_mtcn_no = 'BANK') 
		 AND (DATE(w.wu_mtcn_date) >= DATE('2013-10-01')) 
      ORDER BY w.wu_id";	  
	//echo $query;
	if ($result = mysqli_query($link, $wuSQuery)) 
	{ 
		// Fetch the results of the query *
		$country_count = 0;
		$bettor_count = 0;
		$rake = 0;
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
      {
		   $country_count = $country_count + 1;
         $usd_amount = number_format($row["usd_amount"],2);
         $sender = ucwords(strtolower($row["wu_sendername"]));
			$rake = $rake + $row["usd_amount"];
//			$countrylist .= "<tr><td align='center'>$country_count</td><td align='right'>{$row["dateSent"]}</td><td align='right'>{$row["mtcn"]}</td><td align='right'>$usd_amount</td></td><td align='left'>$sender</td><td>{$row["username"]}</td></tr>";		  	
			$countrylist .= "<tr><td align='right'>{$row['wu_id']}</td><td align='right'>{$row["dateSent"]}</td><td align='right'>{$row["mtcn"]}</td><td align='right'>$usd_amount</td><td align='left'>{$row["wu_bonus_credit"]}</td><td align='left'>$sender</td><td>{$row["username"]}</td></tr>";		  	
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
<table  class="body-wrapper" width="1100"border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3" align="center" class="bodyTop">&nbsp;</td>
    </tr>
  <tr>
    <td width="160" align="right" valign="top" class="LeftPanel">
    
    	<?php 
	  		include 'admin_leftnav.php'; 
	  	?>
    
    </td>
    <td width="800"  align="center" valign="top" class="content">
    
     <!--COntent -->		
   <div id="content">
      <h2>Manual Loading via Bank Transfer / Virtual</h2>
      <p>
      <table border ="1" width="100%">
         <tr>
            <td align="center"><strong>#</strong></td>
            <td align="center"><strong>Date Loaded</strong></td>
            <td align="center"><strong>Load Type</strong></td>
			<td align="center"><strong>Amount</strong></td>
			<td align="center"><strong>BP</strong></td>
            <td align="center"><strong>Sender Name</strong></td>
            <td align="center"><strong>Loaded To</strong></td>
         </tr>
         <tr><td colspan="7">&nbsp;</td></tr>
         <?php 
            echo $countrylist;
         ?>
         <tr><td colspan="5">&nbsp;</td></tr>
         <tr><td colspan="3" align="right"><strong>TOTAL &nbsp;&nbsp;&nbsp;</strong></td><td align="right"><strong><?php echo number_format($rake,2); ?></strong></td><td align="right"></td></tr>
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

