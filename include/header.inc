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
							<li><a href="sbnew_grfaq.php">FAQ</a></li>
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
					
					<!-- Sidebar receiver (start) -->
					<div class="sidebar">
						<div class="sidebar-box">
							<img src="img/loading.gif" width="200" height="450" />
						</div>
					</div>
					<!-- Sidebar receiver (end) -->
					
					<!-- Announcement (begin) -->
			        <div class="sidebar">
			        	<div class="sidebar-box">
                            <!--<h2>ANNOUNCEMENTS!!!</h2>-->
							
							   <li>
					<p class="message_head"><cite>STA. MONICA DERBY</cite></p>
					<div class="message_body">
					<div id='txt'><p><a href="/img/tarp/april25-boy-nita-smc.jpg" target="_blank" >Apr 25 Sat Boy Nita 4-Cock Derby sa SMC</a></p></div>
					<div id='txt'><p>Apr 30 Thu Hari ng Rueda Pre-Finals</a></p></div>
									</div>
                               	</li>
						</div>
			        </div>		
                  		
		    		<!-- Announcement (end) -->					
					
					
		    		
		    		<!-- Announcement (begin) -->
			        <div class="sidebar">
			        	<div class="sidebar-box">
                            <!--<img src="img/xmas-promo-2014-a.gif" width="200px" height="330" />
                            <img src="img/xmas-promo-2014-b.gif" width="200px" height="330" />-->
			        		<!--<h2>ANNOUNCEMENTS!!!</h2>-->
							<!--<ol class="message_list">-->
                                <!--<li>
									<p class="message_head"><cite>PROMO MECHANICS</cite></p>
									<div class="message_body">
										<p><a href="http://goo.gl/sTLFfv" target="_blank" >CLICK FOR FREE SBPs</a></p>
									</div>
								</li>-->                           
								<!--<li>
									<p class="message_head"><cite>Derby Program</cite></p>
									<div class="message_body">
										<p><a href="http://goo.gl/qaLjDz" target="_blank" >CLICK TO GET DERBY PROGRAM</a></p>
									</div>
								</li>-->
								<!--<li>
									<p class="message_head"><cite>Biñan Cockpit Arena</cite></p>
									<div class="message_body">
										<div id='txt'><p>Mon - 1-Cock FK or Hackfight</p></div>
                                        <div id='txt'><p>Tue - 2-Cock Ulutan</p></div>
										<div id='txt'><p>Wed - 2-Cock Ulutan</p></div>
                                        <div id='txt'><p>Sun - Hackfight Upahan</p></div>
									</div>
                               	</li>-->
								<!--<li>
									<p class="message_head"><cite>Pasig Square Garden</cite></p>
									<div class="message_body">
                                    <div id='txt'><p>Mon - Hackfight</p></div>
									<div id='txt'><p>Thurs - Derby Day</p></div>
									<div id='txt'><p>Sat - Derby Day</p></div>
								</li>-->
								<!--<li>
									<p class="message_head"><cite>Sta. Monica Cockpit Arena</cite></p>
									<div class="message_body">
									<div id='txt'><p>Mon - Hackfight</p></div>
									<div id='txt'><p>Tue - Hackfight</p></div>
									<div id='txt'><p>Wed - 2-Cock Ulutan</p></div>
                                    <div id='txt'><p>Sat - Derby Day</p></div>
								</li>-->
							<!--</ol>-->
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
								<img src="img/smc-reg-sun.gif" width="660" height="250" alt="STA MONICA COLISEUM" id="frame">
								<!--<img src="img/smc-reg-montue.gif" width="660" height="250" alt="STA MONICA COLISEUM" id="frame">-->
								<!--<img src="img/smc-reg-wed.gif" width="660" height="250" alt="STA MONICA COLISEUM" id="frame">-->
								<!--<img src="img/spc-saturdays.gif" width="660" height="250" alt="SAN PEDRO COLISEUM" id="frame">-->
								<!--<img src="img/munti-apr16.gif" width="660" height="250" alt="MUNTINLUPA COLISEUM" id="frame">-->
								<!--<img src="img/nmca-04102015.gif" width="660" height="250" alt="NEW MABUHAY COCKPIT ARENA" id="frame">-->
															</div>
							<!-- <img src="img/example-frame2.png" width="739" height="341" alt="Example Frame" id="frame"> -->
						</div>
		    		</div>
		    		<!-- Container (end) -->
					
					<!-- Container2 (begin) -->
					<div id="container_2">
						<div id="example_2">
							<!--<img src="img/smc-derby-apr25.gif" width="660" height="250" alt="STA MONICA COCKPIT" id="frame">-->
							<!--<img src="img/spc-apr17.gif" width="660" height="250" alt="SAN PEDRO COLISEUM" id="frame">-->
							<!--<img src="img/nmca-03312015.gif" width="660" height="250" alt="NEW MABUHYAY COCKPIT ARENA" id="frame">-->
							<!--<img src="img/munti-apr13.gif" width="660" height="250" alt="MUNTINLUPA COLISEUM" id="frame">-->
							<!--<img src="img/smc-derby-apr18.gif" width="660" height="250" alt="STA MONICA COCKPIT" id="frame">-->
							<!--<img src="img/mabuhay-apr07.gif" width="660" height="250" alt="NEW MABUHAY COCKPIT" id="frame">-->
							<img src="img/smc-reg-montue.gif" width="660" height="250" alt="STA MONICA COLISEUM" id="frame">
						</div>
					</div>
		    		<!-- Container2 (end) -->
					
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
