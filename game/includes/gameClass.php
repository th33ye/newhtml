<?php
    session_start();
    require_once('helpers.php');
    require_once('dbconn.php');

    class Game{
       
        function place_bet_initial(){
            
        }

    }
    $game = new Game();

    // Arena Id
    //echo $_SESSION['arena_id']."<br />";
    // User Id
    //echo $_SESSION['user_user_id']."<br />";
    // Game Id
    $queryGameId = "SELECT game_id FROM games ORDER BY game_date_created DESC LIMIT 1";
    $execQueryGameId = mysql_query($queryGameId);
    $rowGameId = mysql_fetch_array($execQueryGameId);
    //echo $rowGameId['game_id']."<br />";
    // Fight Id
    $queryFightId = "SELECT fight_id FROM fights  ORDER BY fight_date_created DESC LIMIT 1";
    $execQueryFightId = mysql_query($queryFightId);
    $rowFightId = mysql_fetch_array($execQueryFightId);
    //echo $rowFightId['fight_id']."<br />";
    // Wala or Meron
