<?php
require_once('helper.php');
class login extends helper
{
    function validate_login_user($username, $password)
    {
        $trm_username = trim($username);
        $trm_password = trim($password);
        $errors = array();
        if((!isset($trm_username) || ($trm_username == "")) || (!isset($trm_password) || ($trm_password == "")))
        {
            $errors = "username and password is required";
        }
        return $errors;
    }

    // Login check for Players
    function dbchk_user($username, $password)
    {
        $un =  mysql_real_escape_string($username);
        $pw =  md5(mysql_real_escape_string($password));
        $query = "SELECT user_username, user_id FROM users WHERE user_username = '{$un}' AND user_password = '{$pw}'";
        $execQuery = mysql_query($query);
        $row = mysql_fetch_array($execQuery);
        if($row)
        {
            $this->session_user($row['user_username'], $row['user_id']);
            $result = true;
        }
        if(!$row)
        {
            $result = false;
        }
        return $result;
    }

    // Login check for game admin
    function dbchk_admin($username, $password)
    {
        $un =  mysql_real_escape_string($username);
        $pw =  md5(mysql_real_escape_string($password));
        $query = "SELECT admin_username, admin_id, admin_arena_id FROM admin_users 
                    WHERE admin_username = '{$un}' AND admin_password = '{$pw}'";
        $execQuery = mysql_query($query);
        $row = mysql_fetch_array($execQuery);
        if($row)
        {
            $this->session_admin($row['admin_username'], $row['admin_id'], $row['admin_arena_id']);
            $result = true;
        }
        if(!$row)
        {
            $result = false;
        }
        return $result;
    }

    // Choose type of admin
    function sel_admtype($admin_type)
    {
        if($admin_type == 448){
            $arena = "Binan";
        }
        if($admin_type == 449){
            $arena = "Cabuyao";
        }
        return $arena;
    }

    // Sets session if the username and password are correct -Admin-
    function session_admin($username, $user_id, $arena_id)
    {

	$_SESSION['user_user_id'] = 8579; //dummy user for admin
        $_SESSION['admin_username'] = $username;
        $_SESSION['admin_user_id'] = $user_id;
        $_SESSION['admin_arena_id'] = $arena_id;
	$_SESSION['AdminUseOnly'] = "adminuseonly";



    }
    // Sets session if the username and password are correct -User/Player-
    function session_user($username, $user_id)
    {
        $_SESSION['user_username'] = $username;
        $_SESSION['user_user_id'] = $user_id;
    }
    
    // Gets Arena name by Arena ID
    function arena_name($arena_id)
    {
        $query = "SELECT arena_name FROM arena WHERE arena_id = {$arena_id}";
        $execQuery = mysql_query($query);
        return $execQuery;
    }

    function logout($session)
    {
        $session = array();
        return $session;
    }
}
$login = new login();