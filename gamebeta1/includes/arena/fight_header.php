<?php
    require_once('../../classes/ini_classes.php');
    require_once('../../classes/arena.php');
    
    $type= $helper->sanitize($_GET['type']);
    
    if($type=='player')
    {
        $var_name = 'user_arena_id';
    }
    else
    {
        $var_name = 'admin_arena_id';
    }
    
    $game_ongoing = $arena->game_is_running($_SESSION[$var_name]);
    if($game_ongoing!==false)
    {
        echo "Game Is Open";
    }
    else
    {
        echo "Game Is Closed";
    }
?>
