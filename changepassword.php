<?php
session_start();
include('ipblocked.php');
include('class.php');
if (isset($_SESSION['user_id'])) 
{
	

// generate image validator
$passGen = new passGen(5);



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sabong Now</title>
<!-- <link href="CFA.css" rel="stylesheet" type="text/css" /> -->
<link href="css/sabong.css" rel="stylesheet" type="text/css" />

<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="browser.js"></script>
<!-- <script src="js/jquery-1.5.2.js" type="text/javascript" charset="utf-8"></script> -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<script type="text/javascript">
<!--

function ValidateInputs(){

	
	if(document.myForm.cpassword.value==""){
		alert("Current Password is a required field ! ");
		document.myForm.cpassword.focus();
	   	return false;
	}
	if(document.myForm.cpassword.value.length < 6 || document.myForm.cpassword.value.length >15){
	    alert("Minimum password length must be at least 6 and not more than 15 characters ! ");
		document.myForm.cpassword.focus();
		return false;
	}
	
	if(document.myForm.password.value==""){
		alert("New Password is a required field ! ");
		document.myForm.password.focus();
	   	return false;
	}
	if(document.myForm.password.value.length < 6 || document.myForm.password.value.length >15){
	    alert("Minimum password length must be at least 6 and not more than 15 characters ! ");
		document.myForm.password.focus();
		return false;
	}
	
	if(document.myForm.password.value != document.myForm.repassword.value){
		alert("New Password and Re-enter password does not match ! ");
		document.myForm.repassword.focus();
	   	return false;
	}
		
	 if(document.myProfile.pass.value==""){
	    alert("Validation must not be empty ! ");
		document.myProfile.pass.focus();
	   return false;
	 }
	return true;
}
//-->
</script>
</head>

<body class="body">
    <!-- Header Start -->
    <div id="header_logo">
        <div id="logo"></div>
    </div>
    <!-- Header End -->

    <!-- Menu Bar Start -->
    <div id="nav_wrap">
        <div id="btn">
            <ul id="MenuBar1" class="MenuBarHorizontal">
                <li><a href="index.php">Home</a></li>
                <!-- <li><a href="play.php">How to Load & Play</a></li> -->
                <li><a href="license.php">Our License</a></li>
                <li><a href="contactus.php">Contact Us</a></li>
            </ul>
        </div>
    </div>
    <!-- Menu Bar End -->

    <div id="content_wrap">
        <div id="panel-container">
            <!-- First Panel Start -->
            <div id="panel-left">
                <div id="accordion">
                    <h3><a href="#" class="accordion-head">Binan Cockpit</a></h3>
                    <div>
                        <ul>
                            <li class="accordion-detail"></li>
                        </ul>
                    </div>
                    <h3><a href="#" class="accordion-head">Pasig Square Garden</a></h3>
                    <div>
                        <ul>
                            <li class="accordion-detail"></li>
                        </ul>
                    </div>
                    <h3><a href="#" class="accordion-head">Roligon Mega Cockpit</a></h3>
                    <div>
                        <ul>
                            <li class="accordion-detail"></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- First Panel End -->
            
            <!-- Second Panel Start -->
            <div id="panel-center">
                <div id="password-area">
                <form name="myForm" method="post" action="changepassword_process.php" onSubmit="return ValidateInputs()">
                    <input type="hidden" name="" />
                    <table width="650" border="0" cellpadding="0" cellspacing="5" class="registercontent" >
                        <tr>
                            <td colspan="2">
                                <h2>Change Password</h2>
                                <p>Please enter current password and new password</p>
                        </tr>
                        <?php
                        if (isset($_SESSION['registermessage']) && $_SESSION['registermessage'] <> "")
                        {
                            // DISPLAY ERROR MESSAGE
						?>
                        <tr>
                            <td colspan="2" align="center"><strong><?php echo $_SESSION['registermessage']; ?></strong></td>
						</tr>
						<tr>
                            <td colspan="2">&nbsp;</td>
						</tr>
						<?php
						}
						?>
                                      
                        <tr>
                            <td align="right">Email Address &nbsp;&nbsp;</td>
                            <td><?php echo $_SESSION['user_email']; ?></td>
                        </tr>
                        <tr>
                            <td align="right">Username &nbsp;&nbsp;</td>
                            <td><strong><?php echo $_SESSION['user_username']; ?></strong></td>
                        </tr>
                        <tr>
                            <td align="right">Current Password &nbsp;&nbsp;</td>
                            <td><input name="cpassword" type="password" class="Textbox" maxlength="15"/></td>
                        </tr>
                        <tr>
                            <td align="right">New Password &nbsp;&nbsp;</td>
                            <td><input name="password" type="password" class="Textbox" maxlength="15"/></td>
                        </tr>
                        <tr>
                            <td align="right">Re-enter Password &nbsp;&nbsp;</td>
                            <td><input name="repassword" type="password" class="Textbox" maxlength="15"/></td>
                        </tr>
                        <tr>
                            <td align="right">Type Number &nbsp;&nbsp;</td>
                            <td><input  value="<?php 
                                if (isset($pass))
									echo $pass; 
								?>" name="pass"  size="5" maxlength="5" type="text" class="Textbox" /> (place 5-digit number displayed below)</td>
                        </tr>
                        <tr>
                            <td align="right">&nbsp;</td>
                            <td height="25"><br />
                            <?php  $rv = $passGen->password(0, 1); ?>
                            <input type="hidden" value="<?php  echo $rv; ?>" name="rv">
                            <?php  echo $passGen->images('font', 'gif', 'f_', '30', '30'); ?></td>
                        </tr>
                        <tr>
                            <td align="center">&nbsp;</td>
                            <td><br /><input type="submit" value="Change Password" name="submit" /></td>
                        </tr>
                    </table> 
                </form>
                </div>
            </div>
            <!-- Second Panel End -->            

            <!-- Third Panel Start -->
            <div id="panel-right">
                <?php
                if (isset($_SESSION['errormessage'])) {
                    if (isset($_SESSION['user_username']) && $_SESSION['user_username'] <> "" ) {
                        include 'loginnav.php'; 
                    }
                    else {
                        include 'loginform.php'; 
                    }
                }
                else {
                    if (isset($_SESSION['user_username']) && $_SESSION['user_username'] <> "" ) {
                        include 'loginnav.php'; 
                    }
                    else {
                        include 'loginform.php'; 
                    } 
                }
                ?>
            </div>
            <!-- Third Panel End -->
        </div>
    </div>        
    
</div>
<!--End of Site Wrapper -->
</body>
</html>
<?php 
}
else
	{
		header("location:index.php"); 
	}
?>

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

<script>
	$(function() {
		$( "#accordion" ).accordion({fillSpace: true});
	});
</script>
