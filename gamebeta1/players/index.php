<?php 
    require_once('../classes/ini_classes.php');
    require_once('../classes/arena.php');
    require_once('../classes/player.php');
    
    $helper->validate_player_session('../player.php');
    if(isset($_POST['logoff']))
    {
        $arena->user_logoff();
        $helper->redirect('../player.php');
    }
    else
    {
        if($arena->check_arena_id('player')==true)
        {
            $arena->user_register_as_online();
        }
        else
        {
            $helper->redirect('choose_arena.php');
        }
        
        $player_credit = $player->get_player_info($_SESSION['user_user_id'],'user_credits');
        if($player_credit < 100)
        {
            $enable_betting = "disabled=\"disabled\"";
        }
        else
        {
            $betting_open = $arena->betting_is_open($_SESSION['user_arena_id']);
            if($betting_open)
            {
                $enable_betting = "";
            }
            else
            {
                $enable_betting = "disabled=\"disabled\"";
            }
        }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title><?php echo APP_FULLNAME; ?> - <?php echo (isset($subTitle) ? $subTitle : ""); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="author" content="myClick Technologies Inc." />
    <meta name="description" content="<?php echo APP_FULLNAME; ?>" />
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery-1.5.1.js"></script>
    <script type="text/javascript">
        $(function(){
            $("div#lbContent").hide();
            $("div#lbBg").hide();
            var auto_refresh = setInterval(
            function (){
               $("td#fight_header").load('../includes/arena/fight_header.php?type=player');
               $("td#fight_seq_number").load('../includes/arena/fight_seq_number.php?type=player');
               $("td#betting_status").load('../includes/arena/betting_status.php?type=player');
               $("td#bet_count").load('../includes/arena/bet_count.php?type=player');
               $("td#fight_result").load('../includes/arena/fight_result.php?type=player');
            }, 1000);
            
            //place bet
            $("button#place_bet").click(function(){
                 var odds = $("select#odds").val();
                 var amount = $("select#bet_amount").val();
                 var bettype = $("input:radio[name=wala_meron]:checked").val();
                 
                 if(odds != '' && amount != '')
                 {
                     
                     $.ajax({
                       type: "POST",
                       url: "../includes/arena/dumb/player_place_bet.php",
                       data: "odds=" + odds + "&amount=" + amount + "&bettype=" + bettype,
                       success: function(msg){
                        //$("button#place_bet").attr('disabled', 'disabled');
                        //$("button#cancel_bet").removeAttr("disabled"); 
                        alert(msg);
                        }
                     });                 
                 }
                 else
                 {
                     alert('Please select odds and amount');
                 }
            });
            
        });
    </script>
</head>
<body>
        <div id="container">
        <!--<div id="header"></div>-->
        <div id="body">
            <div id="subHeader">
                <h1>Welcome to <?php echo $arenaInfo['arena_name']; ?> Coliseum</h1>
                <span id="betBtns">
                    <a href="choose_arena.php"><button>Change Arena</button></a><button>All Bets</button><button>My Bets</button>
                    <form action="<?php $_PHP['SELF'] ;?>" method="POST"><input type="submit" name="logoff" value="Log-Off" /></form>
                </span>    
            </div>
            <div id="video">
                <div id="bg_player_location">
                    <a href="http://www.adobe.com/go/getflashplayer">
                        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
                    </a>
                </div>
                <script type="text/javascript" src="http://bitcast-b.bitgravity.com/player/6/functions.js"></script>
                <script type="text/javascript">
                    // <![CDATA[
                    var flashvars = {};
                    var playerWidth = 720;
                    var playerHeight = 480 + 20; // adjust for the "toolbar" at the bottom
                    flashvars.File = "http://bglive-a.bitgravity.com/moening/hkg/live/feed01";
                    flashvars.Mode = "live";
                    flashvars.AutoPlay = "false";
                    flashvars.ScrubMode = "simple";
                    flashvars.BufferTime = "1.5";
                    flashvars.VideoFit = "automatic";
                    flashvars.DefaultRatio = "1.5";
                    flashvars.LogoPosition = "topleft";
                    flashvars.ColorBase = "#FFFFFF";
                    flashvars.ColorControl = "#666666";
                    flashvars.ColorHighlight = "#7FBF3C";
                    flashvars.ColorFeature = "#7FBF3C";
                    var params = {};
                    params.allowFullScreen = "true";
                    params.allowScriptAccess = "always";
                    var attributes = {};
                    attributes.id = "bitgravity_player_6";
                    swfobject.embedSWF(stablerelease, "bg_player_location", playerWidth,
                    playerHeight, "9.0.0",
                    "http://bitcast-b.bitgravity.com/player/expressInstall.swf",
                    flashvars, params, attributes);
                    // ]]>
                </script>
                <div id="bg_player_location"></div>
            </div>
            <div id="board">
                <table border="1">
                <tr><td>Wala</td><td>Odds</td><td>Meron</td></tr> <?php
                    $queryOdds = "SELECT * FROM odds ORDER BY odd_id ASC";
                    $execQueryOdds = mysql_query($queryOdds);                    
                    while($rowOdds = mysql_fetch_array($execQueryOdds, MYSQL_ASSOC)){
                        echo "<tr><td class=\"wala\" id=\"w".$rowOdds['odd_id']."\">"; ?>
                        <script type="text/javascript">
                            var auto_refresh = setInterval(
                            function (){
                            $("td#w<?php echo $rowOdds['odd_id']?>").load('../includes/arena/odd_board.php?bettype=wala&oddid=<?php echo $rowOdds['odd_id']?>&usertype=player');
                            }, 1000);
                        </script>                        
                        <?php
                        echo "</td><td>".$rowOdds['odd_name']."</td>";
                        echo "<td class=\"meron\" id=\"m".$rowOdds['odd_id']."\">"; ?>
                        <script type="text/javascript">
                            var auto_refresh = setInterval(
                            function (){
                            $("td#m<?php echo $rowOdds['odd_id']?>").load('../includes/arena/odd_board.php?bettype=meron&oddid=<?php echo $rowOdds['odd_id']?>&usertype=player');
                            }, 1000);
                        </script>
                        <?php
                        echo "</td></tr>";
                    } ?>
                </table>
            </div>
            <div id="userInfo">
                <h5>User Info:</h5>
                <h5>Username: <?php echo "<span>".$_SESSION['user_username']."</span>"; ?></h5>
                <h5>Credits: <span id="credit"></span></h5>
            </div>
            <div id="userCtrlHead">
                Place Bets Here
            </div>
            <div id="statusUser">
                <textarea id="adminMsg" rows="5" cols="30"></textarea>                        
                <div id="placeBets">
                    <table>
                        <tr>
                            <span id="walameronBtn">
                                <td id="leftPlaceBet">WALA
                                <input type="radio" value="wala" name="wala_meron" id="bet_wala" <?php echo $enable_betting; ?> /></td>
                                <td id="rightPlaceBet">MERON
                                <input type="radio" value="meron" name="wala_meron" id="bet_meron" <?php echo $enable_betting; ?> /></td>
                            </span>
                        </tr>
                        <tr><td id="leftPlaceBet"><h4>Odds</h4></td></tr>
                        <tr><td id="leftPlaceBet"><select id="odds">
                                <option value="" selected>Odds</option>
                                <?php
                                    $queryOdds = "SELECT * FROM odds";
                                    $execQueryOdds = mysql_query($queryOdds);
                                    while($rowOdds = mysql_fetch_array($execQueryOdds, MYSQL_ASSOC)){
                                        if($rowOdds['odd_id'] < 15){
                                            echo "<option value=\"".$rowOdds['odd_id']."\">".$rowOdds['odd_name']."</option>";	
                                        }
                                    }
                                ?>
                            </select></td>
                            <td id="rightPlaceBet"><button id="place_bet">Place Bet</button></td>
                        </tr>
                        <tr><td id="leftPlaceBet"><h4>Bet Amount</h4></td></tr>
                        <tr>
                            <td id="leftPlaceBet"><select id="bet_amount">
                                    <option value="" selected>Amount</option>
                                <?php
                                    // By tens
                                    $num = 0;
                                    while($num < 100){
                                        $num = $num + 10;
                                        echo "<option value=\"".$num."\">".$num."</option>";
                                    }
                                    // By hundreds
                                    $num2 = 100;
                                    while($num2 < 500){
                                        $num2 = $num2 + 100;
                                        echo "<option value=\"".$num2."\">".$num2."</option>";
                                    }
                                ?>
                                </select></td>
                                <td id="rightPlaceBet"><button id="cancel_bet">Cancel</button></td>
                        </tr>
                    </table>
                </div>
                <table border="0" id="gmeStatUser">
                    <tr><td id="head"><h4>Game Details</h4></td><td id="fight_header"></td></tr>
                    <tr><td>Fight #:</td><td id="fight_seq_number"></td></tr>
                    <tr><td>Fight Result:</td><td id="fight_result"></td></tr>
                    <tr><td>Betting Status:</td><td id="betting_status"></td></tr>
                    <tr><td># of Bets:</td><td id="bet_count"></td></td></tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>