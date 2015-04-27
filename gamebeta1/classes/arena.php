<?php
/*
 * All arena and user related function are here
 */
require_once('helper.php');
require_once('player.php');

class arena
{
    
    function bet_count($arena_id)
    {
        $fight_id = $this->fight_get_fight_id($arena_id);
        if($fight_id !==false)
        {
            $query = "SELECT COUNT(*) AS 'totalCount' FROM betlist WHERE bet_arena_id={$arena_id} AND bet_fight_id={$fight_id}";
            $result = mysql_query($query);
            if(!empty($result))
            {
                $row = mysql_fetch_assoc($result);
                return $row['totalCount'];
            }
            else
            {
                return 0;
            }
        }
        else
        {
            return 0;
        }
    }
    
    /*
     * @ taya mo na!!!
     */
    function bet_place($arena_id,$user_id,$fight_id,$bet_odd_id,$bet_type,$bet_amount)
    {        
        $query = "INSERT INTO betlist(bet_arena_id,bet_user_id,bet_fight_id,bet_odd_id,bet_type,bet_amount,bet_date_created)
                  VALUES({$arena_id},{$user_id},{$fight_id},{$bet_odd_id},'{$bet_type}',{$bet_amount},NOW())";
        return mysql_query($query) or die(mysql_error());
    }
    
    function bet_placed($user_id,$fight_id)
    {
        $query = "SELECT * FROM betlist WHERE bet_user_id={$user_id} AND bet_fight_id={$bet_fight_id}";
        $result = mysql_query($query);
        if(!empty($result))
        {
            if(mysql_num_rows($result)==1)
            {
                return true;
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
    
    function bet_calculate($arena_id,$fight_id,$bet_type,$odd_id)
    {
        $query = "SELECT IFNULL(SUM(bet_amount),0) as BETAMOUNT
                  FROM betlist 
                  WHERE bet_arena_id={$arena_id} AND 
                        bet_fight_id={$fight_id} AND
                        bet_type='{$bet_type}' AND
                        bet_odd_id={$odd_id} LIMIT 1";
        $result = mysql_query($query);
        if(!empty($result))
        {
            $row = mysql_fetch_assoc($result);
            return $row['BETAMOUNT'];
        }
        else
        {
            return 0;
        }
    }
    
    function betting_is_open($arena_id)
    {
        $game_id = $this->game_is_running($arena_id);
        if($game_id !== false)
        {
            $query = "SELECT * FROM fights WHERE fight_game_id={$game_id} AND fight_status=1 LIMIT 1";
            $result = mysql_query($query);
            if(!empty($result))
            {
                if(mysql_num_rows($result)==1)
                {
                    return true;
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
    
    function betting_open($arena_id)
    {
        $game_id = $this->game_is_running($arena_id);
        if($game_id !== false)
        {
            $fight_sequence_no = $this->fight_get_fight_number($arena_id);
            $query = "UPDATE fights 
                      SET fight_status=1 
                      WHERE fight_game_id={$game_id} AND fight_sequence_no={$fight_sequence_no}";
            mysql_query($query);
        }
    }
    
    function betting_close($arena_id)
    {
        $game_id = $this->game_is_running($arena_id);
        if($game_id !== false)
        {
            $fight_sequence_no = $this->fight_get_fight_number($arena_id);
            $query = "UPDATE fights 
                      SET fight_status=2 
                      WHERE fight_game_id={$game_id} AND fight_sequence_no={$fight_sequence_no}";
            mysql_query($query);
        }
    }
    
    function open_arena($arena_id)
    {
        if($this->check_arena_status($arena_id)==0)
        {
            $query = "UPDATE arena SET arena_status=1 WHERE arena_id={$arena_id}";
            mysql_query($query);
        }
    }
    
    function close_arena($arena_id)
    {
        $query = "UPDATE arena SET arena_status=0 WHERE arena_id={$arena_id}";
        mysql_query($query);
    }
    
    function check_arena_status($arena_id)
    {
        $query = "SELECT arena_status FROM arena WHERE arena_id={$arena_id} LIMIT 1";
        $result = mysql_fetch_assoc(mysql_query($query));
        return $result['arena_status'];
    }
    
    //Check if user has already a chosen arena
    function check_arena_id($type)
    {
        if($type=='player')
        {   
            $var_name = 'user_arena_id';
        }
        else
        {
            $var_name = 'admin_arena_id';
        }
        
        if(empty($_SESSION[$var_name]))
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    /**
     * @desc Create a new game session
     */
    function game_create($arena_id)
    {
        if($this->game_is_running($arena_id)===false)
        {
            $query = "INSERT INTO games(game_arena_id) VALUES({$arena_id})";
            mysql_query($query);
            return mysql_insert_id();
        }
        else
        {
            return false;
        }
    }
    
    /**
     * @desc Close game
     */
    function game_close($arena_id)
    {
        if($this->game_is_running($arena_id)!==false)
        {
            echo "NOT FALSE!";
            $query = "UPDATE games SET game_status = 0 WHERE game_arena_id={$arena_id} AND game_status=1";
            echo $query;
            mysql_query($query);
        }
    }
    
    /**
     * @desc Check if the arena has a game running
     */
    function game_is_running($arena_id)
    {
        $query = "SELECT game_id FROM games WHERE game_arena_id={$arena_id} AND game_status=1 LIMIT 1";
        $result = mysql_query($query);
        if(!empty($result))
        {
            $row_count = mysql_num_rows($result);
            if($row_count == 0)
            {
                return false;
            }
            else
            {
                $row = mysql_fetch_assoc($result);
                return $row['game_id'];
            }
        }
        else
        {
            return false;
        }
    }
    
    function fight_new_fight($arena_id)
    {
        $game_id = $this->game_is_running($arena_id);
        if($game_id !== false)
        {
            $fight_sequence_no = $this->fight_get_fight_number($arena_id);
            $fight_sequence_no +=1;
            $query = "INSERT INTO fights(fight_game_id,fight_sequence_no,fight_status) 
                      VALUES({$game_id},{$fight_sequence_no},0)";
            return mysql_query($query);
        }
        else
        {
            return false;
        }
    }
        
    function fight_is_ongoing($arena_id)
    {
        $game_id = $this->game_is_running($arena_id);
        if($game_id !== false)
        {
            $query = "SELECT fight_game_id AS fight_sequence_no FROM fights WHERE fight_game_id={$game_id} AND fight_status=2 LIMIT 1";
            $result = mysql_query($query);
            if(!empty($result))
            {
                if(mysql_num_rows($result) == 1)
                {
                    return true;
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
        else
        {
            
        }
    }
    
    function fight_get_fight_number_by_fight_id($fight_id)
    {
        $query = "SELECT IFNULL(MAX(fight_sequence_no),0) AS fight_sequence_no FROM fights WHERE fight_id={$fight_id}";
        $result = mysql_query($query);
        if(!empty($result))
        {
            $row = mysql_fetch_assoc($result);
            return $row['fight_sequence_no'];
        }
        else
        {
            return false;
        }
    }
    
    function fight_get_fight_id($arena_id)
    {
        $game_id = $this->game_is_running($arena_id);
        if($game_id !== false)
        {
            $fight_sequence_number = $this->fight_get_fight_number($arena_id);            
            $query = "SELECT fight_id FROM fights WHERE fight_game_id={$game_id} AND fight_sequence_no={$fight_sequence_number}";
            $result = mysql_query($query);
            if(!empty($result))
            {
                $row = mysql_fetch_assoc($result);
                return $row['fight_id'];
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
    
    function fight_get_fight_number($arena_id)
    {
        $game_id = $this->game_is_running($arena_id);
        if($game_id !== false)
        {
            $query = "SELECT IFNULL(MAX(fight_sequence_no),0) AS fight_sequence_no FROM fights WHERE fight_game_id={$game_id}";
            $result = mysql_query($query);
            if(!empty($result))
            {
                $row = mysql_fetch_assoc($result);
                return $row['fight_sequence_no'];
            }
            else
            {
                return false;
            }
        }
        else
        {
            return 0;
        }
    }
    
    function fight_get_fight_result($arena_id)
    {
        return 0;
    }

    /**
     * @desc Log-off the user properly
     */
    function user_logoff()
    {
        $this->user_take_offline($_SESSION['user_user_id']);
        unset($_SESSION['user_username']);
        unset($_SESSION['user_user_id']);
        unset($_SESSION['user_arena_id']);
    }
    
    /**
     * @desc Log-off the admin properly
     */
    function admin_logoff()
    {
        $this->close_arena($_SESSION['admin_arena_id']);
        unset($_SESSION['admin_username']);
        unset($_SESSION['admin_user_id']);
        unset($_SESSION['admin_arena_id']);
    }
    
    /**
     * @desc Take the user online
     */
    function get_online_users($arena_id)
    {
        $query = "SELECT users.user_id,arena_id,user_username 
                    FROM arena_online_users INNER JOIN users ON arena_online_users.user_id=users.user_id 
                    WHERE arena_id={$arena_id} ORDER BY last_activity DESC";
        $result = mysql_query($query);
        $row_count = mysql_num_rows($result);
        if($row_count > 0)
        {
            $list .= "<ul>";
            while($row = mysql_fetch_assoc($result))
            {
                $list .= "<li>{$row['user_username']}</li>";
            }
            $list .= "</ul>";
            return $list;
        }
        else
        {
            return false;
        }
    }
    
    function get_online_users_count($arena_id)
    {
        $query = "SELECT COUNT(*) AS 'totalOnline' FROM arena_online_users WHERE arena_id={$arena_id}";
        $row = mysql_fetch_assoc(mysql_query($query));
        return $row['totalOnline'];
    }
    
    /**
     * @desc Take the user online
     */
    function user_register_as_online()
    {
        $session_id = session_id();
        if($this->user_is_online($_SESSION['user_user_id'])==false)
        {
            $session_id = session_id();
            $query = "INSERT INTO arena_online_users(session,user_id,last_activity,arena_id)
                      VALUES('{$session_id}',{$_SESSION['user_user_id']},NOW(),{$_SESSION['user_arena_id']});";
            mysql_query($query) or die(mysql_error());
        }
        else
        {
            $query = "UPDATE arena_online_users 
                        SET last_activity=NOW(),
                            arena_id={$_SESSION['user_arena_id']}
                            WHERE user_id={$_SESSION['user_user_id']}";
            mysql_query($query) or die(mysql_error());
        }
    }
    
    /**
     * @desc Remove the user on the online user list
     */
    function user_take_offline($user_id)
    {
        if($this->user_is_online($_SESSION['user_user_id']))
        {
            $query = "DELETE FROM arena_online_users WHERE user_id={$user_id}";
            mysql_query($query);
        }
    }
    
    /**
     * @desc Check user if it is online
     */
    function user_is_online($user_id)
    {
        $query = "SELECT * FROM arena_online_users WHERE user_id={$user_id}";
        $row_count = mysql_num_rows(mysql_query($query));
        if($row_count==1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
$arena = new arena();