<?php
    require_once('../classes/ini_classes.php');    
    require_once('../classes/arena.php');
    $helper->validate_admin_session('../admin.php');
    if(isset($_POST['logoff']))
    {
        $arena->admin_logoff();
        $helper->redirect('../index.php');
    }
    else
    {
        $arena->open_arena($_SESSION['admin_arena_id']); //just make sure Arena is open
        if($arena->game_is_running($_SESSION['admin_arena_id'])===false)
        {
            $enable_open_game = '';
            $enable_close_game = "disabled=\"disabled\"";
            $game_open = false;
        }
        else
        {
            $enable_open_game = "disabled=\"disabled\"";
            $enable_close_game = '';
            $game_open = true;
        }
        
        if($game_open==true)
        {
            $ongoing_fight = $arena->fight_is_ongoing($_SESSION['admin_arena_id']);
            if($ongoing_fight==true)
            {
                if($arena->betting_is_open($_SESSION['admin_arena_id']))
                {
                    $enable_new_fight = "disabled=\"disabled\"";
                    $enable_open_bet = "disabled=\"disabled\"";
                    $enable_close_bet = "";
                    $enable_process_bets = "disabled=\"disabled\"";
                    $enable_declare_fight_result = "disabled=\"disabled\"";
                }
                else
                {
                    $enable_new_fight = "";
                    $enable_open_bet = "disabled=\"disabled\"";
                    $enable_close_bet = "disabled=\"disabled\"";
                    $enable_process_bets = "disabled=\"disabled\"";                   
                    $enable_declare_fight_result = "disabled=\"disabled\"";
                }
            }
            else
            {
                if($arena->betting_is_open($_SESSION['admin_arena_id']))
                {
                    $enable_new_fight = "disabled=\"disabled\"";
                    $enable_open_bet = "disabled=\"disabled\"";
                    $enable_close_bet = "";
                    $enable_process_bets = "disabled=\"disabled\"";                    
                    $enable_declare_fight_result = "disabled=\"disabled\"";
                }
                else
                {
                    $enable_new_fight = "";
                    $enable_open_bet = "disabled=\"disabled\"";
                    $enable_close_bet = "disabled=\"disabled\"";
                    $enable_process_bets = "disabled=\"disabled\"";
                    $enable_declare_fight_result = "disabled=\"disabled\"";
                }
            }
        }
        else
        {
            $enable_new_fight = "disabled=\"disabled\"";
            $enable_open_bet = "disabled=\"disabled\"";
            $enable_close_bet = "disabled=\"disabled\"";
            $enable_process_bets = "disabled=\"disabled\"";
            $enable_declare_fight_result = "disabled=\"disabled\"";
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
               $("td#fight_header").load('../includes/arena/fight_header.php?type=admin');
               $("td#fight_seq_number").load('../includes/arena/fight_seq_number.php?type=admin');
               $("td#betting_status").load('../includes/arena/betting_status.php?type=admin');
               $("td#fight_result").load('../includes/arena/fight_result.php?type=admin');
               $("td#bet_count").load('../includes/arena/bet_count.php?type=admin');
               $("div#online_users").load('../includes/arena/admin_display_online_users.php');
               $("td#online_users_count").load('../includes/arena/online_users.php');
            }, 1000);
            
            //open or create game
            $("button#open_game").click(function(){
                 $.ajax({
                   type: "POST",
                   url: "../includes/arena/dumb/open_game.php",
                   data: "open=1",
                   success: function(msg){
                        $("button#open_game").attr('disabled', 'disabled');
                        $("button#close_game").removeAttr("disabled"); 
                        $("button#new_fight").removeAttr("disabled"); 
                        alert("Game has been initialized Proceed with opening the betting");
                    }
                 });
            });
            
            //close the game
            $("button#close_game").click(function(){
                 $.ajax({
                   type: "POST",
                   url: "../includes/arena/dumb/close_game.php",
                   data: "open=1",
                   success: function(msg){
                        $("button#close_game").attr('disabled', 'disabled');
                        $("button#open_game").removeAttr("disabled"); 
                        $("button#new_fight").attr('disabled', 'disabled');
                        alert("Game has been succesfully closed");
                    }
                 });
            });
            
            //close the game
            $("button#new_fight").click(function(){
                 $.ajax({
                   type: "POST",
                   url: "../includes/arena/dumb/new_fight.php",
                   data: "open=1",
                   success: function(msg){
                        $("button#new_fight").attr('disabled', 'disabled');
                        $("button#open_bet").removeAttr("disabled"); 
                        alert("Fight has been succesfully created");
                    }
                 });
            });
            
            //open betting
            $("button#open_bet").click(function(){
                 $.ajax({
                   type: "POST",
                   url: "../includes/arena/dumb/open_betting.php",
                   data: "open=1",
                   success: function(msg){
                        $("button#open_bet").attr('disabled', 'disabled');
                        $("button#close_bet").removeAttr("disabled"); 
                        alert("Betting is now OPEN");
                    }
                 });
            });
            
            //close betting
            $("button#close_bet").click(function(){
                 $.ajax({
                   type: "POST",
                   url: "../includes/arena/dumb/close_betting.php",
                   data: "open=1",
                   success: function(msg){
                        $("button#close_bet").attr('disabled', 'disabled');
                        $("button#declare_fight_result").removeAttr("disabled");
                        alert("Betting is now CLOSED");
                    }
                 });
            });


        });
    </script>
</head>
<body>
    <div id="container" >
        <!--<div id="header"></div>-->
        <div id="body">
            <div id="subHeader">
                 <h1>Welcome to <?php echo $login->sel_admtype($_SESSION['arena_id']); ?> Coliseum</h1>
                    <input type="hidden" id="admin_type" value="<?php echo $_SESSION['admin_type_id']; ?>" />
                    <span id="videoBtn">
                        <button id="open_game" <?php echo $enable_open_game; ?>>Open Game</button>
                        <button id="close_game" <?php echo $enable_close_game; ?>>Close Game</button>
                    </span>
                    <h4>Hi <?php echo $_SESSION['admin_username']; ?></h4>
                <span class="betBtns">
                    <button>All Bets</button>
                    <form action="<?php $_PHP['SELF'] ;?>" method="POST"><input id="logout" type="submit" name="logout" value="Logout" /></form>
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
                        $("td#w<?php echo $rowOdds['odd_id']?>").load('../includes/arena/odd_board.php?bettype=wala&oddid=<?php echo $rowOdds['odd_id']?>&usertype=admin');
                        }, 1000);
                    </script>                        
                    <?php
                    echo "</td><td>".$rowOdds['odd_name']."</td>";
                    echo "<td class=\"meron\" id=\"m".$rowOdds['odd_id']."\">"; ?>
                    <script type="text/javascript">
                        var auto_refresh = setInterval(
                        function (){
                        $("td#m<?php echo $rowOdds['odd_id']?>").load('../includes/arena/odd_board.php?bettype=meron&oddid=<?php echo $rowOdds['odd_id']?>&usertype=admin');
                        }, 1000);
                    </script>
                    <?php
                    echo "</td></tr>";
                } ?>
            </table>
            
            <!-- online users module -->            
            <br /><br />
            
            <table>
                <tr>
                    <td>            <strong>Online Users</strong>
            <div id="online_users"></div>                
</td>
                </tr>
            </table>
                
            </div>            
            <div id="controlButtons">
                <button id="new_fight" <?php echo $enable_new_fight; ?>>New Fight</button>
                <button id="open_bet" <?php echo $enable_open_bet; ?>>Open Betting</button>
                <button id="close_bet" <?php echo $enable_close_bet; ?>>Close Betting</button>
                <button id="process_bets" <?php echo $enable_process_bets; ?>>Process All Bets</button>
            </div>
            <div id="status">
                <p>Admin Message</p>
                <textarea id="adminMsg" rows="5" cols="30"></textarea>
                <form>
                    <select id="winning_result">
                        <option value="wala">Wala</option>
                        <option value="meron">Meron</option>
                        <option value="no_winner">No Winner</option>
                        <option value="draw">Draw</option>
                    </select>
                    <button id="declare_fight_result" <?php echo $enable_declare_fight_result; ?>>Declare Fight Result</button>
                </form>
                
                <table border="0" id="gmeStatUser">
                    <tr><td id="head"><h4>Game Details</h4></td><td id="fight_header"></td></tr>
                    <tr><td>Fight #:</td><td id="fight_seq_number"></td></tr>
                    <tr><td>Fight Result:</td><td id="fight_result"></td></tr>
                    <tr><td>Betting Status:</td><td id="betting_status"></td></tr>
                    <tr><td># of online players:</td><td id="online_users_count"></td></tr>
                    <tr><td># of Bets:</td><td id="bet_count"></td></td></tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>