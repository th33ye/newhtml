<?php
session_start();
require_once('btnclass.php');
// Close Game
if(isset($_POST['clsGme'])){
        // Checks if a game is going on
        $rowGameOn = mysql_num_rows($button->game_on());
        // Checks if a fight is going on
        $rowFightOn = mysql_num_rows($button->fight_on());

        // If a game is off, cannot close it
        if(empty($rowGameOn) || $rowGameOn == 0){
            // Will not close the game, because there's no game going on
            $msg = 0;
        }
        // If a game and a fight is going on, cannot close it
        if(!empty($rowGameOn) && $rowGameOn == 1 && (!empty($rowFightOn) && $rowFightOn == 1)){
            $msg = 1;
        }

        // If a game is on, and fight is off, close it
        
        if(empty($rowFightOn) || $rowFightOn == 0 && (!empty($rowGameOn) && $rowGameOn == 1)){
                $msg = 2;
                $query = "DELETE FROM oc_game";
                $execQuery = mysql_query($query);
        }
        echo $msg;
}





// Logout
if(isset($_POST['logout'])){
        // Checks if a game is going on 
        $rowGameOn = mysql_num_rows($button->game_on());
        if($rowGameOn == 1){
                echo 0;
        }
        // Checks if a fight is going on
        $rowFightOn = mysql_num_rows($button->fight_on());
        if($rowFightOn == 1){
                echo 1;
        }
        if($rowGameOn != 1 && $rowFightOn != 1){
                $_SESSION['admin_user_id'] = array();
                echo 2;
        }
}
?>
