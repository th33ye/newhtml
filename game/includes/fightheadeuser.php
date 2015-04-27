<?php
        session_start();
        require_once('dbconn.php');
        require_once('btnclass.php');

        // Checks if there's a fight going on in my selected arena
        $rowFightOn = mysql_num_rows($button->user_page_fight_on($_SESSION['user_arena_id']));
        
        if(!empty($rowFightOn) && $rowFightOn == 1){
            echo "<em>Fight is on.</em>";
        }

        if(empty($rowFightOn) || $rowFightOn == 0){
            echo "<em>No fight yet.</em>";
        }
?>
