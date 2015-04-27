<?php
session_start();
include('ipblocked.php');
//include('secQCheck.php');
include('class.php');
if (isset($_SESSION['user_id']))
{
	header("location:index.php");
}	
// generate image validator
$passGen = new passGen(5);
?>

<!DOCTYPE>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>SabongNow</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" href="css/global.css">
		<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
				
		<!-- slider -->
		<script type="text/javascript">
		<!--
		function ValidateNames(str) 
		{
			arr="^&*()-=+{}[]:';',./<>?|\\ ";
			for(var x=0; x<str.length; x++) {
				for(var i=0; i<arr.length; i++) {
					if(str.charAt(x)==(arr.charAt(i))) {
						return true;
						break;	
			        }  
			     }
		     }
		}  

		function ValidateInputs()
		{
			if(document.myForm.user_email.value=="") {
				alert("Email add is a required field ! ");
				document.myForm.user_email.focus();
			  	return false;
			}
			if(document.myForm.user_username.value=="") {
				alert("Username is a required field ! ");
				document.myForm.user_username.focus();
			   	return false;
			}
			if(ValidateNames(document.myForm.user_username.value)==true) {
			    alert("Invalid Username! ");
				document.myForm.user_username.focus();
				return false;
			 }
			 if(document.myForm.user_username.value.length > 15) {
				 alert("Username character length must not be more than 15! ");
				 document.myForm.user_username.focus();
				 return false;
			 }
			 
			if(document.myForm.password.value=="") {
				alert("Password is a required field ! ");
				document.myForm.password.focus();
			   	return false;
			}
			if(document.myForm.password.value.length < 6 || document.myForm.password.value.length >15) {
				alert("Minimum password length must be at least 6 and not more than 15 characters ! ");
				document.myForm.password.focus();
				return false;
			}
			
			if(document.myForm.password.value != document.myForm.repassword.value) {
				alert("Password and Re-enter password does not match ! ");
				document.myForm.repassword.focus();
			   	return false;
			}
			if(document.myProfile.pass.value=="") {
			    alert("Validation must not be empty ! ");
				document.myProfile.pass.focus();
				return false;
			}
			return true;
		}
		//-->		
		</script>
		<!-- end of slider -->		
	</head>

	<body>
		<!-- Main Container (begin) -->
		<div id="main">
			<!--  <body class="body" onLoad="checkIE();"> -->
			
			<!-- Header (begin) -->
			<header>
				<div id="logo">
					<img src="nimages/SABONG_LOGO4.png" alt="Sabongnow" width="350" height="300"/>
				</div>
	  
				<!-- menus -->
			    <nav>
			    	<div id="menu_container">
			        	<ul class="sf-menu" id="nav">
			            	<li><a href="index.php">Home</a></li>
				            <!--  <li><a href="sbnew_play_and_load.php">How to Play and Load</a></li> -->
				            <li><a href="sbnew_license.php">Our License</a></li>
				            <li><a href="sbnew_contactus.php">Contact Us</a></li>
						</ul>
					</div>
				</nav>
				<!-- end of menus -->
		    </header>
		    <!-- Header (end) -->
		    
		    <!--  Site Content (begin) -->
		    <div id="site_content">
		    	<!-- Sidebar Container (begin)  -->
		    	<div id="sidebar_container">
		    		<!-- Sidebar login (begin) -->
		    		<div class="sidebar">
		    			<div class="signin-box">
			                <?php
			                if (isset($_SESSION['errormessage'])) {
			                    if (isset($_SESSION['user_username']) && $_SESSION['user_username'] <> "" ) {
			                        include('loginnav.php'); 
			                    }
			                    else {
			                        include('sb_login_form.php'); 
			                    }
			                }
			                else {
			                    if (isset($_SESSION['user_username']) && $_SESSION['user_username'] <> "" ) {
			                        include('loginnav.php'); 
			                    }
			                    else {
			                        include('sb_login_form.php'); 
			                    } 
			                }
			                ?>		    			
		    			</div>
		    		</div>
		    		<!-- Sidebar login (end) -->
		    		
		    		<!-- Announcement (begin) -->
			        <div class="sidebar">
			        	<div class="sidebar-box">
			        		<h2>Announcements</h2>
							<ol class="message_list">
								<li>
									<p class="message_head"><cite>Derby Schedule</cite></p>
									<div class="message_body">
										<div id='txt'><!-- <p></p> --></div>
									</div>
								</li>
								<li>
									<p class="message_head"><cite>Binan Cockpit Arena</cite></p>
									<div class="message_body"><!-- <p></p> --></div>
								</li>
								<li>
									<p class="message_head"><cite>Pasig Square Garden</cite></p>
									<div class="message_body"></div>
								</li>
								<li>
									<p class="message_head"><cite>Roligon Mega Cockpit</cite></p>
									<div class="message_body"></div>
								</li>
							</ol>			        	
			        	</div>
			        </div>		    		
		    		<!-- Announcement (end) -->
		    	</div>
		    	<!-- Sidebar Container (end) -->
		    	
		    	<!-- Content (begin) -->
		    	<div class="content">
		    		<!--  Container (begin) -->
		    		<div id="container">
		    			<div id="example">
							<div id="slides">
                 				<img src="img/sun-bca-psg-2014.gif" width="660" height="250" alt="Example Frame" id="frame">
								<!-- 
								<div class="slides_container">
									<a href="index.php?img=img1"><img src="img/s.gif" width="570" height="250" alt="Slide 1"></a>
									<a href="index.php?img=img2"><img src="img/2.jpg" width="570" height="250" alt="Slide 2"></a>
									<a href="index.php?img=img3"><img src="img/3.jpg" width="570" height="250" alt="Slide 3"></a>
									<a href="index.php?img=img4"><img src="img/4.jpg" width="570" height="250" alt="Slide 4"></a>
								</div>
								<a href="#" class="prev"><img src="img/arrow-prev.png" width="24" height="43" alt="Arrow Prev"></a>
								<a href="#" class="next"><img src="img/arrow-next.png" width="24" height="43" alt="Arrow Next"></a>
								 -->
							</div>
							<!-- <img src="img/example-frame2.png" width="739" height="341" alt="Example Frame" id="frame"> -->
						</div>
		    		</div>
		    		<!-- Container (end) -->
		    		
		    		<!-- Main msg (begin) -->
					<div id="main_msg">
						<div id="main-msg-box">
							<h2>Registration</h2>
							<p>By becoming a registered member you are privileged to view live cockfights from the Philippines.
								Not only that, you will be able to play and bet against cockers from around the world.</p>
							<br>
							<h5><italic>Register Now! It's FREE!!!</italic></h5>
							<p>Important: Please use Firefox or Google Chrome to register.</p>
							<form name="myForm" method="post" action="sbnew_register_process.php" onSubmit="return ValidateInputs()">
								<table width="650" border="0" cellpadding="0" cellspacing="5" class="registercontent" >
		                            <?php
									if (isset($_SESSION['registermessage']) && $_SESSION['registermessage'] <> "") {
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
		                                <td><input name="user_email" type="text" class="Textbox" maxlength="50" size="50" /></td>
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
		                            <!-- 
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
		                            -->
		                            <tr>
		                                <td align="right">Type Number &nbsp;&nbsp;</td>
		                                <td><input value="<?php 
		                                    if (isset($pass))
												echo $pass; 
											?>" name="pass"  size="8" maxlength="5" type="text" class="Textbox" /> (place 5-digit number displayed below)
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
						<!-- Main msg box (end) -->
					</div>
		    		<!-- Main msg (end) -->
		    	</div>
		    	<!-- Content (end) -->
		    </div>
		    <!-- Site Content (end) -->

		    <!-- Footer (begin) -->
		    <footer>
				www.SabongNow.com&nbsp;<a href=""><img src="img/fb.png" width="25" height="25" ></a>
				&nbsp;<a href=""><img src="img/TwitterIcon.png" width="25" height="25" ></a>&nbsp;<a href=""><img src="img/download.png" width="25" height="25" ></a>
		    </footer>
		    <p>&nbsp;</p>		    
		    <!-- Footer (end) -->
		</div>
		<!-- Main Container (end) -->
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
						
