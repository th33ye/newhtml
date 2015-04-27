<?php
session_start();
require_once('dbconn.php');
require_once('btnclass.php');
 if(isset($_POST['newFight'])){
       // Arena Id and Admin Id
       $arena_id = $_SESSION['arena_id'];
       $admin_user_id = $_SESSION['admin_user_id'];
        // Checks if a game is active/on
        $row = mysql_fetch_array($button->game_on());

        // If a game is on, make a new fight
        if($row['open_game'] == 1){
            echo $msg = 1;
            // Delete all bets first that belong to this arena
            $queryDelBets = "DELETE FROM bets WHERE bet_arena_id = ".$arena_id."";
            $execQueryDelBets = mysql_query($queryDelBets);
            
            $query = "INSERT INTO fights(fight_game_id) VALUES(".$_SESSION['game_id'].")";
            $execQuery = mysql_query($query);
            $last_id = mysql_insert_id();

            // Make a record in db to mark that a fight is active
            $queryFightActive = "INSERT INTO newfight(fight_on,arena_id,admin_id) VALUES(1,".$arena_id.",".$admin_user_id.")";
            $execQueryFightActive = mysql_query($queryFightActive);
        }
        
        if(empty($row['open_game']) || $row['open_game'] != 1){
            $msg = 0;
            echo $msg;
        }
    }
?>
