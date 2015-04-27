<?php
session_start();
include('ipblocked.php');
//include('secQCheck.php');

if (isset($_SESSION['user_username'])) 
	{	
		if ($_SESSION['user_username']== "") 
		{
			header("location:index.php"); 
		}
		
		if(isset($_POST['dateBet']))
		{
			$fight_date = $_POST['dateBet'];
		}
		else
		{
			$fight_date = "";
		}
		if(isset($_POST['dateBetTo']))
		{
			$fight_date2 = $_POST['dateBetTo'];
		}
		else
		{
		$fight_date2 = "";
		}
		//$fight_date = $_POST['dateBet'];
		//$fight_date2 = $_POST['dateBetTo'];
		function ShowResult($fight_date, $fight_date2)
		{
//			include 'dbconn_normal.php';
         include 'dbconn.php';
						
			$dateRaw = date_parse($fight_date);
			//var_dump($dateRaw);
			if (strlen($dateRaw['month']) == 1 )
				$dateNew = $dateRaw['year']  . "-0" . $dateRaw['month'] . "-". $dateRaw['day'];
			else
				$dateNew = $dateRaw['year']  . "-" . $dateRaw['month'] . "-". $dateRaw['day'];
			 
			 $dateBet = $dateNew;  
			 
			
			$dateRaw2 = date_parse($fight_date2);
			if (strlen($dateRaw2['month']) == 1 )
				$dateNew2 = $dateRaw2['year']  . "-0" . $dateRaw2['month'] . "-". $dateRaw2['day'];
			else
				$dateNew2 = $dateRaw2['year']  . "-" . $dateRaw2['month'] . "-". $dateRaw2['day'];
			 
			 $dateBet2 = $dateNew2;  
			 
			 if (($fight_date <> "") and ($fight_date2 <> ""))
			{
                $bhSQuery = "SELECT p.game_id AS game_id, 
                            g.gamenumber AS gamenumber, 
                            g.gamestatus AS gamestatus, 
                            g.gamestart AS gamestart, 
                            g.gameend AS gameend
                        FROM pointsaudit p
                        LEFT JOIN game g
                            ON p.game_id = g.game_id
                        WHERE user_id = '{$_SESSION['user_id']}' 
                            AND arena_id = '{$_POST['arena']}'
                            AND (DATE(transactiondate) BETWEEN '$dateBet' AND '$dateBet2')
                        GROUP BY game_id";
			}
			//echo "SQL " . $bhSQuery;
			$temp_gameid = 0;
			$game_counter = 0;
			$arena_name = "";
			$result = mysqli_query($link, $bhSQuery);

         if ($result)
         {
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
            {
                switch ($row['gamestatus']) {
                    case 'dw':
                        $gameres = 'Wala Wins';
                        break;
                    case 'dm':
                        $gameres = 'Meron Wins';
                        break;
                    case 'd':
                        $gameres = 'Draw';
                        break;
                    case 'c':
                        $gameres = 'Cancelled';
                        break;
                }
                    
               echo '<table width=100%>';
               echo '<tr bgcolor=\'#F8B4B4\'>';
               echo '<td>Fight # : <b>' . $row['gamenumber'] . '</b></td><td>Result : <b>' . 
                    $gameres . '</b></td><td>Game start : <b>' .
                    $row['gamestart'] . '</b></td><td>Game end : <b>' .
                    $row['gameend'] . '</b></td>';
               echo '</tr>';
               echo '</table>';
               $gameId = $row['game_id'];
                $bhdSQuery = "SELECT TRIM(p.description) AS action, 
                                p.transactedamount AS transamt, 
                                p.remainingbalance AS balance
                            FROM pointsaudit p
                            LEFT JOIN game g
                                ON p.game_id = g.game_id
                            WHERE user_id = '{$_SESSION['user_id']}' 
                                AND arena_id = '{$_POST['arena']}'
                                AND p.game_id = '$gameId'
                                AND (DATE(transactiondate) BETWEEN '$dateBet' AND '$dateBet2')";
               
               $dres = mysqli_query($link, $bhdSQuery);
               
               echo '<table border=0 width=100%>';
               echo '<tr bgcolor=\'#E7E2E2\'>';
               echo '<td width=\'50%\'>Action</td><td width=\'12%\'>Odds (W-M)</td><td width=\'19%\'>Transacted Credit</td><td width=\'19%\'>Credit Balance</td>';
               echo '</tr>';
               while ($drow = mysqli_fetch_array($dres, MYSQLI_ASSOC))
               {
                   $action = $drow['action'];
                   if (strstr($action,"laced") !== FALSE) {
                       $oddId = (int)substr($action, -1);
                       $oSQuery = "SELECT bet_oddw, bet_oddm FROM betoddslist WHERE bet_odd_id = '$oddId'";
                       $ores = mysqli_query($link, $oSQuery);
                       $orow = mysqli_fetch_array($ores, MYSQLI_ASSOC);
                       $odds = $orow['bet_oddw'] . ' - ' . $orow['bet_oddm'];
                   } else {
                       $odds = '&nbsp;';
                   }
                   $transamt = $drow['transamt'];
                   $balance = $drow['balance'];
                   echo '<tr>';
                   echo '<td>'.$action.'</td><td align=\'center\'>'.$odds.'</td><td>'.$transamt.'</td><td>'.$balance.'</td>';
                   echo '</tr>';
               }
               echo '</table>';

				} 
				//displayFooter();
				mysqli_close($link);
			}
			else
			{
				echo "	<p>No result found. Please try again.</p>";
			}
			
		}
			
	}
	else
	{
		header("location:index.php"); 
	}
		

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>sabongnow</title>
<!-- <link href="CFA.css" rel="stylesheet" type="text/css" /> -->
<link href="css/sabong.css" rel="stylesheet" type="text/css" />

<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="browser.js"></script>
<!-- <script src="js/jquery-1.5.2.js" type="text/javascript" charset="utf-8"></script> -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js">

//Date Time Picker script- by TengYong Ng of http://www.rainforestnet.com
//Script featured on JavaScript Kit (http://www.javascriptkit.com)
//For this script, visit http://www.javascriptkit.com

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
                <h2>Bet History</h2>
                <p><strong>This report only shows fights where you placed bet.</strong></p>
                <p>
                    <form name="form1" method="post"  target="_self">
                        <strong>FROM :</strong> 
                        <input id="dateBet" name="dateBet" type="text" size="10"  readonly="readonly" value="<?php echo $fight_date ?>"/>&nbsp;&nbsp;
                        <a href="javascript:NewCal('dateBet','ddmmmyyyy')">
                            <img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date">
                        </a>&nbsp;&nbsp;&nbsp;
                        <br />
                        <strong>TO :</strong> 
                        <input readonly="readonly" id="dateBetTo" name="dateBetTo" type="text" size="10" value="<?php echo $fight_date2 ?>"/>&nbsp;&nbsp;
                        <a href="javascript:NewCal('dateBetTo','ddmmmyyyy')">
                            <img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date">
                        </a>&nbsp;&nbsp;&nbsp;
                        <br />
                        <strong>ARENA :</strong>
                        <select id="arena" name="arena">
                            <option value="1" <?php echo ($_POST['arena'] == '1' ? 'selected="selected"' : ''); ?>>Binan Cockpit Arena</option>
                            <option value="2" <?php echo ($_POST['arena'] == '2' ? 'selected="selected"' : '');?>>Roligon Mega Cockpit</option>
                            <option value="3" <?php echo ($_POST['arena'] == '3' ? 'selected="selected"' : '');?>>Pasig Square Garden</option>
                        </select>
                        <br />
                        <input name="Submit" type="submit" value="Generate Report" />
                    </form>
                </p>
                <p>
					<?php 
					if($fight_date <> "")
					{	
						ShowResult($fight_date, $fight_date2); 
					}
					?>
                </p>
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
