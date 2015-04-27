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

    <!-- include flowplayer-3.2.11.min.js -->
    <script type="text/javascript" src="flowplayer/flowplayer-3.2.6.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://static.flowplayer.org/tools/css/standalone.css"/>
    <link rel="stylesheet" type="text/css" href="http://static.flowplayer.org/tools/css/overlay-basic.css"/>

    <script type="text/javascript">
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
           setTimeout("trackLogin('<?php echo $_SESSION['user_user_id']; ?>')", 5000);
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
           setTimeout("popCredit('<?php echo $_SESSION['user_user_id']; ?>')", 5000);
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
                 else if (data.pop == '0') {
                    $("#blocking").overlay().close();
                 }
              }
           });
           setTimeout("popBlock('<?php echo $_SESSION['user_user_id']; ?>')", 5000);
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
            setTimeout('refreshFightResults()', 5000);
        }

        function ProcessRequest()
        {
            //LoadVideoConsole();
            //displayVideo();
            //popCredit('<?php echo $_SESSION['user_user_id']; ?>');
            LoadBettingConsole();
            LoadMyBetsTable();
            LoadOddIds();
            trackLogin('<?php echo $_SESSION['user_user_id']; ?>');
            popBlock('<?php echo $_SESSION['user_user_id']; ?>');
            refreshFightResults();
            setInterval('chat.update()', 7000);
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

    <div id="game_container">
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
            <!-- running result -->
            <div id="running-result"></div>
            <!-- video and chat container -->
            <div id="video_chat_container">
                <div id="bg_player_container">
                    <a href="http://pseudo01.hddn.com/vod/demo.flowplayervod/flowplayer-700.flv"
                       style="display:block;width:640px;height:360px"
                       id="player">
                    </a>
                </div>
				<div id="div-overlay"><?php //echo strtoupper($_SESSION['user_username']); ?></div>
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
                    swfobject.embedSWF(stablerelease, "bg_player_container", "660", "360", "9.0.115", "http://bitcast-b.bitgravity.com/player/expressInstall.swf", flashvars, params, attributes);
                </script>

                <div id="container">
                    <div id="page-wrap">
                        <div id="chat-wrap"><div id="chat-area"></div></div>
                        <form id="send-message-area">
                            <p>Your message: </p>
                            <textarea id="sendie" maxlength = '100' ></textarea>
                        </form>
                    </div>
                </div>
            </div>
            <!-- bet container -->
            <div id="bet_container">
                <div id="total_bet">
                    <h2><strong>TOTAL GAME BET</strong></h2>
                    <div id="gameConsole"></div>
                </div>
                <div id="player_bet">
                    <h2><strong>MY BET - <?php echo strtoupper($_SESSION['user_username']); ?></strong></h2>
                    <div id="bettingTable"></div>
                </div>
            </div>

            <input name="signalFlag" type="hidden" id="signalFlag" value="test"/>
            <input type="hidden" name="CurrentTime" id="CurrentTime" />

        </div>
    </div>

    <!-- window for overlaying -->
    <div id="blocking" style="display: none">
        <div>
            <img src="images/blocking.gif" height="650" />
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
