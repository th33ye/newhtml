<?php

    session_start();
    require_once('helpers.php');
    require_once('dbconn.php');
    require_once('btnclass.php');
    $user_user_id = $_SESSION['user_user_id'];
    // User Arena Id
    $user_arena_id = $_SESSION['user_arena_id'];
    if(isset($_POST['cancel_bet']) && $_POST['cancel_bet'] == 1){
        $countRowBets = mysql_num_rows($button->check_bets());
        if($countRowBets == 1){
            $countRowBetsreports = mysql_num_rows($button->disablePlaceBet());
            if($countRowBetsreports == 1){
                // Delete bet reports
                $getRowBets = mysql_fetch_array($button->check_bets());
                $queryDeleteBetsReports = "DELETE FROM betsreport WHERE
                bet_id = ".$getRowBets['bet_id']." AND bet_fight_id = ".$getRowBets['bet_fight_id']." AND bet_arena_id =  ".$user_arena_id."";
                $execQueryDeleteBetsReports = mysql_query($queryDeleteBetsReports);
                if($execQueryDeleteBetsReports){
                    $queryDeleteBets = "DELETE FROM bets WHERE bet_user_id = ".$user_user_id." AND bet_arena_id = ".$user_arena_id."";
                    $execqueryDeleteBets = mysql_query($queryDeleteBets);
                    echo "true";    
                }
            }
            else{
                echo "There's still nothing to cancel, Place a Bet first";
            }
        }
        else{
            echo "There's still nothing to cancel, Place a Bet first";
        }
    }
?>
