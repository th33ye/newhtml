<?php
session_start();
include('ipblocked.php');
//include('secQCheck.php');

if (isset($_POST['username'])) {
//			include 'dbconn_normal.php';
    include 'dbconn.php';
    $query = "SELECT * FROM users WHERE user_username = '". $_POST['username'] ."'";
    if ($result = mysqli_query($link, $query)) {
       // Fetch the results of the query *
       if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
           $_SESSION['user_username'] =  $row['user_username'];
           $_SESSION['user_id'] =  $row['user_id'];
           $_SESSION['user_credits']    = $row["user_credits"];
           $_SESSION['user_email'] =  $row["user_email"];
           $_SESSION['user_wallet_id'] =  $row["user_wallet_id"];
           $_SESSION['user_wallet_acct_id'] =  $row["user_wallet_acct_id"];
           //$user_credits = $row['user_credits'];
           mysqli_close($link);
        }
        // Destroy the result set and free the memory used for it 
        mysqli_free_result($result);
    }
}

if (isset($_SESSION['user_username'])) {
    if ($_SESSION['user_username']== "") {
        header("location:index.php");
    }
    if(isset($_POST['dateBet'])) {
        $fight_date = $_POST['dateBet'];
    }
    else {
        $fight_date = "";
    }
    if(isset($_POST['dateBetTo'])) {
        $fight_date2 = $_POST['dateBetTo'];
    }
    else {
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
			 
		if (($fight_date <> "") and ($fight_date2 <> "")) {
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
        $temp_gameid = 0;
        $game_counter = 0;
        $arena_name = "";
        //echo "SQL " . $bhSQuery;
        $result = mysqli_query($link, $bhSQuery);
        //echo($sql);
        if ($result) {
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
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
                while ($drow = mysqli_fetch_array($dres, MYSQLI_ASSOC)) {
                    $action = $drow['action'];
                    if (strstr($action,"laced") !== FALSE) {
                        $oddId = (int)substr($action, -1);
                        $oSQuery = "SELECT bet_oddw, bet_oddm FROM betoddslist WHERE bet_odd_id = '$oddId'";
                        $ores = mysqli_query($link, $oSQuery);
                        $orow = mysqli_fetch_array($ores, MYSQLI_ASSOC);
                        $odds = $orow['bet_oddw'] . ' - ' . $orow['bet_oddm'];
                    } 
                    else {
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
        else {
            echo "	<p>No result found. Please try again.</p>";
        }
    }
}
else {
        header("location:index.php"); 
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sabong Now</title>
<link href="CFA.css" rel="stylesheet" type="text/css" />
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js">

//Date Time Picker script- by TengYong Ng of http://www.rainforestnet.com
//Script featured on JavaScript Kit (http://www.javascriptkit.com)
//For this script, visit http://www.javascriptkit.com

</script>
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
    <a class="BtnHome" href="#"></a></td>
    <td width="112" align="center">
    <a class="BtnAbout" href="about.php"></a></td>
    <td width="125" align="center">
    <a class="BtnHowTo" href="#"></a></td>
    <td width="95" align="center">
    <a class="BtnRegister" href="register.php"></a></td>
    <td width="92" align="center">
    <a class="BtnCashier" href="#"></a></td>
    <td width="102" align="center">
    <a class="BtnSupport" href="support.php"></a></td>
    <td width="189 align="center"">
    <a class="BtnAboutCF" href="#"></a></td>
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
        <h2>Bet History</h2>
        <p><strong>This report only shows fights where user has bet.</strong></p>
        <p>
            <form name="form1" method="post"  target="_self">
                <strong>USERNAME:</strong> 
                <input name="username" type="text" size="15" maxlength="15" /><br />
                <strong>FROM :</strong>
                <input id="dateBet" name="dateBet" type="text" size="10"  readonly="readonly" value="<?php echo $fight_date ?>"/>&nbsp;&nbsp;
                <a href="javascript:NewCal('dateBet','ddmmmyyyy')">
                    <img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date">
                </a>
                <br />
                <strong>TO :</strong> 
                <input readonly="readonly" id="dateBetTo" name="dateBetTo" type="text" size="10" value="<?php echo $fight_date2 ?>"/>&nbsp;&nbsp;
                <a href="javascript:NewCal('dateBetTo','ddmmmyyyy')">
                    <img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date">
                </a>
                <br />
                <strong>ARENA :</strong>
                <select id="arena" name="arena">
                    <option value="1" <?php echo ($_POST['arena'] == '1' ? 'selected="selected"' : ''); ?>>Binan Cockpit Arena</option>
                    <option value="2" <?php echo ($_POST['arena'] == '2' ? 'selected="selected"' : '');?>>Sta Monica Cockpit</option>
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

