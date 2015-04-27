<?php
session_start();
if (isset($_SESSION['admin_username']) && $_SESSION['admin_username'] <> "" ) 
{
	//echo $_POST['username'];
	$user_id = 0;
	$user_credits = 0;
	$user_username = "";
	$user_credits = "";
	if (isset($_POST['username']))
	{
		include 'dbconn.php';
		$query = "select * from users where user_username = '". $_POST['username'] ."' and user_status =1";		
		if ($result = mysqli_query($link, $query)) 
		{
			//echo mysqli_num_rows($result); 
			// Fetch the results of the query *
			if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) )
			{ 
				$user_id = $row['user_id'];
				$user_username = $row['user_username'];
				$user_credits = $row['user_credits'];
				if (is_null($user_credits) or $user_credits == "")
				{
					$user_credits = 0;
				}
				
				//$user_credits = $row['user_credits'];
				//mysql_close($link2); 
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
<table  class="body-wrapper" width="1000" border="0" cellspacing="0" cellpadding="0">
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
    		<strong>Use this to load SBP via Western Union</strong>
            <br />
            <?php
            if (isset($_SESSION['messageLoad']))
            {
                echo $_SESSION['messageLoad']; 
            }
            ?>
            <br />
            <form  method="post" name="searchForm" target="_self">
            <strong>User Name:</strong>&nbsp; <input name="username" type="text" size="15" maxlength="15" /> &nbsp; &nbsp; &nbsp; <input name="Search" type="submit" />
            </form>
            <br />
            <br />
            <form action="admin_mtcnLoad_process.php" method="post" name="mtcn" id="load_form">
            <?php
				if ($user_id > 0)
				{
			?>
            
            <input name="username" type="hidden" value="<?php echo $user_username ?>" />
            <input name="userid" type="hidden" value="<?php echo $user_id ?>" />
            <?php
				}
			?>
            <table width="550" border="1" cellpadding="0" cellspacing="0">
               <tr>
                  <td width="100" valign="top">&nbsp;<strong>Username</strong></td>
                  <td>&nbsp;<label><?php echo $user_username; ?></label></td>
              </tr>
              <tr>
                  <td valign="top">&nbsp;<strong>Current SBP</strong></td>
                  <td>&nbsp;<label><?php echo $user_credits; ?></label></td>
              </tr>
              <tr>
                  <td valign="top" rowspan="4">&nbsp;<strong>Credit From</strong></td>
              </tr>
              <tr>
                  <td><label><input type="radio" name="credittype" value="bank" id="bank" />Bank Transfer</td></label>
              </tr>
               <tr>
                  <td><label><input type="radio" name="credittype" value="wu" id="wu" checked="checked" />Western Union [MTCN]</label>
                     <input name="mtcn" id="mtcn" type="text" size="15" maxlength="30" />
<!--                     <div id="err"></div> -->
                  </td>
              </tr>
              <tr>
                  <td><label><input type="radio" name="credittype" value="virtual" id="virtual" />Virtual Load</td></label>
              </tr>
              <tr>
                <td valign="top">&nbsp;<strong>Amount</strong></td>
                <td>
                  <input name="senderAmount" id="senderAmount" type="text" size="10" maxlength="15" />
                  Bonus Credit
<!--                  <select id="bonusPoint" name="bonusPoint" disabled="disabled">
                     <option value='0'>0</option>
                     <option value='10'>10</option>
                     <option value='15'>15</option>
                     <option value='20'>20</option>
                     <option value='25'>25</option>
                     <option value='30'>30</option>
                     <option value='35'>35</option>
                     <option value='40'>40</option>
                     <option value='45'>45</option>
                     <option value='50'>50</option>
                     <option value='55'>55</option>
                     <option value='60'>60</option>
                     <option value='65'>65</option>
                     <option value='70'>70</option>
                     <option value='75'>75</option>
                     <option value='80'>80</option>
                     <option value='85'>85</option>
                     <option value='90'>90</option>
                     <option value='95'>95</option>
					 <option value='100'>100</option>
					 <option value='105'>105</option>
					 <option value='110'>110</option>
					 <option value='115'>115</option>
					 <option value='120'>120</option>
					 <option value='125'>125</option>
					 <option value='130'>130</option>
					 <option value='135'>135</option>
					 <option value='140'>140</option>
					 <option value='145'>145</option>
					 <option value='150'>150</option>
                  </select> -->
                  <input name="bonusPoint" id="bonusPoint" type="text" size="5" maxlength="5" />
                </td>
              </tr>
               <tr>
                <td valign="top">&nbsp;<strong>Date Sent</strong></td>
                <td><input id="dateSent" name="dateSent" type="text" size="10">
                </td>
<!--
<a href="javascript:NewCal('dateSent','ddMMyyyy')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></td>
-->
              </tr>
               <tr>
                <td valign="top">&nbsp;<strong>Sender Name</strong></td>
                <td><input name="senderName" id="senderName" type="text" size="30" maxlength="100" /></td>
              </tr>
               <tr>
                <td valign="top">&nbsp;<strong>Address</strong></td>
                <td><textarea name="senderAddress" cols="40" rows="3"></textarea></td>
              </tr>
               <tr>
                <td colspan="2" >&nbsp;</td>
              </tr>
               <tr>
                <td colspan="2" align="center" >
                <?php 
                if (isset($_POST['username']))
                {
                ?>	
                 <input name="" type="submit" value="Load" />
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
   <script type="text/javascript" src="http://www.google.com/jsapi"></script>
   <script type="text/javascript" src="js/jquery-1.5.2.js"></script>
   <script type="text/javascript" src="js/jquery.validate.js"></script>
   <script type="text/javascript" src="js/jquery-ui-1.8.11.custom.min.js"></script>
   <script type="text/javascript">
      // date picker
      //$(function() {
      //   $('.date-pick').datepicker({clickInput:true})
      //});
      $(document).ready(function(){
         $("#dateSent").datepicker({ showOn: 'button', buttonText: "select", dateFormat: 'yy-mm-dd' });
      });

      // monitor amount key press
				$('#senderAmount').keyup(function() {
					var amtLoaded = $(this).val();
		  			//if ($(this).val() >= 100) {
//					if (amtLoaded >= 100) {
//						var xBonus = Math.floor(amtLoaded/100);
						//$('#bonusPoint').removeAttr('disabled');
						//$('#bonusPoint').val('8');
//						$('#bonusPoint').val(xBonus*8);
//					} else {
						//$('#bonusPoint').attr('disabled', true);
						//$('#bonusPoint').val('0');
						$('#bonusPoint').val(0);
//					}
		  		});

      // credit from
      $("input[name='credittype']").change(function(){
         if ($("input[name='credittype']:checked").val() == 'wu') {
            $("input#mtcn").val("");
            $("label#mtcn_label").show();
            $("#mtcn").show(); 
         }
         else if ($("input[name='credittype']:checked").val() == 'bank') {
            $("input#mtcn").val("BANK");
            $("label#mtcn_label").hide();
            $("#mtcn").hide(); 
         }
         else if ($("input[name='credittype']:checked").val() == 'virtual') {
            $("input#mtcn").val("VIRTUAL");
            $("label#mtcn_label").hide();
            $("#mtcn").hide(); 
         }
      });

      // form validator
      $("#load_form").validate({
         rules: {
            mtcn: {
               required: "#wu:checked"
            },
            senderAmount: {
               required: true,
               number: true
            },
            dateSent: {
               required: true,
               date: true
            },
            senderName: {
               required: true
            }
         },
         messages: {
            mtcn: "Required",
            dateSent: "Required",
            senderName: "Required"
         }
      });
   </script>    
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

