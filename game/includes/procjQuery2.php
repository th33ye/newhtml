<?php
    session_start();
    if(isset($_POST['opnGme'])){
        // Arena Id and Admin Id
        $arena_id = $_SESSION['arena_id'];
        $admin_user_id = $_SESSION['admin_user_id'];
        // Insert new game id
        $query = "INSERT INTO games(game_arena_id) VALUES(".$_POST['opnGme'].")";
        $execQuery = mysql_query($query);
        // Gets the active game id for fights insertion reference
        $last_id = mysql_insert_id();
        $_SESSION['game_id'] = $last_id;

        // Make a record in db to mark that a gamme is active
        $queryGameActive = "INSERT INTO oc_game(open_game,arena_id,admin_id) VALUES(1,".$arena_id.",".$admin_user_id.")";
        $execQueryGameActive = mysql_query($queryGameActive);

        // Unset the close game session
        $_SESSION['gameInac'] = array();
    }
    if(isset($_POST['clsGme']) && $_POST['clsGme'] == 1){
        // If close game is clicked, any existing game id in the session will be deleted
        $_SESSION['gameActive'] = array();
        $_SESSION['game_id'] = array();
        // Sets a session for game closed, for the button close to disable
        $_SESSION['gameInac'] = 1;
        if(isset($_SESSION['fight_active'])){
            echo 0;
        }
    }
   
?>
