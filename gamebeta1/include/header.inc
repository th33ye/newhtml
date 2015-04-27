<?php
session_start();
include('ipblocked.php');
//include('secQCheck.php');
?>

<!DOCTYPE>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>SabongNow</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" href="css/global.css">
		<link rel="stylesheet" type="text/css" href="css/mystyle.css" />

		<script type="text/javascript" src="browser.js"></script>		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
				
		<!-- slider -->
<script type="text/javascript">
		function checkIE()
		{
			if (isIEBrowser() != -1)
			{
				window.location = 'http://www.sabongnow.com/browser.html'
			}
		}


			$(document).ready(function(){
				//hide message_body after the first one
				$(".message_list .message_body:gt(0)").hide();
			
				//hide message li after the 5th
				$(".message_list li:gt(8)").hide();
			
				//toggle message_body
				$(".message_head").click(function(){
					$(this).next(".message_body").slideToggle(500)
					return false;
				});
	
				//collapse all messages
				$(".collpase_all_message").click(function(){
					$(".message_body").slideUp(500)
					return false;
				});
	
				//show all messages
				$(".show_all_message").click(function(){
					$(this).hide()
					$(".show_recent_only").show()
					$(".message_list li:gt(4)").slideDown()
					return false;
				});
	
				//show recent messages only
				$(".show_recent_only").click(function(){
					$(this).hide()
					$(".show_all_message").show()
					$(".message_list li:gt(4)").slideUp()
					return false;
				});
			});
		</script>
		<!-- end of slider -->		
	</head>

	<body onLoad="checkIE();">
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
			        		<h2>ANNOUNCEMENTS!!!</h2>
							<ol class="message_list">
                                <li>
									<p class="message_head"><cite>PROMO MECHANICS</cite></p>
									<div class="message_body">
										<p><a href="http://goo.gl/sTLFfv" target="_blank" >CLICK FOR FREE SBPs</a></p>
									</div>
								</li>                           
								<li>
									<p class="message_head"><cite>Derby Program</cite></p>
									<div class="message_body">
										<p><a href="http://goo.gl/QkEosW" target="_blank" >CLICK TO GET DERBY PROGRAM</a></p>
									</div>
								</li>
								<li>
									<p class="message_head"><cite>Biñan Cockpit Arena</cite></p>
									<div class="message_body">
										<div id='txt'><p>Mon - 1-Cock Fastest Kill</p></div>
                                        <div id='txt'><p>Tue & Sat - 2-Cock Ulutan</p></div>
		   <div id='txt'><p>Wed - HackFight Upahan</p></div>
                                        <div id='txt'><p>Sun - Hackfight Upahan</p></div>
									</div>
                               	</li>
								<li>
									<p class="message_head"><cite>Pasig Square Garden</cite></p>
									<div class="message_body">
                                                                                                                                                                  <div id='txt'><p>Mon & Thurs - Derby Day</p></div>
								</li>
								<li>
									<p class="message_head"><cite>Sta. Monica Cockpit Arena</cite></p>
									<div class="message_body">
                                        <div id='txt'><p>Sat - Derby</p></div>
								</li>
							</ol>			        	
			        	</div>
			        </div>		
                    <!-- start ads -->
                         <div id="ads">
					<!-- <img src="img/erektus.jpg" alt="" width="200" height="300"/> -->
				</div>
                   <!-- end ads -->	    		
		    		<!-- Announcement (end) -->
		    	</div>
		    	<!-- Sidebar Container (end) -->
		    	
		    	<!-- Content (begin) -->
		    	<div class="content">
		    		<!--  Container (begin) -->
		    		<div id="container">
		    			<div id="example">
							<div id="slides">
                                
                                <!--<img src="img/binan-monday.gif" width="660" height="250" alt="Example Frame" id="frame"> -->
                                <!--<img src="img/bca-tue.gif" width="660" height="250" alt="Example Frame" id="frame"> -->
<!--                                <img src="img/nov02-smc.gif" width="660" height="250" alt="Example Frame" id="frame"> -->
                                <!--<img src="img/tuesdays1-dobol.gif" width="660" height="250" alt="Example Frame" id="frame">-->
                                <!--<img src="img/mondays-dobol.gif" width="660" height="250" alt="Example Frame" id="frame">-->
	 			                <img src="img/sundays1-dobol.gif" width="660" height="250" alt="Example Frame" id="frame">
                                
                                <!-- 
								<div class="slides_container">
									<img src="img/derby-rmc-20121128.jpg" width="739" height="341" alt="Example Frame" id="frame">
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
<!-- 					
						<p>TBA</p>
					</div>
		    	</div>
		    </div>

		    <footer>
				www.SabongNow.com&nbsp;<a href=""><img src="img/fb.png" width="25" height="25" ></a>
				&nbsp;<a href=""><img src="img/TwitterIcon.png" width="25" height="25" ></a>&nbsp;<a href=""><img src="img/download.png" width="25" height="25" ></a>
		    </footer>
		    <p>&nbsp;</p>		    
		</div>
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
-->
