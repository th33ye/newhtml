<?php
session_start();
if (empty($_SESSION['user_user_id']) && empty($_SESSION['arenaId'])) {
    header("Location: invalid.php");
}
else {
    $userId = $_SESSION['user_user_id'];
    $arenaId = $_SESSION['arenaId'];
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sabong Now - Player</title>

    <!-- new CSS for game module -->
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/game.css" rel="stylesheet" type="text/css" />
	<link href="css/game-module-1.0.1.css" rel="stylesheet" type="text/css" media="screen">
	<!-- include Jquery and JqueryTools -->
	<script src="new-js/jquery.tools.min.js"></script>
	<!-- Chat JS Library -->
	<script src="new-js/json2.js"></script>
	<script src="new-js/easyWebSocket2.min.js"></script>
	<!-- <script src="http://easywebsocket.org/easyWebSocket.min.js"></script> -->
    <script src="new-js/jquery.tmpl.min.js"></script>
    <script src="new-js/jQuery.url.js"></script>
    <script src="new-js/main2.js"></script>
	<!-- Game Module JS Library -->
    <script src="finalStage.js" type="text/javascript"></script>
    <script src="dataPost.js" type="text/javascript"></script>
	<script src="tranCheck.js" type="text/javascript"></script>
    <script src="displayManager.js" type="text/javascript"></script>
    <script src="betManager-1.0.1.js" type="text/javascript"></script>

    <script type="text/javascript">
        function ProcessRequest()
        {
            LoadBettingConsole();
            LoadMyBetsTable();
            LoadOddIds();
            Start();
        }
    </script>
</head>

<body bgcolor="#000000"  onload="ProcessRequest();">
    <input type="hidden" id="AllDisplay" name="AllDisplay" size="100%"/>
    <input type="hidden" id="betsLoaded" nme="betsLoaded" value="0"/>
    <input type="hidden" id="betsLoaded1" nme="betsLoaded" value="0"/>
    <input type="hidden" id="betOnOdd" nme="betOnOdd" value="0"/>

    <input type="hidden" id="userId" value="<?php echo $_SESSION['user_user_id']; ?>" />
    <input type="hidden" id="gameId" />
    <input type="hidden" id="arenaId" value="<?php echo $_SESSION['arenaId']; ?>" />
    <input type="hidden" id="userCreditsHidden" />
    <input type="hidden" id="oddsIdList" />
    <input type="hidden" id="currentView" />
    <input type="hidden" id="betVal" />

    <div id="game_container" style="height: 490px;">
        <div id="game_header_container">
            <div id="game_header_arena">
                <span><?php echo $_SESSION['arena']; ?></span>
            </div>
            <div id="game_detail_container">
                <div id="game_header_credit">
                    <span class="game_header_label">CREDITS</span><br>
                    <span class="game_header_value" id="userCredits"></span>
                </div>
                <div id="game_header_status">
                    <div id="game_username">
                        <span class="game_header_label">USERNAME</span><br>
                        <span class="game_header_value" id="username"><?php echo $_SESSION['user_username']; ?></span>
                    </div>
                    <div id="game_fight_no">
                        <span class="game_header_label">FIGHT</span><br>
                        <span class="game_header_value" id="gameNo"></span>
                    </div>
                    <div id="game_fight_status">
                        <span class="game_header_label">STATUS</span><br>
                        <span class="game_header_value" id="betStatus"></span>
                    </div>
                    <div id="game_fight_result">
                        <span class="game_header_label">RESULT</span><br>
                        <span class="game_header_value" id="gameResult"></span>
                    </div>
                </div>
                <div id="game_menu_container">
                    <a href="#" onClick="window.location.reload(); return false;" >REFRESH PAGE</a>
                    <a href="Logout.php" title="Logout"><img src="img/power-btn-1.png" alt="Logout"></a>
                </div>
            </div>
        </div>
        <div id="game_module_container">
            <div id="container">
                <!-- <div id="msg-container"> -->
                <div class="header">
                    <div class="statusContainer">
                        <span class="label">Status: </span>
                        <span class="status value">Connecting</span>
                        <span class="label">Channel: </span>
                        <span class="channel value"">Unknown</span>
                    </div>
                    <div class="userContainer">
                        <span class="label">Username: </span>
                        <span class="username value">Unknown</span>
                        <!-- <input class="editButton" type="button" value="Edit" /> -->
                    </div>
                </div>
                <div class="chatArea" style="width: 1065px; height: 340px;">
                </div>
                <script class="tmplChatMessage" type="text/x-jquery-tmpl">
                <div>
                    <span class="username">${username}</span> :
                    <span class="message">${message}</span>
                </div>
                </script>
                <script class="tmplChatJoin" type="text/x-jquery-tmpl">
                <div>
                    <span class="username">${username}</span>
                    <span>is online.</span>
                </div>
                </script>
                <script class="tmplChatRename" type="text/x-jquery-tmpl">
                <div>
                    <span class="oldUsername username">${oldUsername}</span>
                    <span>is renamed as</span>
                    <span class="newUsername username">${newUsername}</span>
                </div>
                </script>
                <!-- </div> -->
                <div class="footer" style="width: 1080px;">
                    <form id="chat-form" action="#">
                        <input class="input" id="chat-input" type="text" style="width: 950px;" />
                        <input class="submit" id="chat-submit" type="submit" value="Send" />
                    </form>
                </div>
            </div>
            <input name="signalFlag" type="hidden" id="signalFlag" value="test"/>
            <input type="hidden" name="CurrentTime" id="CurrentTime" />
        </div>
    </div>

</body>
</html>
