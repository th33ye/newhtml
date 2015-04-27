<?php
    session_start();
    require_once('dbconn.php');
    require_once('btnclass.php');

    $rowBettingOn = mysql_num_rows($button->user_page_bet_on($_SESSION['user_arena_id']));
    if($rowBettingOn == 1){
        $rowBettingOn = mysql_fetch_array($button->user_page_bet_on($_SESSION['user_arena_id']));
        if($rowBettingOn['bet_on'] == 1 && $rowBettingOn['arena_id'] == $_SESSION['user_arena_id']){
            echo "<em>Betting is Now Open.</em>";
        }
        if($rowBettingOn['bet_on'] == 0 && $rowBettingOn['arena_id'] == $_SESSION['user_arena_id']){
            echo "<em>Betting is Closed.</em>";
        }
    }
    if($rowBettingOn == 0){
        echo "<em>Betting is Closed.</em>";
    }
    
    
    
    
    //$rowBettingOn = mysql_fetch_array($button->user_page_bet_on($_SESSION['user_arena_id']));

    //if($rowBettingOn['bet_on'] == 1 && $rowBettingOn['arena_id'] == $_SESSION['user_arena_id']){
    //    echo "<em>Betting is Now Open.</em>";
    //}
    //if($rowBettingOn['bet_on'] == 0 && $rowBettingOn['arena_id'] == $_SESSION['user_arena_id']){
    //    echo "<em>Betting is Closed.</em>";
    //}

?>
