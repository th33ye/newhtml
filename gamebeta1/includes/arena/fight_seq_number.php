<?php

    session_start();
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
    
    $fight_seq = $arena->fight_get_fight_number($_SESSION[$var_name]);
    echo $fight_seq;
?>