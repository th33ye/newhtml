<?php
require_once('includes/ini_classes.php');

    $query = "INSERT INTO admin_users(admin_username, admin_password, admin_arena_id)
            VALUES
            ('binan', md5('binan'), 448),
            ('cabuyao', md5('cabuyao'), 449)
    ";
    $execQuery = mysql_query($query);

?>
