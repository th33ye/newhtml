<?php
require_once('../../classes/ini_classes.php');
require_once('../../classes/arena.php');

$online_users = $arena->get_online_users($_SESSION['admin_arena_id']);
if($online_users == false)
{
    echo '<i>None</i>';
}
else
{
    echo $online_users;
}
?>