<?php
    
    session_start();
    require_once('../dbconn.php');
    require_once('../btnclass.php');
    // User Arena Id
    $user_arena_id = $_SESSION['user_arena_id'];
    $user_user_id = $_SESSION['user_user_id'];
    
    // Check if current user has a bets,
            //$queryCheckBet = "SELECT bet_id, bet_fight_id FROM bets WHERE  bet_arena_id = ".$user_arena_id."";
            //$execQueryCheckBet = mysql_query($queryCheckBet);
            //$numRowCheckBet = mysql_num_rows($execQueryCheckBet);
            //if($numRowCheckBet == 1){
                //$numRowCheckBet = mysql_fetch_array($execQueryCheckBet);
                $queryCheckBetReport = "SELECT bet_amount FROM betsreport WHERE
                bet_arena_id =  ".$user_arena_id." AND
                wala_meron = 'wala' AND
                bet_odd_id = 20
                ";
                //bet_fight_id = ".$numRowCheckBet['bet_fight_id']." AND
                $execQueryCheckBetReport = mysql_query($queryCheckBetReport);
                $count = mysql_num_rows($execQueryCheckBetReport);
                if($count > 0){
                    while($rowGetBet = mysql_fetch_array($execQueryCheckBetReport)){
                        $total = $total + $rowGetBet['bet_amount'];
                    }
                    echo "Php ".$total;    
                }
                else{
                    echo "Php 0.00";
                }
    
?>