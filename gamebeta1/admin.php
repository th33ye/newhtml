<?php
    require_once('classes/ini_classes.php');
    $helper->redirect_if_login('admin','admin/index.php');

    function get_ip_address() {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                        return $ip;
                    }
                }
            }
        }
    }

    if(isset($_POST['submit']))
    { 
        $result = $login->validate_login_user($_POST['username'], $_POST['password']);
        if(empty($result))
        {
            $login_result = $login->dbchk_admin($_POST['username'], $_POST['password']);
            if($login_result==true)
            {
                // $_SESSION['user_arena_id'] = 1; //Hard Coded Temporarily
                $_SESSION['user_user_id'] = 8579; //Hard Coded Temporarily
                /* for logging purpose */
                $real_ip = get_ip_address();				// supposed to be real ip
                $userid = $_SESSION['user_user_id'];		// userid
                $username = $_SESSION['admin_username'];	// userusername
                $remoteip = $_SERVER['REMOTE_ADDR'];		// remote ip
                $useragent = $_SERVER['HTTP_USER_AGENT'];	// user agent
                $useragent = (strlen($useragent) > 250) ? substr($useragent,0,247).'...' : $useragent;
                $loginLog = "INSERT INTO login_history (player_id, player, remote_ip, real_ip, user_agent)
         				      VALUES ('$userid','$username','$remoteip','$real_ip','$useragent')";
                if (mysql_query($loginLog) !== TRUE) {
                    echo mysql_connect_errno() . " - " . mysql_connect_error();
                }
                // $_SESSION['admin_id'] = 8579; //Hard Coded Temporarily
                //$helper->redirect('admin/index.php');
                //$helper->redirect('../../testbet/AdminMain1.php');
                //$helper->redirect('../../testbet4/GameAdmin.php');
                $helper->redirect('../../betnow/GameAdmin.php');

                //$helpers->redirect("../../testbet/GameModule.php");
            }
            else
            {
                $error_msg = 'Invalid username and/or password';
            }
        }        
    }    
    $subTitle = 'Admin Login'; ?>
<?php include_once('includes/layouts/default_header.php'); ?>
<form action="<?php echo SELF;?>" method="POST">
    <fieldset>
        <legend>Admin Login:</legend>
        Username: <input type="text" name="username" /><br />
        Password: <input type="password" name="password" /><br />
        <input type="submit" name="submit" value="Login" />
        <?php echo $error_msg; ?>
    </fieldset>
</form>
<?php include_once('includes/layouts/default_footer.php'); ?>