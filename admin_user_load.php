<?php
session_start();
if (isset($_SESSION['admin_username']) && $_SESSION['admin_username'] <> "" ) 
{
    // sender
	if (isset($_POST['username']))
	{
		$username = strtoupper($_POST['username']);
		//include 'dbconn_normal.php';
		include 'dbconn.php';
		$query = "SELECT u.user_id, u.user_username AS user, w.wu_mtcn_no AS mtcn, DATE(w.wu_mtcn_date) AS mtcndate, w.wu_amount AS amt  
				FROM users u
				LEFT JOIN westernunion w
					ON u.user_id = w.user_id
				WHERE LOWER(u.user_username) = LOWER('". $_POST['username'] ."')
				ORDER BY w.wu_date_created DESC";
		$result = mysqli_query($link, $query);		
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
<link href="js/css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" type="text/css" />
<!--
<script language="javascript" type="text/javascript" src="datetimepicker.js">

//Date Time Picker script- by TengYong Ng of http://www.rainforestnet.com
//Script featured on JavaScript Kit (http://www.javascriptkit.com)
//For this script, visit http://www.javascriptkit.com

</script>
-->

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
    	
    		<strong>View User Loading History</strong>
            <br />
            <br />
            <form  method="post" name="searchForm" target="_self">
                <table>
                    <tr>
                        <td><strong></strong>Username</strong></td>
                        <td><input name="username" type="text" size="15" maxlength="15" /></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input name="Search" type="submit" /></td>
                    </tr>
                </table>
            <!--
            <strong>User Name:</strong>&nbsp; <input name="username" type="text" size="15" maxlength="15" /> &nbsp; &nbsp; &nbsp; <input name="Search" type="submit" />
            -->
            </form>
            <br />
            <br />
            <?php 
            if(isset($result)) 
			{
	            if(mysqli_num_rows($result) > 0) 
				{
					echo 'Loading History of: <b>' . $username . '</b>';
					echo '<table width="550" border="1" cellpadding="0" cellspacing="0">';
					echo '<tr><td align="center"><b>Type</b></td>
							<td align="center"><b>Date</b></td>
							<td align="center"><b>Credits</b></td>
						</tr>';
					// Fetch the results of the query *
					while ($row = mysqli_fetch_array($result))
					{
						echo '<tr>';
						echo '<td align="center">';
						echo $row["mtcn"];
						echo '</td>';
						echo '<td align="center">';
						echo $row["mtcndate"];
						echo '</td>';						
						echo '<td align="center">';
						echo number_format($row["amt"],2);
						echo '</td>';					
						echo '<tr>';
					}
					echo '</table>';
	            }
			}
            ?>
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
   <script type="text/javascript" src="js/jquery-1.5.2.js"></script>
   <script type="text/javascript" src="js/jquery.validate/js"></script>
   <script type="text/javascript" src="js/jquery.validate.js"></script>
   <script type="text/javascript" src="js/jquery-ui-1.8.11.custom.min.js"></script>
   <script type="text/javascript">
      $(document).ready(function(){
         $("#dateSent").datepicker({ showOn: 'button', buttonText: "select", dateFormat: 'yy-mm-dd' });
      });

      // form validator
      $("#withdraw_form").validate({
         rules: {
            amount: {
               required: true,
               number: true
            },
            dateSent: {
               required: true,
               date: true
            }
         },
         messages: {
            dateSent: "Required"
         }
      });

   </script>
</body>
</html>

<?php 
if (isset($_SESSION['messageLoad']))
{
	$_SESSION['messageLoad'] = ""; 
}

if (isset($_SESSION['errormessage']))
{
	$_SESSION['errormessage'] = ""; 
}

if (isset($_SESSION['registermessage']))
{
	$_SESSION['registermessage'] = ""; 
}
?>

