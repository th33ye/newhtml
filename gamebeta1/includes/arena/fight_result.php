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
    
    $result = $arena->fight_get_fight_result($_SESSION[$var_name]);
    if($result==0)
    {
        echo "-";
    }
    else if($result==1)
    {
        echo "WALA wins";
    }
    else if($result==2)
    {
        echo "MERON wins";
    }
    else
    {
        echo "DRAW";
    }
?>