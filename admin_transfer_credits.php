<?php
session_start();
if (isset($_SESSION['admin_username']) && $_SESSION['admin_username'] <> "" ) 
{
	//echo $_POST['username'];
	$frm_user_id = 0;
	$frm_user_credits = 0;
	$frm_user_username = "";
//	$frm_user_credits = "";
    
	$to_user_id = 0;
	$to_user_credits = 0;
	$to_user_username = "";
//	$to_user_credits = "";
    
    // sender
	if (isset($_POST['frmusername']))
	{
		//include 'dbconn_normal.php';
      include 'dbconn.php';
		$query = "SELECT user_id, user_username, user_credits FROM users WHERE LOWER(user_username) = LOWER('". $_POST['frmusername'] ."') AND user_status = 1";		
		if ($result = mysqli_query($link, $query)) 
		{ 
			// Fetch the results of the query *
			if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) )
			{ 
				$frm_user_id = $row['user_id'];
				$frm_user_username = $row['user_username'];
				$frm_user_credits = number_format($row['user_credits'], 3, '.', '');
				if (is_null($frm_user_credits) or $frm_user_credits == "")
				{
					$frm_user_credits = 0;
				}
				
				//$user_credits = $row['user_credits'];
				mysqli_close($link); 
			} 
			
			// Destroy the result set and free the memory used for it 
			mysqli_free_result($result); 
		} 
	}
    // receiver
	if (isset($_POST['tousername']))
	{
		//include 'dbconn_normal.php';
      include 'dbconn.php';
		$query = "SELECT * FROM users WHERE LOWER(user_username) = LOWER('". $_POST['tousername'] ."') AND user_status = 1";		
		if ($result = mysqli_query($link, $query)) 
		{ 
			// Fetch the results of the query *
			if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) )
			{ 
				$to_user_id = $row['user_id'];
				$to_user_username = $row['user_username'];
				$to_user_credits = number_format($row['user_credits'], 3, '.', '');
				if (is_null($to_user_credits) or $to_user_credits == "")
				{
					$to_user_credits = 0;
				}
				
				//$user_credits = $row['user_credits'];
				mysqli_close($link); 
			} 
			
			// Destroy the result set and free the memory used for it 
			mysqli_free_result($result); 
		} 
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
    	
    		<strong>Use this to Transfer Credits</strong>
            <br />
            <?php
            if (isset($_SESSION['messageLoad']))
            {
                echo $_SESSION['messageLoad']; 
            }
            ?>
            <br />
            <form  method="post" name="searchForm" target="_self">
                <table>
                    <tr>
                        <td><strong>Credits From Username</strong></td>
                        <td><input name="frmusername" type="text" size="15" maxlength="15" /></td>
                    </tr>
                    <tr>
                        <td><strong>Credits To Username</strong></td>
                        <td><input name="tousername" type="text" size="15" maxlength="15" /></td>
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
            <form action="admin_transfer_credits_process.php" method="post" name="myForm" id="withdraw_form">
            <?php
				if ($frm_user_id > 0)
				{
			?>
            
            <input name="frm_username" type="hidden" value="<?php echo $frm_user_username ?>" />
            <input name="frm_userid" type="hidden" value="<?php echo $frm_user_id ?>" />
             <input name="frm_credits" type="hidden" value="<?php echo $frm_user_credits ?>" />
             
            <input name="to_username" type="hidden" value="<?php echo $to_user_username ?>" />
            <input name="to_userid" type="hidden" value="<?php echo $to_user_id ?>" />
             <input name="to_credits" type="hidden" value="<?php echo $to_user_credits ?>" />
             
            <?php
				}
			?>
            <table width="550" border="1" cellpadding="0" cellspacing="0">
              <tr>
                <td width="150" valign="top">&nbsp;<strong>From Username</strong></td>
                <td>&nbsp;<?php echo $frm_user_username; ?></td>
              </tr>
              <tr>
                <td valign="top">&nbsp;<strong>Current Credits</strong></td>
                <td>&nbsp;<?php echo $frm_user_credits; ?></td>
              </tr>
              <tr>
                <td width="150" valign="top">&nbsp;<strong>To Username</strong></td>
                <td>&nbsp;<?php echo $to_user_username; ?></td>
              </tr>
              <tr>
                <td valign="top">&nbsp;<strong>Current Credits</strong></td>
                <td>&nbsp;<?php echo $to_user_credits; ?></td>
              </tr>              
               <tr>
                <td valign="top">&nbsp;<strong>Credits to Transfer</strong></td>
                <td>&nbsp;<input name="amount" id="amount" type="text" size="15" maxlength="10" /></td> 
<!--
               <td><input name="withdraw_amt" id="withdraw_amt" type="text" size="15" maxlength="10" /></td>
-->               
              </tr>
              </tr>
               <tr>
                <td valign="top">&nbsp;<strong>Date</strong></td>
                <td><input id="dateSent" name="dateSent" type="text" size="10" /></td>
<!--                
                <td>&nbsp;<input id="dateSent" name="dateSent" type="text" size="25"><a href="javascript:NewCal('dateSent','ddmmmyyyy')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></td>
-->                
              </tr>
              <!--
              <tr>
                <td valign="top">&nbsp;<strong>Description</strong></td>
                <td>&nbsp;<textarea name="description" cols="40" rows="3"></textarea></td>
              </tr>
              -->
               <tr>
                <td colspan="2" >&nbsp;</td>
              </tr>
               <tr>
                <td colspan="2" align="center" >
                <?php 
                if (isset($_POST['frmusername']))
                {
                ?>	
                 <input name="" type="submit" value="Transfer" />
                <?php
                }
                ?>
                
                </td>
              </tr>
            </table>
            </form>
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

