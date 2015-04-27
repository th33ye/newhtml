<?php
require_once('../../classes/ini_classes.php');
require_once('../../classes/arena.php');

echo $arena->get_online_users_count($_SESSION['admin_arena_id']);
?>