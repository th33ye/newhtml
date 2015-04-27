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
    <link href="chatbox.css" rel="stylesheet" type="text/css" />

    <link href="css/game-module-1.0.1.css" rel="stylesheet" type="text/css" media="screen">
    <!-- include Jquery and JqueryTools -->
    <script src="new-js/jquery.tools.min.js"></script>
    <!-- Chat JS Library -->
    <script src="chat.js"></script>
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
            setInterval('chat.update()', 1000);
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
    <input type="hidden" id="chatuser" value="<?php echo $_SESSION['user_username']; ?>" />
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
                <div id="page-wrap">
                    <div id="chat-wrap" style="width: 1090px; height: 340px;"><div id="chat-area" style="height: 315px;"></div></div>
                    <form id="send-message-area" style="width: 1090px;">
                        <p>Your message: </p>
                        <textarea id="sendie" maxlength = '1000' style="width: 960px;"></textarea>
                    </form>
                </div>
            </div>
            <input name="signalFlag" type="hidden" id="signalFlag" value="test"/>
            <input type="hidden" name="CurrentTime" id="CurrentTime" />
        </div>
    </div>

    <script type="text/javascript">
        name = $('#chatuser').val();

        // strip tags
        name = name.replace(/(<([^>]+)>)/ig,"");

        // display name on page
        $("#name-area").html("You are: <span>" + name + "</span>");

        // kick off chat
        var chat =  new Chat();
        $(function() {
            chat.getState();

            // watch textarea for key presses
            $("#sendie").keydown(function(event) {

                var key = event.which;

                //all keys including return.
                if (key >= 33) {

                    var maxLength = $(this).attr("maxlength");
                    var length = this.value.length;

                    // don't allow new content if length is maxed out
                    if (length >= maxLength) {
                        event.preventDefault();
                    }
                }
            });
            // watch textarea for release of key press
            $('#sendie').keyup(function(e) {

                if (e.keyCode == 13) {

                    var text = $(this).val();
                    var maxLength = $(this).attr("maxlength");
                    var length = text.length;

                    // send
                    if (length <= maxLength + 1) {
                        chat.send(text, name);
                        $(this).val("");
                    } else {
                        $(this).val(text.substring(0, maxLength));
                    }
                }
            });
        });

    </script>

</body>
</html>
