<?php
session_start();
    require_once('../includes/ini_classes.php');
    require_once('../includes/procjQuery2.php');
    
    // Validate if there's Sessions
    $helpers->validate_session($_SESSION['admin_user_id'],"../admin.php");
?>
<html>
    <head>
        <title><?php echo $login->sel_admtype($_SESSION['admin_type_id']); ?> Admin Console</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <!--Online-->
		<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>-->
		<!--Offline-->
		<script type="text/javascript" src="../js/jquery-1.5.1.js"></script>
        <script type="text/javascript">
            //$(window).bind('beforeunload', function(){
            //    return 'You are closing the page \n you may lose some unclosed game if proceeded';
            //});
            $(function(){
				var auto_refresh = setInterval(
				function (){
						   $("td#fightHeadUser").load('../includes/fightheadeuser.php');
						   $("td#betstat").load('../includes/betstat.php');
						   $("div#userInfo h5 span#credit").load('../includes/realtimecredit.php');
				}, 1000);
                
                // Open Game
                $("button#oGme").click(function(){
                    var val = $("#admin_type").val();
                    $(this).attr('disabled', 'disabled');
                    $("button#cGme").removeAttr("disabled");
                    $.post("index.php", {"opnGme": val});
                });

                // Close Game
                 $("button#cGme").click(function(){
                    var clsGme = "clsGme="+1;
                    $.ajax({
                        type:       "post",
                        url:        "../includes/closegame.php",
                        data:       clsGme,
                        cache:      false,
                        success:    function(html){
                            if(html == 0){
                                alert("No game to close.")
                            }
							else if(html == 1){
                                alert("Cannot close the game a fight is going on.")
                            }
                            else if(html == 2){
                                $("button#cGme").attr('disabled', 'disabled');
                                $("button#oGme").removeAttr("disabled");
                            }
                        }
                    });
                });

                // Cannot logout while a game or fight is going on
                 $("input#logout").click(function(){
                    var logout = "logout="+1;
                    $.ajax({
                        type:       "post",
                        url:        "../includes/closegame.php",
                        data:       logout,
                        cache:      false,
                        success:    function(html){
                            if(html == 0){
                                alert("Game is going on, close game to logout.")
                            }
                            else if(html == 1){
                                alert("Fight is going on, finish fight to logout.");
                            }
                            else if(html == 2){
                                location.reload();
                            }
                        }
                    });
                    return false;
                });

                // New Fight
                $("#newFight").click(function(){
                    var newFight = "newFight="+1;
                    $.ajax({
                        type:       "post",
                        url:        "../includes/newfight.php",
                        data:       newFight,
                        cache:      false,
                        success:    function(html){
                            if(html == 0){
                                alert("Open a Game First");
                            }
                            else if(html == 1){
                                $("#newFight").attr('disabled', 'disabled');
                                // Real time update of fight sequence
                                // Get the fight sequence id
                                //$("td#fightId").load('../includes/getfight_id.php');
                                $("td#fightHead").html("<em>Fight is on.</em>");
                            }
                        }
                    });
                });

                // Open Betting
                 $("button#openBet").click(function(){
                    var openBet = "openBet="+1;
                    $.ajax({
                        type:       "post",
                        url:        "../includes/openbet.php",
                        data:       openBet,
                        cache:      false,
                        success:    function(html){
                            if(html == 0){
                                alert("Make a Fight First");
                            }
                            else if(html == 1){
                                $("td#betStat").html("Betting is open.");
                                $("button#openBet").attr('disabled', 'disabled');
                                $("button#closeBet").removeAttr("disabled");
                            }
                        }
                    });
                });

                // Close Betting ??? not done
                 $("button#closeBet").click(function(){
                    var closeBet = "closeBet="+1;
                    $.ajax({
                        type:       "post",
                        url:        "../includes/openbet.php",
                        data:       closeBet,
                        cache:      false,
                        success:    function(html){
                            if(html == 0){
                                alert("Open a Betting First");
                            }
                            else if(html == 1){
                                $("td#betStat").html("Betting is closed.");
                                $("button#closeBet").attr('disabled', 'disabled');
                            }
                        }
                    });
                });


            });
        </script>
    </head>
    <body>
        <div id="container" >
            <div id="header"></div>
            <div id="body">
                <div id="subHeader">
                    <h1>Welcome to <?php echo $login->sel_admtype($_SESSION['arena_id']); ?> Coliseum</h1>
                    <input type="hidden" id="admin_type" value="<?php echo $_SESSION['admin_type_id']; ?>" />
                    <span id="videoBtn">
                        <button id="oGme"<?php
                            $row = mysql_fetch_array($button->game_on());
                            if(!empty($row['open_game']) && $row['open_game'] == 1){
                                echo "disabled";
                            }
                        ?>>Open Game</button>
                        <button id="cGme"<?php
                            $row = mysql_fetch_array($button->game_on());
                            if(empty($row['open_game']) || $row['open_game'] == 0){
                                echo "disabled";
                            }
                        ?>>Close Game</button>
                    </span>
                    <h4>Hi <?php echo $_SESSION['admin_username']; ?></h4>
                    <span id="betBtns">
                        <button>All Bets</button>
                        <form action="<?php $_PHP['SELF'] ;?>" method="POST"><input id="logout" type="submit" name="logout" value="Logout" /></form>
                    </span>
                </div>
                <div id="video"><h1>Video here</h1></div>
                <div id="board">
                    <table border="1" id="odds">
                        <tr><td>Wala</td><td>Odds</td><td>Meron</td></tr>
                        <?php
                            $queryOdds = "SELECT * FROM odds";
                            $execQueryOdds = mysql_query($queryOdds);
                            while($rowOdds = mysql_fetch_array($execQueryOdds, MYSQL_ASSOC)){
                                echo "<tr><td></td><td>".$rowOdds['odd_name']."</td><td></td></tr>";
                            }
                        ?>
                    </table>
                </div>
                <div id="controlButtons">
                    <button id="newFight"<?php
                        $row = mysql_num_rows($button->fight_on());
                        if(!empty($row) && $row == 1){
                            echo "disabled";
                        }
                    ?>>New Fight</button>
                    <button id="openBet"<?php
                        $row = mysql_num_rows($button->betting_on());
                        if(!empty($row) && $row == 1){
                            echo "disabled";
                        }
                    ?>>Open Betting</button>
                    <button id="closeBet"<?php
                        //$row = mysql_num_rows($button->betting_on());
						//if($row == 0){
							$getRow = mysql_fetch_array($button->betting_on());
							if($getRow['bet_off'] == 1){
								echo "disabled";
							}
						//}
                    ?>>Close Betting</button>
                </div>
                <div id="status">
                        <p>Admin Message</p>
                        <textarea id="adminMsg" rows="5" cols="30"></textarea>
                        <form>
                            <select>
                                <option>Wala</option>
                                <option>Meron</option>
                                <option>No Winner</option>
                                <option>Draw</option>
                            </select>
                            <input type="submit" value="Declare Result" />
                        </form>
                    <table border="0">
                        <tr>
                            <td id="head"><h4>Game Details</h4></td>
                            <td id="fightHead">
                                <?php
                                    $row = mysql_fetch_array($button->fight_on());
                                    if(!empty($row['fight_on']) && $row['fight_on'] == 1){
                                        echo "<em>Fight is on.</em>";
                                    }
                                    if(empty($row['fight_on']) || $row['fight_on'] == 0){
                                        echo "<em>No fight yet.</em>";
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Fight Number:</td>
                            <td id="fightId">
                                <?php
                                    /*
                                     * Note:
                                     * fight_sequence_id(fight_id currently) should be delete after a result is declared, 
                                     * therefore displaying the "Waiting.." text
                                     */
                                    if(isset($_SESSION['fight_id'])){
                                        echo $_SESSION['fight_id'];
                                    }
                                    else{
                                        echo "<em>Waiting for a fight.</em>";
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr><td>Fight Result:</td><td>No Winner yet</td></tr>
                        <tr>
                            <td>Betting Status</td>
                            <td id="betStat">
                                <?php
                                    if(isset($_SESSION['openBetActive'])){
                                        echo "<em>Betting is open.</em>";
                                    }
                                    else{
                                        echo "<em>Betting is closed.</em>";
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr><td>No. of Players Online</td><td>3</td></tr>
                        <tr><td>No. of Bets</td><td>3</td></tr>
                    </table>
                </div>
            </div>
            <div id="footer">Footer</div>
        </div>
    </body>
</html>