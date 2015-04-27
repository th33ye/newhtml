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
        <div id="how_to_play">
            <div id="text_howtoplay" style="text-align: center;">
                <table border="0" align="center">
                <tr>
                    <td colspan="2">
                        <h3>FINAL RESULT for<br />
                        PUERTO PRINCESA 2012 PROMO TOUR (03/31/2012)</h3>
                    </td>
                </tr>
                <tr>
                    <td><b>RANK</b></td>
                    <td><b>USERNAME</b></td>
                </tr>
                <tr>
                    <td><b>1</b></td>
                    <td><b>MONSKY - WINNER</b></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>LAURENCE1972</td>
                </tr>                
                <tr>
                    <td>3</td>
                    <td>MRMARIA</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>JAMBO</td>
                </tr>       
                <tr>
					<td>5</td>
					<td>WINNER</td>
                </tr>        
                <tr>
                    <td>6</td>
                    <td>BOBOYCALIBUGAR</td>
                </tr>            
                <tr>
                    <td>7</td>
                    <td>GARY</td>
                </tr>       
                <tr>
                    <td>8</td>
                    <td>VANREY320</td>
                </tr>       
                <tr>
                    <td>9</td>
                    <td>RENAR671</td>
                </tr>           
                <tr>
                    <td>10</td>
                    <td>KEVS</td>
                </tr>         
                <tr>
                    <td>11</td>
                    <td>FIREBIRD</td>
                </tr>         
                <tr>
                    <td>12</td>
                    <td>CHANTELLITA</td>
                </tr>           
                <tr>
                    <td>13</td>
                    <td>RAGDESOR</td>
                </tr>           
                <tr>
                    <td>14</td>
                    <td>NEILSKIE</td>
                </tr>               
                <tr>
					<td>15</td>
					<td>BLUEROSE</td>
                </tr>        
                <tr>
                    <td>16</td>
                    <td>RICTOY</td>
                </tr>                 
                <tr>
                    <td>17</td>
                    <td>RSUPREMO</td>
                </tr>        
                <tr>
                    <td>18</td>
                    <td>ARMAE</td>
                </tr>              
                <tr>
					<td>19</td>
					<td>ELMAN</td>
                </tr>              
                <tr>
                    <td>20</td>
                    <td>ARNELGARCEO</td>
                </tr>                                                                                                                        
                </table>
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
    <img src="nimages/palawanTrip.gif" alt="Win a TRIP TO PALAWAN" />
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
