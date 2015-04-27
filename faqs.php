<?php
session_start();
//include('ipblocked.php');
//include('secQCheck.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sabong Now</title>
<link href="CFA.css" rel="stylesheet" type="text/css" />
</head>

<body class="body">
	<!--Site Wrapper -->
<div class="site-wrapper" align="center">
<!--Header -->
			<div class="header-wrapper"></div>
            <!--End Header -->
            
            <!--Navigation -->
  <table  class="Nav-wrapper" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="30" class="navStart"></td>
    <td width="88" align="center">
    <a class="BtnHome" href="index.php"></a></td>
    <td width="112" align="center">
    <a class="BtnAbout" href="about.php"></a></td>
    <td width="125" align="center">
    <a class="BtnHowTo" href="howtoplay.php"></a></td>
    <td width="95" align="center">
    <a class="BtnRegister" href="register.php"></a></td>
    <td width="92" align="center">
    <a class="BtnCashier" href="cashier.php"></a></td>
    <td width="102" align="center">
    <a class="BtnSupportActive" href="support.php"></a></td>
    <td width="189 align="center"">
    <a class="BtnAboutCF" href="aboutcockfighting.php"></a></td>
    <td width="131" align="center">
    <a class="BtnLicense" href="license.php"></a></td>
    <td width="36" class="navEnd"></td>
  </tr>
</table>
	<!--End of Navigation -->
        
    <!--Body Wrapper -->
<table  class="body-wrapper" width="1000"border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3" align="center" class="bodyTop">&nbsp;</td>
    </tr>
  <tr>
    <td width="160" align="right" valign="top" class="LeftPanel">
    
    	<?php 
	  		include 'leftnav.php'; 
	  	?>
    
    </td>
    <td width="650"  align="center" valign="top" class="content">
    
     <!--COntent -->		
    <div id="content">
    		<h2>FAQs</h2>
                                        <p><strong>Registration mechanics</strong></p>
                                        <p>
                                            <ol>Using Firefox, please log in to <strong>www.sabongnow.com</strong>  and go to the register tab and create an account using your email address.</ol>
                                            <ol> Activate your account by clicking on the link that you will receive on the email address you provided.</ol>	
                                            <ol>Log in now to your account with your username and password.  You will be asked to type in a security question that will help you in case you lose or forget your username and password.  Please take note that you will receive two(2) email confirmations containing your username and password and your security questions.</ol>
                                            <ol>Once logged in, you can now start navigating in <strong>www.sabongnow.com</strong>. </ol>
                                        </p>
                                        <p><strong>Loading your Account</strong></p>
                                        <p>&nbsp;&nbsp;&nbsp;Loading can be done in two(2) ways:
                                            <ol><strong>1.</strong>&nbsp;&nbsp;Bank Transfers</ol>
                                            <ol>
                                              <strong>1.1</strong>&nbsp;&nbsp;Email csupport@sabongnow.com for bank details</strong>
</ol>	

                                        	<br />
                                            <ol><strong>2.</strong>&nbsp;&nbsp;Western Union </ol>
                                            <ol><strong>2.1	</strong>&nbsp;&nbsp;Go to the nearest Western Union branch and do the the deposit in US$.</ol>
                                            <ol>
                                              <strong>2.2	</strong>&nbsp;&nbsp;Email the MTCN #, Sender name, Recepients name and amount to csupport@sabongnow.com
</ol>
                                            <ol><strong>2.3	</strong>&nbsp;&nbsp;Wait response or you can call the toll free number</ol>
                                        </p>              
                                        <p><strong>Withdrawal</strong></p>         
    									<p>
                                            <ol>
                                              <strong>Send email to csupport@sabongnow.com</strong>
                                            </ol>
                                       </p>          
                                         
<p><strong>NOTE:</strong></p>
										<p>Every winning will be charged with a 10% plazada.  
										</p>
    </div>
    <!--End of Main Content -->
    
    </td>
    <!--LogIn Panel -->
    
    <td width="185" align="left" valign="top">
    	<?php
			if (isset($_SESSION['errormessage']))
			{
				
				if (isset($_SESSION['user_username']) && $_SESSION['user_username'] <> "" ) 
				{
					include 'loginnav.php'; 
				}
				else
				{
					include 'loginform.php'; 
				}
			}
			else
			{
				if (isset($_SESSION['user_username']) && $_SESSION['user_username'] <> "" ) 
				{
					include 'loginnav.php'; 
				}
				else
				{
					include 'loginform.php'; 
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

