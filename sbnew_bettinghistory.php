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
		
		<script language="javascript" type="text/javascript" src="datetimepicker.js"></script>
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
			                <h2>Bet History</h2>
			                <h5>This report only shows fights where you placed bet.</h5>
							<form name="form1" method="post"  target="_self">
			                	<table>
			                		<tr>
			                			<td>FROM :</td>
			                			<td><input id="dateBet" name="dateBet" type="text" size="15"  value="<?php echo $fight_date ?>"/>&nbsp;&nbsp;
			                        		<a href="javascript:NewCal('dateBet','ddmmmyyyy')">
			                            	<img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date">
			                        		</a>
			                        	</td>
			                		</tr>
			                		<tr>
			                			<td>TO :</td>
			                			<td><input id="dateBetTo" name="dateBetTo" type="text" size="15" value="<?php echo $fight_date2 ?>"/>&nbsp;&nbsp;
			                        		<a href="javascript:NewCal('dateBetTo','ddmmmyyyy')">
			                            	<img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date">
			                        		</a>
			                			</td>
			                		</tr>
			                		<tr>
			                			<td>ARENA :</td>
			                			<td><select id="arena" name="arena">
			                            		<option value="1" <?php echo ($_POST['arena'] == '1' ? 'selected="selected"' : ''); ?>>Binan Cockpit Arena</option>
			                            		<option value="2" <?php echo ($_POST['arena'] == '2' ? 'selected="selected"' : '');?>>Sta Monica Cockpit</option>
			                            		<option value="3" <?php echo ($_POST['arena'] == '3' ? 'selected="selected"' : '');?>>Pasig Square Garden</option>
			                        		</select>
			                			</td>
			                		</tr>
			                		<tr>
			                			<td>&nbsp;</td>
			                			<td><input name="Submit" type="submit" value="Generate Report" /></td>
			                		</tr>
			                	</table>
			                </form>
			                <p>
							<?php 
							if($fight_date <> "") {
								ShowResult($fight_date, $fight_date2);
							}
							?>
			                </p>						
			                
			                	<!-- 
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
			                     -->
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
