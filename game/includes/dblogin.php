<?php
/* 
 * Validation
 */
require_once('helpers.php');
class Login extends helpers {
    // Validate required fields
    function validate_login_user($username, $password){
        $trm_username = trim($username);
        $trm_password = trim($password);
        $errors = array();
        if(!isset($trm_username) || ($trm_username == "")){
            $errors[] = "Username is required.";
        }
        if(!isset($trm_password) || ($trm_password == "")){
            $errors[] = "Password is required.";
        }
        return $errors;
    }

    // Checks if Username and Password matches in the database -Players/Users-
    function dbchk_user($username, $password){
        $query = "SELECT user_username, user_id FROM users WHERE
                 user_username = '{$username}' AND user_password = '".md5($password)."'
        ";
        $execQuery = mysql_query($query);
        $row = mysql_fetch_array($execQuery);
        if($row){
            $this->session_user($row['user_username'], $row['user_id']);
            $this->redirect('players/chose_arena.php');
            //$this->redirect('../../testbet2/GamePlayer.php');
        }
        if(!$row){
            $error = "Username and Password did not match";
        }
        return $error;
    }

    // Checks if Username and Password matches in the database -Admin-
    function dbchk_admin($username, $password){
        $query = "SELECT admin_username, admin_id, admin_arena_id FROM admin_users WHERE
                 admin_username = '{$username}' AND admin_password = '".md5($password)."'
        ";
        $execQuery = mysql_query($query);
        $row = mysql_fetch_array($execQuery);
        if($row){
            $this->session_admin($row['admin_username'], $row['admin_id'], $row['admin_arena_id']);
            $this->redirect('admin');
        }
        if(!$row){
            $error = "Username and Password did not match";
        }
        return $error;
    }

    // Choose type of admin
    function sel_admtype($admin_type){
        if($admin_type == 448){
            $arena = "Binan";
        }
        if($admin_type == 449){
            $arena = "Cabuyao";
        }
        return $arena;
    }

    // Sets session if the username and password are correct -Admin-
    function session_admin($username, $user_id, $arena_id){
        $_SESSION['admin_username'] = $username;
        $_SESSION['admin_user_id'] = $user_id;
        $_SESSION['arena_id'] = $arena_id;
    }
    // Sets session if the username and password are correct -User/Player-
    function session_user($username, $user_id){
        $_SESSION['user_username'] = $username;
        $_SESSION['user_user_id'] = $user_id;
    }
    
    // Gets Arena name by Arena ID
    function arena_name($arena_id){
        $query = "SELECT arena_name FROM arena WHERE arena_id = {$arena_id}";
        $execQuery = mysql_query($query);
        return $execQuery;
    }

    function logout($session){
        $session = array();
        return $session;
    }

}
$login = new Login();

