<?php
	session_start();
    require_once('../includes/ini_classes.php');
    // Logout
    if(isset($_POST['logout'])){
        $_SESSION['user_user_id'] = array();
    }
    $helpers->validate_session($_SESSION['user_user_id'],"../");
   
?>
<html>
    <head>
        <title>Game Console </title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <!--Online-->
		<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>-->
		<!--Offline-->
		<script type="text/javascript" src="../js/jquery-1.5.1.js"></script>
        <script type="text/javascript">
            $(function(){
                $("input#x").hide();
                var auto_refresh = setInterval(
				function (){
						   $("td#fightHeadUser").load('../includes/fightheadeuser.php');
						   $("td#betstat").load('../includes/userbetstat.php');
						   $("div#userInfo h5 span#credit").load('../includes/realtimecredit.php');
				}, 1000);

                $("input:radio").click(function(){
                    var val = $("[name=wala_meron]:radio:checked").val();
                    //$("p#test").html(val);
                    var wala_meron = "wala_meron="+val;
                    $.ajax({
                        type:       "post",
                        url:        "../includes/userplacebet.php",
                        data:       wala_meron,
                        cache:      false,
						success:    function(html){
                           if(html != ""){
								//$("input:radio").attr('checked ', 'false');
								alert(html);
								
						   }
                        }
                    });
                });
				

                $("select#odds").change(function () {
                    var odds = $("select#odds option:selected").val();
                    var oddsvar = "oddsvar="+odds;
                    $.ajax({
                        type:       "post",
                        url:        "../includes/userplacebet.php",
                        data:       oddsvar,
                        cache:      false,
                        success:    function(html){
                            //$("p#test").html(html);
                            if(html != ""){
                                alert(html);
                            }
                        }
                    });
                });
                
                $("select#bet_amount").change(function () {
                    var bet_amount = $("select#bet_amount option:selected").val();
                    var bet_amountvar = "bet_amountvar="+bet_amount;
                    $.ajax({
                        type:       "post",
                        url:        "../includes/userplacebet.php",
                        data:       bet_amountvar,
                        cache:      false,
                        success:    function(html){
                            //$("p#test").html(html);
                            if(html != ""){
                                alert(html);
                            }
                        }
                    });
                });
				
				// Place final bet
                $("button#place_bet").click(function(){
                    var place_bet = "place_bet="+1;
                    $.ajax({
                        type:       "post",
                        url:        "../includes/userplacebet.php",
                        data:       place_bet,
                        cache:      false,
                        success:    function(html){
                            //$("p#test").html(html);
                            if(html == "true"){
                                $("button#place_bet").attr('disabled', 'disabled');
                                $("select#bet_amount").attr('disabled', 'disabled');
                                $("select#odds").attr('disabled', 'disabled');
                                $("input:radio").attr('disabled', 'disabled');
                            }
                             if(html != "true"){
                                alert(html);
                            }
                        }
                    });
                });
				
				// Cancel bet
                $("button#cancel_bet").click(function(){
                    var cancel_bet = "cancel_bet="+1;
                    $.ajax({
                        type:       "post",
                        url:        "../includes/cancelbet.php",
                        data:       cancel_bet,
                        cache:      false,
                        success:    function(html){
                           if(html == "true"){
                                $("button#place_bet").removeAttr("disabled");
                                $("select#bet_amount").removeAttr("disabled");
                                $("select#odds").removeAttr("disabled");
                                $("input:radio").removeAttr("disabled");
                           }
                           if(html != "true"){
                                alert(html);
                           }
                        }
                    });
                });

            });
        </script>
		

    </head>
    <body><p id="test1"></p><p id="test2"></p>
        <div id="container" >
            <div id="header"></div>
            <div id="body">
                <div id="subHeader">
                    <h1>Welcome to <?php
                        $rowArenaName = mysql_fetch_array($login->arena_name($_SESSION['user_arena_id']));
                        echo $rowArenaName['arena_name'];
                    ?> Coliseum</h1>
                    <span id="betBtns">
                        <button>All Bets</button><button>My Bets</button>
                        <form action="<?php $_PHP['SELF'] ;?>" method="POST"><input type="submit" name="logout" value="Logout" /></form>
                    </span>
                </div>
                <div id="video">
<!--
/**
 * Copy and paste this HTML snippet between the <body></body> tags of your webpage
 * to embed the video player directly into your page.
 * You may alter the size of the video by changing the playerWidth or playerHeight.
 */
-->
<div id="bg_player_location">
<a href="http://www.adobe.com/go/getflashplayer">
<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
</a>
</div>
<script type="text/javascript" src="http://bitcast-b.bitgravity.com/player/6/functions.js"></script>
<script type="text/javascript">
var flashvars = {};
flashvars.File = "http://bglive-a.bitgravity.com/abenmach/secure/live/atc?e=0%26h=9702450811bd5b3f92842ab054a7f1ee";
flashvars.Mode = "ondemand";
flashvars.AutoPlay = "true";
flashvars.BufferTime = "1.5";
flashvars.VideoFit = "stretch";
flashvars.DefaultRatio = "1.777778";
flashvars.LogoPosition = "topleft";
flashvars.ColorBase = "#877C21";
flashvars.ColorControl = "#333333";
flashvars.ColorHighlight = "#F0F99D";
flashvars.ColorFeature = "#EDEBD5";
var params = {};
params.allowFullScreen = "true";
params.allowScriptAccess = "always";
var attributes = {};
attributes.id = "bitgravity_player_6";
swfobject.embedSWF(stablerelease, "bg_player_location", "640", "500", "9.0.115", "http://bitcast-b.bitgravity.com/player/expressInstall.swf", flashvars, params, attributes);
</script></div>
                <div id="board">
                    <table border="1">
                        <tr><td>Wala</td><td>Odds</td><td>Meron</td></tr>
                        <?php
                            $queryOdds = "SELECT * FROM odds";
                            $execQueryOdds = mysql_query($queryOdds);
                            while($rowOdds = mysql_fetch_array($execQueryOdds, MYSQL_ASSOC)){
                                echo "<tr><td class=\"wala\" id=\"".$rowOdds['odd_id']."\">";
								// Wala bets here
								if($rowOdds['odd_id'] == 18){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td#18, td.wala").load('../includes/board/board18wala.php');
										}, 1000);
									</script>
									<?php
								}
								if($rowOdds['odd_id'] == 19){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td#19").load('../includes/board/board19wala.php');
										}, 1000);
									</script>
									<?php
								}
								if($rowOdds['odd_id'] == 20){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td#20").load('../includes/board/board20wala.php');
										}, 1000);
									</script>
									<?php
								}
								if($rowOdds['odd_id'] == 21){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td#21").load('../includes/board/board21wala.php');
										}, 1000);
									</script>
									<?php
								}
								if($rowOdds['odd_id'] == 22){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td#22").load('../includes/board/board22wala.php');
										}, 1000);
									</script>
									<?php
								}
								if($rowOdds['odd_id'] == 23){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td#23").load('../includes/board/board23wala.php');
										}, 1000);
									</script>
									<?php
								}
								if($rowOdds['odd_id'] == 24){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td#24").load('../includes/board/board24wala.php');
										}, 1000);
									</script>
									<?php
								}
								if($rowOdds['odd_id'] == 25){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td#25").load('../includes/board/board25wala.php');
										}, 1000);
									</script>
									<?php
								}
								if($rowOdds['odd_id'] == 26){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td#26").load('../includes/board/board26wala.php');
										}, 1000);
									</script>
									<?php
								}
								if($rowOdds['odd_id'] == 27){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td#27").load('../includes/board/board27wala.php');
										}, 1000);
									</script>
									<?php
								}
								if($rowOdds['odd_id'] == 28){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td#28").load('../includes/board/board28wala.php');
										}, 1000);
									</script>
									<?php
								}
								echo "</td><td>".$rowOdds['odd_name']."</td>";
								echo "<td class=\"".$rowOdds['odd_id']."\" id=\"meron\">";
								// Meron bets here
								if($rowOdds['odd_id'] == 18){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td.18").load('../includes/board/board18meron.php');
										}, 1000);
									</script>
									<?php
								}
								if($rowOdds['odd_id'] == 19){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td.19").load('../includes/board/board19meron.php');
										}, 1000);
									</script>
									<?php
								}
								if($rowOdds['odd_id'] == 20){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td.20").load('../includes/board/board20meron.php');
										}, 1000);
									</script>
									<?php
								}
								if($rowOdds['odd_id'] == 21){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td.21").load('../includes/board/board21meron.php');
										}, 1000);
									</script>
									<?php
								}
								if($rowOdds['odd_id'] == 22){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td.22").load('../includes/board/board22meron.php');
										}, 1000);
									</script>
									<?php
								}
								if($rowOdds['odd_id'] == 23){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td.23").load('../includes/board/board23meron.php');
										}, 1000);
									</script>
									<?php
								}
								if($rowOdds['odd_id'] == 24){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td.24").load('../includes/board/board24meron.php');
										}, 1000);
									</script>
									<?php
								}
								if($rowOdds['odd_id'] == 25){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td.25").load('../includes/board/board25meron.php');
										}, 1000);
									</script>
									<?php
								}
								if($rowOdds['odd_id'] == 26){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td.26").load('../includes/board/board26meron.php');
										}, 1000);
									</script>
									<?php
								}
								if($rowOdds['odd_id'] == 27){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td.27").load('../includes/board/board27meron.php');
										}, 1000);
									</script>
									<?php
								}
								if($rowOdds['odd_id'] == 28){
									?>
									<script type="text/javascript">
										var auto_refresh = setInterval(
										function (){
												   $("td.28").load('../includes/board/board28meron.php');
										}, 1000);
									</script>
									<?php
								}
								echo "</td></tr>";
                            }
                        ?>
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
                                        <td id="leftPlaceBet"><button>Wala</button><input type="radio" value="wala" name="wala_meron" id="wala"
										<?php $button->check_arena_bets($_SESSION['arena_id']); ?>/></td>
                                        <td id="rightPlaceBet"><button>Meron</button><input type="radio" value="meron" name="wala_meron" id="meron"
										<?php $button->check_arena_bets($_SESSION['arena_id']); ?>/></td>
                                    </span>
                                </tr>
                                <tr><td id="leftPlaceBet"><h4>Odds</h4></td></tr>
                                <tr>
                                    <td id="leftPlaceBet"><select id="odds"
										<?php $button->check_arena_bets($_SESSION['arena_id']); ?>>
                                            <option value="" selected>Odds</option>
                                        <?php
                                            $queryOdds = "SELECT * FROM odds";
                                            $execQueryOdds = mysql_query($queryOdds);
                                            while($rowOdds = mysql_fetch_array($execQueryOdds, MYSQL_ASSOC)){
                                                echo "<option value=\"".$rowOdds['odd_id']."\">".$rowOdds['odd_name']."</option>";
                                            }
                                        ?>
                                    </select></td>
                                    <td id="rightPlaceBet"><button id="place_bet"
										<?php $button->check_arena_bets($_SESSION['arena_id']); ?>>Place Bet</button></td>
                                </tr>
                                <tr><td id="leftPlaceBet"><h4>Bet Amount</h4></td></tr>
                                <tr>
                                    <td id="leftPlaceBet"><select id="bet_amount"
										<?php $button->check_arena_bets($_SESSION['arena_id']); ?>>
                                            <option value="" selected>Amount</option>
                                        <?php
                                            $num = 0;
                                            while($num < 1000){
                                                $num = $num + 100;
                                                echo "<option value=\"".$num."\">".$num."</option>";
                                            }
                                        ?>
                                        </select></td>
                                        <td id="rightPlaceBet"><button id="cancel_bet">Cancel</button></td>
                                </tr>
                            </table>
                        </div>
                       
                            
                       
                    <table border="0" id="gmeStatUser">
                        <tr><td id="head"><h4>Game Details</h4></td><td id="fightHeadUser"></td></tr>
                        <tr><td>Fight Number:</td><td>1</td></tr>
                        <tr><td>Fight Result:</td><td>Wala Wins</td></tr>
                        <tr><td>Betting Status</td><td id="betstat"></td></tr>
                        <tr><td>No. of Players Online</td><td>3</td></tr>
                        <tr><td>No. of Bets</td><td>3</td></tr>
                    </table>
                </div>
            </div>
            <div id="footer">Footer</div>
        </div>
    </body>
</html>
