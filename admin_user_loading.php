<?php
session_start();
if (isset($_SESSION['admin_username']) && $_SESSION['admin_username'] <> "" ) 
{
	//include('ipblocked.php');
	include 'dbconn_normal.php';
	$usercount = 0;
	$activate_usercount = 0;
	$countrylist = "";
	$rake = 0;
	$query = "SELECT DATE_FORMAT(w.wu_mtcn_date,'%Y-%m-%d') as dateSent, (w.wu_amount/10) as usd_amount, w.*  FROM westernunion w " .
				" where w.wu_mtcn_no <> 'MANUALOAD' " .
				" and w.wu_mtcn_no <> 'MANUALLOAD' " .
				" and w.wu_mtcn_no  <>  'VIRTUALOAD' " .
				" and w.wu_mtcn_no  <>  'BNKTRANSFR' " .
				" and w.wu_mtcn_no  <>  'BNKTRNSFR' " .
				" and w.wu_mtcn_no <> 'MANUALOAD' " .
				" and w.wu_mtcn_no <> 'ADJUSTMENT';";	
	//echo $query;
	if ($result = mysql_query($query)) 
	{ 
		// Fetch the results of the query *
		$country_count = 0;
		$bettor_count = 0;
		$rake = 0;
		while($row = mysql_fetch_array($result))
		  {
		  	$country_count = $country_count + 1;
			$rake = $rake + $row["usd_amount"];
			$countrylist .= "<tr><td align='center'>" . $country_count . "</td><td align='right'> ". $row["dateSent"] ."</td></td><td align='right'> ". $row["wu_mtcn_no"] ."</td><td align='right'> ". number_format($row["usd_amount"], 2)."</td></td><td align='left'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $row["wu_sendername"]."</td></tr>"; 
		  	
		  }
		
		// Destroy the result set and free the memory used for it 
		mysql_free_result($result); 
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
    		<h2>Manual Loading via WU</h2>
                                        
                                        <p>
                                        <table border ="0"  cellspacing="0" cellpadding="0">
                                        <tr>
                                        	<td width="50" align="center"><strong>#</strong></td>
                                            <td width="100" align="center"><strong>Date</strong></td>
                                            <td width="100" align="center"><strong>MTCN</strong></td>
                                            <td width="100" align="right"><strong>Amount</strong></td>
                                            <td width="200" align="center"><strong>Name</strong></td>
                                        </tr>
                                        
                                        <tr><td colspan="5">&nbsp;</td></tr>
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

