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
    
    $status = $arena->betting_is_open($_SESSION[$var_name]);
    if($status==true)
    {
        echo "Betting is now OPEN";
    }
    else
    {
        echo "Betting is CLOSED";
    }