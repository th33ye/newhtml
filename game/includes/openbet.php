<?php
    session_start();
    require_once('dbconn.php');
    require_once('btnclass.php');

    // Open Betting
    if(isset($_POST['openBet'])){
        // Arena Id and Admin Id
        $arena_id = $_SESSION['arena_id'];
        $admin_user_id = $_SESSION['admin_user_id'];
       
        // Checks if there's a fight going on
        $rowFightOn = mysql_num_rows($button->fight_on());
        
        if(!empty($rowFightOn) && $rowFightOn == 1){
            $msg = 1;
            // Make a record in db to mark that betting is active and it is now open
            $query = "INSERT INTO oc_bet(bet_on,arena_id,admin_id) VALUES(1,".$arena_id.",".$admin_user_id.")";
            $execQuery = mysql_query($query);
        }

        if(empty($rowFightOn) || $rowFightOn == 0){
            $msg = 0;
        }
        echo $msg;
    }

    // Close Betting
    if(isset($_POST['closeBet'])){
        // Arena Id and Admin Id
        $arena_id = $_SESSION['arena_id'];
        $admin_user_id = $_SESSION['admin_user_id'];
        // Checks if betting is on or open
        $rowBettingOn = mysql_num_rows($button->betting_on());
        
        if($rowBettingOn == 1){
            $msg = 1;
            $query = "UPDATE oc_bet SET bet_on = 0, bet_off = 1 WHERE arena_id = ".$arena_id." AND admin_id = ".$admin_user_id."";
            $execQuery = mysql_query($query);
        }
        if(empty($rowBettingOn) || $rowBettingOn == 0){
            $msg = 0;
        }
        echo $msg;
    }

?>
