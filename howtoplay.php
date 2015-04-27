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
    <a class="BtnHowToActive" href="howtoplay.php"></a></td>
    <td width="95" align="center">
    <a class="BtnRegister" href="register.php"></a></td>
    <td width="92" align="center">
    <a class="BtnCashier" href="cashier.php"></a></td>
    <td width="102" align="center">
    <a class="BtnSupport" href="support.php"></a></td>
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
      <b>Download :</b><a href='playinginstruction.pdf' target='_blank'>Playing Procedure</a>
<!--   
    			<h2>HOW TO PLAY</h2>
                    <p ><strong>Step 1:</strong> Players should be registered first. <a href="register.php"><strong>REGISTER</strong></a> here. </p>
                    <p ><strong>Step 2:</strong> Login using your username and password. You will notice that every page in this website has LOGIN panel (Right side of each page). You may login at any page anytime. </p>
                    <p ><strong>Step 3:</strong> The next page should prompt you with this window (image below). This is our <strong>GAME CONSOLE </strong> where you can choose the cockpit you want to enter. You can check our schedules presented on each pages of this website. </p>
                    <p ><strong>Step 4:</strong> Upon choosing your desired arena/cockpit, you will now visit the actual <strong>GAME CONSOLE </strong> where you can watch and bet against players from around the world. See image below. Be sure to familiarize all functionalities before placing actual bets.</p>
                    <p align="center"><strong>GAME CONSOLE</strong> </p>
                    <p > <img  width="600" height="480" src="images/howtoplay.jpg" /></p>
            		<p></p>
                    <p align="center" ><u><strong>Game Mechanics</strong> </u></p>                    
                    <p><strong>1.</strong> Each player must have minimum credit of <strong>100sbp (Sabong Points)</strong> to be able to play and bet.</p>
                    <p ><strong>2.</strong> Every game/fight has a break of at least 30 seconds or up to 2 minutes in which the admin will <span class="style1">OPEN</span> the betting session and for the players to choose their desired gamecock, as shown in the screen “WALA” or “MERON”. Simple click the button to choose a gamecock. </p>                                       
                    <p ><strong>3.</strong> Choose which side you want (MERON or WALA) by using the radio button, then choose the bet amount by clicking on the dropdown arrow to show available amounts. Be sure to choose amount equal or lower than your available sbp. After choosing bet amount, place your bet by clicking <strong>"Place Bet"</strong> button. You may also change the bet amount or even change gamecock by simply clicking <strong>"Cancel Bet"</strong> button and start all over again. (Note: All bets entered after the admin closes the betting session will be final, no changes will be allowed) </p>
                    <p align="justify"><span class="style9"><strong>4. </strong></span>Admin will close betting session once the cock handlers take off the gaff cover of each gamecock. This indicates that the fight will start. Status shows <strong>"Betting is Close"</strong>. You can watch the fight freely. </p>
                    <p align="justify"><span class="style9"><strong><strong>5.</strong></strong></span> Once the <span class="style1">&quot;SENTENCIADOR or PIT JUDGE&quot;</span> declares the winner, Admin will then  announce  the winner in the <strong>"FIGHT Result"</strong> field. Winning amount base on <span class="style1">ODDS</span> will be added to your sabong points at 10% less. Please refer to Terms and Condition. </p>
                                      
                     <p><strong>Note: Place bet and Cancel bet button only works while Betting is open.</strong></p>
-->                     
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

