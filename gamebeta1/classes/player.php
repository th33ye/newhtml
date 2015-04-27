<?php

require_once('helper.php');

class player
{
    function get_player_info($player_id,$field_to_get)
    {
        $query = "SELECT {$field_to_get} FROM users WHERE user_id={$player_id} LIMIT 1";
        $result = mysql_query($query);
        if(!empty($result))
        {
            if(mysql_num_rows($result)==1)
            {
                $row = mysql_fetch_assoc($result);
                return $row[$field_to_get];
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;            
        }
    }
}

$player = new player();