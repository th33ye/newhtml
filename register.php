<?php
session_start();
include('ipblocked.php');
include('class.php');
if (isset($_SESSION['user_id'])) 
{
	header("location:index.php");
}
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

<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="browser.js"></script>
<!-- <script src="js/jquery-1.5.2.js" type="text/javascript" charset="utf-8"></script> -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<script type="text/javascript">
<!--

function ValidateNames(str){
	arr="^&*()-=+{}[]:';',./<>?|\\ ";
     for(var x=0; x<str.length; x++){	
	     for(var i=0; i<arr.length; i++){
	        if(str.charAt(x)==(arr.charAt(i))){
			  return true;
			  break;	
	        }  
	     }
     }
}  

function ValidateInputs(){

	if(document.myForm.user_email.value=="")
	{
	    alert("Email add is a required field ! ");
		document.myForm.user_email.focus();
	  	return false;
	}
	
	if(document.myForm.user_username.value=="")
	{
		alert("Username is a required field ! ");
		document.myForm.user_username.focus();
	   	return false;
	}
	
	  if(ValidateNames(document.myForm.user_username.value)==true){
	    alert("Invalid Username! ");
		document.myForm.user_username.focus();
	     return false;
	 }
	  if(document.myForm.user_username.value.length > 15){
	    alert("Username character length must not be more than 15! ");
		document.myForm.user_username.focus();
	   return false;
	 }
	 
	if(document.myForm.password.value==""){
		alert("Password is a required field ! ");
		document.myForm.password.focus();
	   	return false;
	}
	if(document.myForm.password.value.length < 6 || document.myForm.password.value.length >15){
	    alert("Minimum password length must be at least 6 and not more than 15 characters ! ");
		document.myForm.password.focus();
		return false;
	}
	
	if(document.myForm.password.value != document.myForm.repassword.value){
		alert("Password and Re-enter password does not match ! ");
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
                <li><a href="play.php">How to Load & Play</a></li>
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
                <div id="register-area">
                    <form name="myForm" method="post" action="register_process.php" onSubmit="return ValidateInputs()">
                        <table width="650" border="0" cellpadding="0" cellspacing="5" class="registercontent" >
                            <tr>
                                <td colspan="2">
                                    <h2>Registration</h2>
                                    <p>By becoming a registered member you are privilaged to view live cockfights from the Philippines.</p>								
                                    <p>Not only that, you will be able to play and bet against cockers from around the world.</p>
                                    <p></p>
                                    <h4><strong>Register Now! It's FREE!!!</strong></h4>
                                    <p>Important: Please use IE or Firefox to register.</p>                                  
                                </td>
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
                                <td><input name="user_email" type="text" class="Textbox" maxlength="50"/></td>
                            </tr>
                            <tr>
                                <td align="right">Username &nbsp;&nbsp;</td>
                                <td><input name="user_username" type="text" class="Textbox" maxlength="15"/></td>
                            </tr>
                            <tr>
                                <td align="right">Password &nbsp;&nbsp;</td>
                                <td><input name="password" type="password" class="Textbox" maxlength="15"/></td>
                            </tr>
                            <tr>
                                <td align="right">Re-enter Password &nbsp;&nbsp;</td>
                                <td><input name="repassword" type="password" class="Textbox" maxlength="15"/></td>
                            </tr>
                            <tr>
                                <td align="right">Country &nbsp;&nbsp;</td>
                                <td><input name="country" type="hidden" value="<?php echo $countryFull; ?>" maxlength="100"/><?php echo $countryFull; ?></td>
                            </tr>
                            <tr>
                                <td align="right">How did you find us? &nbsp;&nbsp;</td>
                                <td><select name="affiliate">
                                    <option value="2"> Sabong.Net </option>
                                    <option value="3"> Game Farm </option>
                                    <option value="4"> Friends </option>
                                    <option value="5"> Bentahan.com.ph </option>
                                    <option value="6"> Others </option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">Type Number &nbsp;&nbsp;</td>
                                <td><input value="<?php 
                                    if (isset($pass))
										echo $pass; 
									?>" name="pass"  size="5" maxlength="5" type="text" class="Textbox" /> (place 5-digit number displayed below)
                                </td>
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
                                <td><br /><input type="submit" value="Register" name="submit" /></td>
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

    <!--Footer Start -->
    <div id="footer">
        <div id="ads">
            <div id="ads_text">SPONSORED BY</div>
            <div id="ads_mc">
                <object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="1000" height="100">
                    <param name="movie" value="images/movie clip/adsmc.swf" />
                    <param name="quality" value="high" />
                    <param name="wmode" value="opaque" />
                    <param name="swfversion" value="6.0.65.0" />
                    <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->
                    <param name="expressinstall" value="Scripts/expressInstall.swf" />
                    <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
                    <!--[if !IE]>-->
                    <object type="application/x-shockwave-flash" data="images/movie clip/adsmc.swf" width="1000" height="100">
                        <!--<![endif]-->
                        <param name="quality" value="high" />
                        <param name="wmode" value="opaque" />
                        <param name="swfversion" value="6.0.65.0" />
                        <param name="expressinstall" value="Scripts/expressInstall.swf" />
                        <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
                        <div>
                            <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
                            <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>
                        </div>
                        <!--[if !IE]>-->
                    </object>
                    <!--<![endif]-->
                </object>
            </div>
 
            <div id="footer2_wrap">
                <div id="footer_terms"><a href="term.html" STYLE="color: #FFF; TEXT-DECORATION: none">Terms and Conditions</a></div>
                <div id="footer_text">All Rights Reserved © 2010 - 2011 by www.sabongnow.com</div>
                <div id="footer_hit"></div>
            </div>
        </div>
    </div> 
    <!-- Footer Bar End -->        
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

<script>
	$(function() {
		$( "#accordion" ).accordion({fillSpace: true});
	});
</script>
