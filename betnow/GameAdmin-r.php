<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sabong Now - Game Admin</title>
</head>
<title>Sabong</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/game.css" rel="stylesheet" type="text/css" />

<?php 
session_start();

$urlinvalid="invalid.php";

if (!empty($_SESSION['user_user_id']) 
	&& !empty($_SESSION['admin_user_id']) 
	&& !empty($_SESSION['admin_arena_id']) 
	&& !empty($_SESSION['AdminUseOnly']))
{ 	
	 //Default as user for admin use only admin cannot place bets;
	$userId = $_SESSION['user_user_id'];
	$adminId = $_SESSION['admin_user_id'];
	$arenaId = $_SESSION['admin_arena_id'];	
	
}
else
{
	header( "Location: $urlinvalid");
}



?>


<script src="finalStage.js" type="text/javascript"></script>
<script src="dataPost.js" type="text/javascript"></script>
<script src="tranCheck.js" type="text/javascript"></script>
<script src="jquery-1.5.2.min.js" type="text/javascript"></script>
<script src="displayManager.js" type="text/javascript"></script>
<script src="betManager-1.0.1.js" type="text/javascript"></script>


<script>


function ProcessRequest()
{
 	LoadBettingConsole();	
 	LoadOddIds();
	Start();		
}



</script>




<body bgcolor="#000000"  onload="ProcessRequest()">
<table width="100%" border="0">
  <tr>
    <td><input type="hidden" id="AllDisplay" name="AllDisplay" size="100%"/></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td width="5%">&nbsp;</td>
    <td><table width="100%" border="0">
      <tr>
        <td width="23%">&nbsp;</td>
        <td width="23%"><strong>Admin User Name</strong></td>
        <td width="24%">&nbsp;</td>
        <td width="30%"><strong>Your Current Arena</strong></td>
        </tr>
      <tr>
        <td><strong>
        <label id="userCredits">0.00</label>
        </strong></td>
        <td>
        <strong>
        <label id="username">
        <?php
        
			include 'dbConn.php';
      		$result2 = mysql_query("SELECT admin_username FROM admin_users WHERE admin_id = " . $adminId);
            $outputStr = "";
            while ($row2 = mysql_fetch_array($result2))
            {
               $outputStr = $row2['admin_username'];
            }
            
            echo $outputStr;
        
        ?>
        </label>
        </strong>        </td>
        <td>&nbsp;</td>
        <td><strong>
        <?php
        
		
			include 'dbConn.php';
      		$result2 = mysql_query("SELECT arena_name FROM arena WHERE arena_id = " . $arenaId);
            $outputStr = "";
            while ($row2 = mysql_fetch_array($result2))
            {
               $outputStr = $row2['arena_name'];
            }
            
            echo $outputStr;
        
        ?>
        </strong>        </td>
        </tr>
    </table></td>
    <td width="25%" align="center"><h6>Betting Module</h6></td>
    <td width="5%">&nbsp;</td>
  </tr>
  <tr>
    <td height="298">&nbsp;</td>
    <td align="center" valign="center">

    <div id="bg_player_location"></div>
<script type="text/javascript" src="http://bitcast-b.bitgravity.com/player/6/functions.js"></script>
<script type="text/javascript">
var flashvars = {};
flashvars.File = "http://bglive-w.bitgravity.com/abenmach/secure/live/atc?e=0%26h=9702450811bd5b3f92842ab054a7f1ee";
//flashvars.File="http://bglive-a.bitgravity.com/abenmach/secure/live/atc?e=1303841136&h=89100b5feefb6107f2b1ccd2abf25057";
//flashvars.File="http://bglive-w.bitgravity.com/abenmach/secure/live/atc?e=1303801973%26h=50c7674f2c63700f3c70d8527b581f09";
//flashvars.File="http://bglive-w.bitgravity.com/abenmach/secure/live/atc?e=1303875615%26h=80930bfb3c45bfc6d930191c6649df9c";
flashvars.Mode = "ondemand";
flashvars.AutoPlay = "true";
flashvars.volume = "0";
flashvars.BufferTime = "1.5";
flashvars.VideoFit = "automatic";
flashvars.DefaultRatio = "1.777778";
flashvars.LogoPosition = "topleft";
flashvars.ColorBase = "#FFFFFF";
flashvars.ColorControl = "#DB060B";
flashvars.ColorHighlight = "#000000";
flashvars.ColorFeature = "#7B7B7B";
var params = {};
params.allowFullScreen = "true";
params.allowScriptAccess = "always";
var attributes = {};
attributes.id = "bitgravity_player_6";
swfobject.embedSWF(stablerelease, "bg_player_location", "480", "308", "9.0.115", "http://bitcast-b.bitgravity.com/player/expressInstall.swf", flashvars, params, attributes);
</script>

        </div>

    </td>
    <td valign=""><div id="gameConsole"></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="100%" border="0">
      <tr align="center">
        <td width="20%"valign="center"><h2>&nbsp;</h2></td>
        <td width="30%"><h2>&nbsp;</h2></td>
        <td width="50%"><h2><strong>Administration</strong></h2></td>
      </tr>
      <tr>
        <td><label></label>
          <table width="100%" border="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><label></label></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>          </td>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="3" id="bettingOrig">
          <tr>
            <td width="33%"><label></label></td>
            <td width="33%"><input type="radio" name="radio" id="rbWala" value="betType" />
              Wala</td>
            <td width="85"><div id="BetStatus">
                <input name="radio" type="radio" id="rbMeron" value="betType" checked="checked" />
              Meron</div></td>
          </tr>
          <tr>
            <td >Odds </td>
            <td><select name="Odds" id="Odds">
                <?php 
		
			include 'dbConn.php';
			$result = mysql_query("SELECT * FROM betoddslist");
			$outputStr = ""; 
			
			while ($row = mysql_fetch_array($result))
			{				
				$outputStr = $outputStr . "<option id='" . $row['bet_odd_id'] . "'>" .  $row['bet_oddw'] . "-" . $row['bet_oddm'] . "</option>";
			}

			echo $outputStr;
			mysql_close();
					
		?>
            </select></td>
            <td><label></label></td>
          </tr>
          <tr>
            <td>amount</td>
            <td><select name="Betamount" id="Betamount">
                <?php 
		
			include 'dbConn.php';
			$result = mysql_query("SELECT * FROM betamountlist");
			$outputStr = ""; 
			
			while ($row = mysql_fetch_array($result))
			{				
				$outputStr = $outputStr . "<option id='betamount" . $row['amount'] . "'>" .  $row['amount'] . "</option>";
			}

			echo $outputStr;
			mysql_close();
					
		?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3"><table>
                <tr>
                  <td><input  width="40" type="button" name="btnPlaceBet" id="btnPlaceBet" value="  PLACE BET   " onclick="ConfirmBet('place');"/>                  </td>
                  <td><input  width="40" type="button" name="btnPlaceBet" id="btnCancelBet" value="  MODIFY BET  " onclick="ConfirmBet('cancel');"/>                  </td>
                </tr>
            </table></td>
          </tr>
        </table></td>
        <td><table width="100%" border="0" >
          
          <tr align="center">
            <td><input type="button" class="button" name="btnCreateNewFight" id="btnCreateNewFight" value="Create New Fight" onclick="GetGameNo();"/></td>
          </tr>
          <tr>
            <td align="center"><input type="button" class="button" name="btnOpenBetting" id="btnOpenBetting" value="Open Betting" onclick="OpenBetting();"/></td>
          </tr>
          <tr>
            <td align="center"><input type="button" class="button" name="btnCloseBetting" id="btnCloseBetting" value="Close Betting" onclick="ConfirmCloseBetting();"/></td>
          </tr>
          <tr>
            <td align="center"><input type="button" class="button" style="height: 50px; background: #191970;" name="btnAnnounceMeronAsWinner" id="btnAnnounceMeronAsWinner" value="Meron Wins" onclick="ConfirmMWinner();"/></td>
          </tr>
          <tr>
            <td align="center"><input type="button" class="button" style="height: 50px; background: #ff6;" name="btnAnnounceWalaAsWinner" id="btnAnnounceWalaAsWinner" value="Wala Wins" onclick="ConfirmWWinner();"/></td>
          </tr>
          <tr>
            <td align="center"><input type="button" class="button" name="btnSetAsDraw" id="btnSetAsDraw" value="Game Draw" onclick="ConfirmDrawOrCancel('Draw');"/></td>
          </tr>
          <tr>
            <td align="center"><input type="button" class="button" name="btnSetAsCancelled" id="btnSetAsCancelled" value="Game Cancelled" onclick="ConfirmDrawOrCancel('Cancel')"/></td>
          </tr>
          <tr>
            <td align="center"><input type="button" class="button" name="btnEndGame" id="btnEndGame" value="End Game" onclick="ConfirmEndGame();"/></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
    <td valign="top" align="center"><table width="100%" border="1" cellpadding="0" cellspacing="0">
      <tr >
        <td colspan="2" align="center"><h2><strong>Game Result</strong></h2></td>
      </tr>
      <tr>
        <td width="50%">Fight Number</td>
        <td width="50%" align="center"><div id="gameNo"></div></td>
      </tr>
      <tr>
        <td>Fight Result</td>
        <td><div id="gameResult" align="center"></div></td>
      </tr>
      <tr>
        <td>Betting Status</td>
        <td><div id="betStatus" align="center"></div></td>
      </tr>
    </table>
    <p>&nbsp;</p>
    <form id="form1" name="form1" method="post" action="Logout.php">

        <input type="submit" name="ExitArena" id="ExitArena" value="EXIT ARENA" />

    </form>    <p>

    </p></td>
    <td valign="top"></td>
  </tr>
</table>


<table>
<tr>
<td></td><!--<td>UserId</td><td>GameId</td><td>ArenaId</td><td>UserCredits</td><td></td><td>CurrentView</td>-->
</tr>
<tr>
<td> <input type="hidden" id="userId" value="<?php echo $_SESSION['user_user_id']; ?>"></td>
<td><input type="hidden" id="gameId"></td>
<td><input type="hidden" id="arenaId" value="<?php echo $_SESSION['admin_arena_id']; ?>"></td>
<td> <input type="hidden" id="userCreditsHidden"></td>
<td><input type="hidden" id="oddsIdList"></td>
<td><input type="hidden" id="currentView" /></td>

</tr>

</table>
  
      <input name="signalFlag" type="hidden" id="signalFlag" value="test"/>
      <input type="hidden" name="CurrentTime" id="CurrentTime" />
<!--
      <input  width="40" type="button" name="btnPlaceBet2" id="btnPlaceBet2" value="&nbsp;&nbsp;START &nbsp;&nbsp;" onclick="ProcessRequest()"/>
      <input  width="40" type="button" name="btnPlaceBet3" id="btnPlaceBet3" value="&nbsp;&nbsp;STOP &nbsp;&nbsp;" onclick="Stop();"/>
      -->
</body>
</html>
