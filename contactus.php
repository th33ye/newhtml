<?php
session_start();
//include('ipblocked.php');
//include('secQCheck.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>sabongnow</title>
<!-- <link href="CFA.css" rel="stylesheet" type="text/css" /> -->
<link href="css/sabong.css" rel="stylesheet" type="text/css" />
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
    <div id="contact">
        <div id="contact_text">
            <h2>SUPPORT</h2>
            <p>
                For all your inquiry and request, you may contact our <strong>Beautiful</strong> <b>Customer Service Representatives (CSRs)</b> thru any of the  following: 
            </p>
            <p>
          <table>
                    <tr>
                        <!--<td><b>Toll Free #:</b></td><td>1-888-910-7555</td>-->
                    </tr>
                    <tr>
                        <td><b>E-mail:</b></td><td>csupport@sabongnow.com</td>
                    </tr>
                     </tr><tr>
                        <td><strong>YahooMessenger</strong></td>
                        <td>sabongnow@ymail.com</td>
                    </tr>
                    <tr>
                        <td><b>Skype:</b></td><td>www.sabongnow.com</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td><td>csupport1.sabongnow.com</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td><td>csupport2.sabongnow.com</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td><td>www.sabongnow1.com</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td><td>csupport1.sabongnow1.com</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>csupport2.sabongnow1.com</td>
                    </tr>
</table>
            </p>
          <p><a href="/load_play.php">CLICK HERE TO LOAD & PLAY</a></p>
        </div>
        
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

<div id="footer">
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
</div>
<script type="text/javascript">
<!--
swfobject.registerObject("FlashID");
//-->
</script>
</body>
</html>
