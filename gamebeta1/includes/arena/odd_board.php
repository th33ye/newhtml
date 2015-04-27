<?php
    require_once('../../classes/ini_classes.php');
    require_once('../../classes/arena.php');


    $odd_id = $_GET['oddid'];
    $bet_type = $_GET['bettype'];
    $user_type = $_GET['usertype'];
    if($user_type=='player')
    {
        $var_name = 'user_arena_id';
    }
    else
    {
        $var_name = 'admin_arena_id';
    }    
    $fight_id = $arena->fight_get_fight_id($_SESSION[$var_name]);
    echo $arena->bet_calculate($_SESSION[$var_name],$fight_id,$bet_type,$odd_id)
?>