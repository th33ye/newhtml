<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sabong Now - Player</title>
</head>
<!-- <link href="css/style.css" rel="stylesheet" type="text/css" /> -->
<title>Sabong</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/game.css" rel="stylesheet" type="text/css" />

<?php 
session_start();

$urlinvalid="invalid.php";

if (!empty($_SESSION['user_user_id']) && !empty($_SESSION['arenaId']))
{
	$userId = $_SESSION['user_user_id'];
	$arenaId = $_SESSION['arenaId'];
}
else
{	
	header( "Location: $urlinvalid") ;	
}

?>

<script src="finalStage.js" type="text/javascript"></script>
<script src="dataPost.js" type="text/javascript"></script>
<script src="tranCheck.js" type="text/javascript"></script>
<script src="jquery-1.5.2.min.js" type="text/javascript"></script>
<script src="displayManager.js" type="text/javascript"></script>
<script src="betManager.js" type="text/javascript"></script>
<!-- <script id="gameplayer" type="text/javascript" src="js/gameplayer-min.js"></script> -->
<!-- <script type="text/javascript" src="http://bitcast-b.bitgravity.com/player/6/functions.js"></script> -->
<!-- include the jQuery Tools --> 
<script src="http://cdn.jquerytools.org/1.2.5/full/jquery.tools.min.js"></script> 
<!-- include flowplayer -->
<!-- <script type="text/javascript" src="flowplayer/flowplayer-3.2.6.min.js"></script> -->
<!-- standalone page styling (can be removed) --> 
<link rel="stylesheet" type="text/css" href="http://static.flowplayer.org/tools/css/standalone.css"/>
<link rel="stylesheet" type="text/css" href="http://static.flowplayer.org/tools/css/overlay-basic.css"/>

<script type="text/javascript">

function DisplayNotice()
{
   alert("*** BETA Testing has ended on April 24, 2011 ***\n\n"
         + "Players with existing credits has been updated.\n"
         + "Players without credits can inquire thru our CSR on how to load.\n\n"
         + "LET THE SABONG BEGIN!");
}

//var interval;
//var popInterval;
//$(document).ready(function() {
//   interval = setInterval("trackLogin('<?php echo $_SESSION['user_user_id']; ?>')", 1000);
//   popInterval = setInterval("popBlock('<?php echo $_SESSION['user_user_id']; ?>')", 1000);
//});

function trackLogin(userid)
{
   $.ajax({
      type     : 'POST',
      url      : 'checkLogin.php',
      dataType : 'json',
      data     : {userid: userid},
      success  : function(data) {
         if (data.logout == '0') {
//            clearInterval(interval);
//            alert('You have been logged out.');
            document.location.href = "Logout.php";
         }
      }
   });
   setTimeout("trackLogin('<?php echo $_SESSION['user_user_id']; ?>')", 2000);
}

function popCredit(userid)
{
   $.ajax({
      type     : 'POST',
      url      : 'checkCredit.php',
      dataType : 'json',
      data     : {userid: userid},
      success  : function(data) {
         if (data.block == '1') {
            $("#blocking").overlay({
               // custom top position
               top: 30,
               // some mask tweaks
               mask: {
                  // this can be a transparent color mask
                  color: '#fff',
                  // load mask a little faster
                  loadSpeed: 200,
                  // very transparent
                  opacity: 0.5
               },
               // disable this for modal dialog-type of overlay
               closeOnClick: false,
               // disable close on <ESC> key press
               closeOnEsc: false,
               // load it immediately after the construction
               load: true
            });
         }
//         else if (data.pop == '0') {
//            $("#blocking").overlay().close();
//         }
      }
   });
   setTimeout("popCredit('<?php echo $_SESSION['user_user_id']; ?>')", 2000);
}

function popBlock(userid)
{
   $.ajax({
      type     : 'POST',
      url      : 'checkPop.php',
      dataType : 'json',
      data     : {userid: userid},
      success  : function(data) {
         if (data.pop == '1') {
            $("#blocking").overlay({
               // custom top position
               top: 30,
               // some mask tweaks
               mask: {
                  // this can be a transparent color mask
                  color: '#fff',
                  // load mask a little faster
                  loadSpeed: 200,
                  // very transparent
                  opacity: 0.5
               },
               // disable this for modal dialog-type of overlay
               closeOnClick: false,
               // disable close on <ESC> key press
               closeOnEsc: false,
               // load it immediately after the construction
               load: true
            });
         }
//         else if (data.pop == '0') {
//            $("#blocking").overlay().close();
//         }
      }
   });
   setTimeout("popBlock('<?php echo $_SESSION['user_user_id']; ?>')", 2000);
}

function refreshFightResults()
{
	$.post("results-ajax.php", '',
		function (data) {
			if(data.success == '1') {
				$('#tblResults').remove();
				var tbl = $('<table id=\'tblResults\'></table>');
				tbl.append('<tr><th style="width: 20px;">G</th><th>R</th></tr>');
				jQuery.each(data.fight_data, function(i, val) {
					var tr = $('<tr></tr>');
					$.each(val, function(i, newVal) {
						var td = $('<td></td>').text(newVal);
						tr.append(td);
					});
					tbl.append(tr);
					$('#running-result').append(tbl);
				});
			} // endif
		}, "json");
	setTimeout('refreshFightResults()', 3000);
}


function ProcessRequest()
{

 	LoadBettingConsole();	
	LoadMyBetsTable();	
 	LoadOddIds();	
   //DisplayNotice();
	//LoadVideoConsole();
   //displayVideo();
   trackLogin('<?php echo $_SESSION['user_user_id']; ?>');
   popBlock('<?php echo $_SESSION['user_user_id']; ?>');
	refreshFightResults();
   //popCredit('<?php echo $_SESSION['user_user_id']; ?>');
	Start();		
}

</script>

<body bgcolor="#000000"  onload="ProcessRequest();">
<input type="hidden" id="AllDisplay" name="AllDisplay" size="100%"/>
<input type="hidden" id="betsLoaded" nme="betsLoaded" value="0"/>
<input type="hidden" id="betsLoaded1" nme="betsLoaded" value="0"/>
<input type="hidden" id="betOnOdd" nme="betOnOdd" value="0"/>
<table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td width="5%">&nbsp;</td>
    <td><table width="100%" border="0">
      <tr>
        <td width="23%"><strong>User Credits</strong></td>
        <td width="23%"><strong>User Name</strong></td>
        <td width="24%">&nbsp;</td>
        <td width="30%"><strong>Your Current Arena</strong></td>
        </tr>
      <tr>
        <td><strong><label id="userCredits"></label></strong></td>
        <td>
        <strong>
        <label id="username">
        <?php
        
			include 'dbConn.php';
      		$result2 = mysql_query("SELECT user_username FROM users WHERE user_id = " . $userId);
            $outputStr = "";
            while ($row2 = mysql_fetch_array($result2))
            {
               $outputStr = $row2['user_username'];
            }
            
            echo $outputStr;
        
        ?>
        </label>
        </strong>        </td>
        <td>&nbsp;</td>
        <td>
        <strong>
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
    <td width="25%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
  </tr>
  <tr>
    <td height="298"><div id="running-result"></div></td>
    <td align="center" valign="center" id="videoContainer">       

<div id="bg_player_location">
	<a href="http://www.adobe.com/go/getflashplayer">
		<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
	</a>
</div>
			<script type="text/javascript" src="http://bitcast-b.bitgravity.com/player/6/functions.js"></script>
			<script type="text/javascript">
			var flashvars = {};
			flashvars.File = "http://bglive-w.bitgravity.com/abenmach/secure/live/atc?e=0%26h=9702450811bd5b3f92842ab054a7f1ee";
			flashvars.Mode = "ondemand";
			flashvars.AutoPlay = "true";
			flashvars.BufferTime = "1.5";
			flashvars.VideoFit = "stretch";
			flashvars.DefaultRatio = "1.777778";
			flashvars.LogoImage = "";
			flashvars.LogoPosition = "topleft";
			flashvars.ColorBase = "#009597";
			flashvars.ColorControl = "#5aff76";
			flashvars.ColorHighlight = "#3cff80";
			flashvars.ColorFeature = "#010300";
			var params = {};
			params.allowFullScreen = "false";
			params.allowScriptAccess = "always";
			params.wmode = "opaque";
			var attributes = {};
			attributes.id = "bitgravity_player_6";
			swfobject.embedSWF(stablerelease, "bg_player_location", "740", "500", "9.0.115", "http://bitcast-b.bitgravity.com/player/expressInstall.swf", flashvars, params, attributes);
			</script>

<!--
<div id="bg_player_location">
   <a 
      href="http://pseudo01.hddn.com/vod/demo.flowplayervod/flowplayer-700.flv" 
      id="player" 
      style="display:block;width:700px;height:500px">
   </a>
</div>
       <script type="text/javascript">
         $f("player", {src:"http://releases.flowplayer.org/swf/flowplayer-3.2.7.swf", wmode: 'opaque', cachebusting:true},
         {
            // this will enable bitgravity's live streaming support
            // change path to ex: http://bitgravity.co/plugins/
            plugins: {
               bitgravity: { url: 'http://bitcast-b.bitgravity.com/player/6/bitgravity.livestreaming.swf' },
               controls: {
                  fullscreen: false,
                  buttons: false
               }
            },
            // 
            onBeforeFullscreen: function() {
               this.getControls().enable({fullscreen: false});
               return false;
            },
            // clip properties
            clip: {
               // make this clip use bitgravity's live plugin with "provider" property
               autoBuffering: false,
               autoplay: true,
               provider: 'bitgravity',
               scaling: "fit",
               live: "true",
               // live video to stream
//               url: escape('http://bglive-w.bitgravity.com/abenmach/secure/live/atc?e=0&h=9702450811bd5b3f92842ab054a7f1ee')

               url: escape('http://bglive-a.bitgravity.com/abenmach/secure/live/atc?e=0&h=9702450811bd5b3f92842ab054a7f1ee')
            },
            // canvas configuration
            canvas: {backgroundColor: "transparent"}
         });
         
      </script>
  --> 

    </td>
    <td align="center" valign="top">
    <h2><strong>TOTAL GAME BET</strong></h2>
    <div id="gameConsole"></div>
    <br />
    <h2><strong>MY BET</strong></h2>
    <div id="bettingTable"></div></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><table width="100%" border="0">
      <tr align="center">
        <td width="20%"valign="center"><h2>&nbsp;</h2></td>
        <td><h2>&nbsp;</h2>          <h2><strong>Game Result</strong></h2></td>
        </tr>
      <tr>
        <td align="center">
          <table width="100%" border="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>          </td>
        <td align="center"><table width="68%" border="1" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50%">Fight Number</td>
            <td width="50%" align="center"><div id="gameNo"></div></td>
          </tr>
          <tr>
            <td>Fight Result</td>
            <td align="center"><div id="gameResult"></div></td>
          </tr>
          <tr>
            <td>Betting Status</td>
            <td align="center"><div id="betStatus"></div></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
    <td valign="top" align="center">
    <p>
      <input type="submit" name="RefreshPage" id="RefreshPage" value="REFRESH PAGE" onClick="window.location.reload();" />
    </p>
    <form id="form1" name="form1" method="post" action="Logout.php">


        <p>&nbsp;</p>
        <p>
          <input type="submit" name="ExitArena" id="ExitArena" value="EXIT ARENA" />
        </p>
    </form>    
    <table width="100%" border="1" cellpadding="0" cellspacing="0" id="bettingOrig">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="3">
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
              <td colspan="3"><table>
                  <tr>
                    <td><input  width="40" type="button" name="btnPlaceBet" id="btnPlaceBet" value="  PLACE BET   " onclick="ConfirmBet('place');"/>
                    </td>
                    <td><input  width="40" type="button" name="btnPlaceBet" id="btnCancelBet" value="  MODIFY BET  " onclick="ConfirmBet('cancel');"/>
                    </td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
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
<td><input type="hidden" id="arenaId" value="<?php echo $_SESSION['arenaId']; ?>"></td>
<td> <input type="hidden" id="userCreditsHidden"></td>
<td><input type="hidden" id="oddsIdList"></td>
<td><input type="hidden" id="currentView" /></td>
<td><input type="hidden" id="betVal" /></td>

</tr>

</table>
  
      <input name="signalFlag" type="hidden" id="signalFlag" value="test"/>
      <input type="hidden" name="CurrentTime" id="CurrentTime" />
<!-- window for overlaying -->      
<div id="blocking" style="display: none">
   <div>
      <img src="images/blocking.gif" height="650" />
   </div>
</div>      
<!--
      <input  width="40" type="button" name="btnPlaceBet2" id="btnPlaceBet2" value="&nbsp;&nbsp;START &nbsp;&nbsp;" onclick="ProcessRequest()"/>
      <input  width="40" type="button" name="btnPlaceBet3" id="btnPlaceBet3" value="&nbsp;&nbsp;STOP &nbsp;&nbsp;" onclick="Stop();"/>
      -->
</body>
</html>
