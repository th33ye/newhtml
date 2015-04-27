<?php
class helper
{
    // Redirect pages
    function redirect($location)
    {
        header("Location: ".$location);
    }
    
    function sanitize($string)
    {
        return mysql_real_escape_string($string);
    }
    
    function redirect_if_login($type, $location)
    {
        if($type=='player')
        {
            if(!empty($_SESSION['user_user_id']))
            {
                $this->redirect($location);
            }
        }
        else
        {
            if(!empty($_SESSION['admin_user_id']))
            {
                $this->redirect($location);
            }
        }
    }
    
    function validate_player_session($location)
    {
        if(empty($_SESSION['user_user_id']))
        {
            $this->redirect($location);
        }
    }
    
    function validate_admin_session($location)
    {
        if(empty($_SESSION['admin_user_id']))
        {
            $this->redirect($location);
        }
    }
}
$helper = new helper();