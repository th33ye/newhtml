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
    
    echo $arena->bet_count($_SESSION[$var_name]);
?>