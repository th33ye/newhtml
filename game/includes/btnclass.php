<?php
    session_start();
    require_once('dbconn.php');
    
    class Button{
    
        // Checks if there's a game going on
        function game_on(){
            // Arena Id and Admin Id
            $arena_id = $_SESSION['arena_id'];
            $admin_user_id = $_SESSION['admin_user_id'];
            
            $query = "SELECT open_game FROM oc_game WHERE admin_id = ".$admin_user_id." AND arena_id = ".$arena_id."";
            $execQuery = mysql_query($query);
            return $execQuery;
        }

        // Checks if a fight is going on
        function fight_on(){
            // Arena Id and Admin Id
            $arena_id = $_SESSION['arena_id'];
            $admin_user_id = $_SESSION['admin_user_id'];
            
            $query = "SELECT fight_on FROM newfight WHERE admin_id = ".$admin_user_id." AND arena_id = ".$arena_id."";
            $execQuery = mysql_query($query);
            return $execQuery;
        }
        
        function user_page_fight_on($user_arena_id){   
            $query = "SELECT fight_on FROM newfight WHERE arena_id = ".$user_arena_id."";
            $execQuery = mysql_query($query);
            return $execQuery;
        }
        
        // Checks if a bet is on or open
        function betting_on(){
             // Arena Id and Admin Id
            $arena_id = $_SESSION['arena_id'];
            $admin_user_id = $_SESSION['admin_user_id'];
            
            $query = "SELECT bet_on, bet_off FROM oc_bet WHERE admin_id = ".$admin_user_id." AND arena_id = ".$arena_id."";
            $execQuery = mysql_query($query);
            return $execQuery;
        }
        
         function user_page_bet_on($user_arena_id){   
            $query = "SELECT bet_on, arena_id FROM oc_bet WHERE arena_id = ".$user_arena_id."";
            $execQuery = mysql_query($query);
            return $execQuery;
        }
        
         // Disable Place Bet
        function disablePlaceBet(){
            // User Arena Id
            $user_arena_id = $_SESSION['user_arena_id'];
            $user_user_id = $_SESSION['user_user_id'];
            
            // Check if current user has a bets,
            $queryCheckBet = "SELECT bet_id, bet_fight_id FROM bets WHERE bet_user_id = ".$user_user_id." AND bet_arena_id = ".$user_arena_id."";
            $execQueryCheckBet = mysql_query($queryCheckBet);
            $numRowCheckBet = mysql_num_rows($execQueryCheckBet);
            if($numRowCheckBet == 1){
                $numRowCheckBet = mysql_fetch_array($execQueryCheckBet);

                // Check if the curent user has a bet report
                $queryCheckBetReport = "SELECT * FROM betsreport WHERE
                    bet_id = ".$numRowCheckBet['bet_id']." AND bet_fight_id = ".$numRowCheckBet['bet_fight_id']." AND bet_arena_id =  ".$user_arena_id."";
                $execQueryCheckBetReport = mysql_query($queryCheckBetReport);
                return $execQueryCheckBetReport;    
            }
        }
        
        function check_bets(){
            // User Arena Id
            $user_arena_id = $_SESSION['user_arena_id'];
            // User Id
            $user_user_id = $_SESSION['user_user_id'];
            // Bet the  bets_id of current user
            $queryCheckBet = "SELECT * FROM bets WHERE bet_user_id = ".$user_user_id." AND bet_arena_id = ".$user_arena_id."";
            $execQueryCheckBet = mysql_query($queryCheckBet);
            return $execQueryCheckBet;
        }
        
        function check_arena_bets($arena_id){
            // User Arena Id
            $user_arena_id = $_SESSION['user_arena_id'];
            // User Id
            $user_user_id = $_SESSION['user_user_id'];
            $queryGetBets = mysql_fetch_array($this->check_bets());
            if($queryGetBets['bet_arena_id'] == $user_arena_id){
                $countRowBets = mysql_num_rows($this->check_bets());
                if($countRowBets == 1){
                    $countRow = mysql_num_rows($this->disablePlaceBet());
                    if($countRow == 1){
                        echo "disabled";
                    }
                }
            }
        }
        
    }
    $button = new Button();

?>
