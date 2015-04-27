<?php
/* 
 * jQuery AJAX receiver
 * 
 */
    session_start();
    
    $query = "SELECT * FROM co_vid";
    $execQuery = mysql_query($query);
    $closeVideo = mysql_num_rows($execQuery);
    echo "<input id=\"x\" type=\"text\" value=\"".$closeVideo."\" />";

?>