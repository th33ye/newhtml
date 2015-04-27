<?php

    session_start();
    require_once('helpers.php');
    require_once('dbconn.php');
    require_once('btnclass.php');

        // Amin Arena Id
        $arena_id = $_SESSION['arena_id'];
        // User Arena Id
        $user_arena_id = $_SESSION['user_arena_id'];
        // User Id
        $user_user_id = $_SESSION['user_user_id'];
        // Game Id
        $queryGameId = "SELECT game_id FROM games ORDER BY game_date_created DESC LIMIT 1";
        $execQueryGameId = mysql_query($queryGameId);
        $rowGameId = mysql_fetch_array($execQueryGameId);

        // Fight Id
        $queryFightId = "SELECT fight_id FROM fights  ORDER BY fight_date_created DESC LIMIT 1";
        $execQueryFightId = mysql_query($queryFightId);
        $rowFightId = mysql_fetch_array($execQueryFightId);
        
        // Check if bets are on
        $checkBetOnOff = mysql_fetch_array($button->user_page_bet_on($user_arena_id));
        
        // Wala or Meron
        $wala_meron = $_POST['wala_meron'];
    // Choose a cock
    if(isset($_POST['wala_meron'])){
        /*
         *  Check first if there's an existing user_id bet,
         *  1.) Check if bet is open for this arena
         *  2.) If there's none, insert new record
         *  3.) If there's an existing record, update it
         */
        
        // 1.) Check if bet is open for this arena
        if($checkBetOnOff['bet_on'] == 1 && $checkBetOnOff['arena_id'] == $user_arena_id){
            $queryCheckBet = "SELECT * FROM bets WHERE bet_user_id = ".$user_user_id."";
            $execQueryCheckBet = mysql_query($queryCheckBet);
            $numRowCheckBet = mysql_num_rows($execQueryCheckBet);
            // 2.) If there's none, insert new record
            if($numRowCheckBet == 0){
                // Insert initial bet to database
                $queryInitialbet = "INSERT INTO bets(bet_arena_id, bet_user_id, bet_game_id, bet_fight_id, wala_meron)
                                    VALUES
                                    (".$user_arena_id.", ".$user_user_id.", ".$rowGameId['game_id'].", ".$rowFightId['fight_id'].", '".$wala_meron."')
                ";
                $execQueryInitialBet = mysql_query($queryInitialbet);
                //echo $numRowCheckBet;
            }
            // 3.) If there's an existing record, update it
            if($numRowCheckBet == 1){
                // Update the initial bet
                $queryUpdateBet = "UPDATE bets SET wala_meron = '".$wala_meron."', bet_date_updated = CURRENT_TIMESTAMP WHERE bet_user_id = ".$user_user_id."";
                $execQueryUpdateBet = mysql_query($queryUpdateBet);
                //echo $numRowCheckBet;
            }    
        }
        if($checkBetOnOff['bet_on'] == 0){
            echo "You cannot bet, Betting is closed.";
        }
    }
    // Choose Odds
    if(isset($_POST['oddsvar']) && $_POST['oddsvar'] != ""){
        if($checkBetOnOff['bet_on'] == 1 && $checkBetOnOff['arena_id'] == $user_arena_id){
            $odds = $_POST['oddsvar'];
            $queryCheckBet = "SELECT * FROM bets WHERE bet_user_id = ".$user_user_id."";
            $execQueryCheckBet = mysql_query($queryCheckBet);
            $numRowCheckBet = mysql_num_rows($execQueryCheckBet);
            if($numRowCheckBet == 0){
                echo "Choose a Cock first: 'Wala' o 'Meron'";
            }
            if($numRowCheckBet == 1){
                // Update odds_id
                $queryUpdateOddsId = "UPDATE bets SET bet_odd_id = ".$odds.", bet_date_updated = CURRENT_TIMESTAMP WHERE bet_user_id = ".$user_user_id."";
                $execQueryUpdateOddsId = mysql_query($queryUpdateOddsId);
            }
        }
        if($checkBetOnOff['bet_on'] == 0){
            echo "Betting is closed.";
        }
    }
    //Choose amount
    if(isset($_POST['bet_amountvar']) && $_POST['bet_amountvar'] != ""){
        if($checkBetOnOff['bet_on'] == 1 && $checkBetOnOff['arena_id'] == $user_arena_id){
            $bet_amount = $_POST['bet_amountvar'];
            $queryCheckOddsId = "SELECT bet_odd_id FROM bets WHERE bet_user_id = ".$user_user_id." AND bet_arena_id = ".$user_arena_id."";
            $execQueryCheckOddsId = mysql_query($queryCheckOddsId);
            $numRowCheckOddsId = mysql_num_rows($execQueryCheckOddsId);
            if($numRowCheckOddsId == 0){
                echo "Choose an Odds first";
            }
            if($numRowCheckOddsId == 1){
                $numRowCheckOddsId = mysql_fetch_array($execQueryCheckOddsId);
                if($numRowCheckOddsId['bet_odd_id'] != 0){
                    // Check if credit is enough
                    // Return user credit
                    $queryCredit = "SELECT * FROM runningcredits WHERE user_id = ".$_SESSION['user_user_id']." ORDER BY date_created DESC LIMIT 1";
                    $execQueryCredit = mysql_query($queryCredit);
                    $rowCredit = mysql_fetch_array($execQueryCredit, MYSQL_ASSOC);
                    $final_credit = round($rowCredit['credits']);
                    //$final_credit = 100;
                    if($bet_amount > $final_credit){
                        echo "Your credit is not sufficient";
                    }
                    if($bet_amount <= $final_credit){
                        // Update bet_amount
                        $queryUpdateBetAmount = "UPDATE bets SET bet_amount='".$bet_amount."', bet_date_updated = CURRENT_TIMESTAMP WHERE bet_user_id = ".$user_user_id."";
                        $execQueryUpdateBetAmount = mysql_query($queryUpdateBetAmount);
                    }
                }
                if($numRowCheckOddsId['bet_odd_id'] == 0){
                    echo "Choose an Odds first";
                }
            }
        }
        if($checkBetOnOff['bet_on'] == 0){
            echo "Betting is closed.";
        }
    }
    // Place final bet
    if(isset($_POST['place_bet']) && $_POST['place_bet'] == 1){
        // 1. Check if the user has already made a bet
        $queryCheckBet = "SELECT * FROM bets WHERE bet_user_id = ".$user_user_id." AND bet_arena_id = ".$user_arena_id." ";
        $execQueryCheckBet = mysql_query($queryCheckBet);
        $numRowCheckBet = mysql_num_rows($execQueryCheckBet);
        if($numRowCheckBet == 1 && ($numRowCheckBet != 0 || $numRowCheckBet != "")){
            // 2. Check if the user has chosen an odd
            $queryCheckOddsId = "SELECT bet_odd_id FROM bets WHERE bet_user_id = ".$user_user_id."";
            $execQueryCheckOddsId = mysql_query($queryCheckOddsId);
            $numRowCheckOddsId = mysql_fetch_array($execQueryCheckOddsId);
            if($numRowCheckOddsId['bet_odd_id'] != 0){
                // 3. Check if the user has chosen any amount
                $queryBetAmount = "SELECT bet_amount FROM bets WHERE bet_user_id = ".$_SESSION['user_user_id']."";
                $execQueryBetAmount = mysql_query($queryBetAmount);
                $rowBetAmount = mysql_fetch_array($execQueryBetAmount);
                if($rowBetAmount['bet_amount'] != 0){
                    // Transfer bet records to betsreport and .....
                    $queryTransferBet = "INSERT INTO betsreport
                    (bet_id,bet_arena_id,bet_user_id,bet_game_id,bet_fight_id,wala_meron,bet_odd_id,bet_amount,bet_date_created,bet_date_updated)
                    SELECT
                    bet_id,bet_arena_id,bet_user_id,bet_game_id,bet_fight_id,wala_meron,bet_odd_id,bet_amount,bet_date_created,bet_date_updated
                    FROM bets WHERE bet_user_id = ".$user_user_id."";
                    $execQueryTransferBet = mysql_query($queryTransferBet);
                    // Delete records from bet table
                    //$queryDelBet = "DELETE FROM bets WHERE bet_user_id = ".$user_user_id."";
                    //$execQueryDelBet = mysql_query($queryDelBet);
                    $_SESSION['board_on'] = "1";
                    echo "true";
                }
                if($rowBetAmount['bet_amount'] == 0){
                    echo "You haven't chosen any amount yet.";
                }
            }
            if($numRowCheckOddsId['bet_odd_id'] == 0){
                echo "You haven't chosen any odd yet.";
            }
        }
        else{
            echo "You haven't chosen any bet yet, choose 'Wala' o 'Meron'";
        }
    }

?>
