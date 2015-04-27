<?php
    require_once('classes/ini_classes.php');
    $helper->redirect_if_login('player','players/index.php');
    if(isset($_POST['submit']))
    {
        $result = $login->validate_login_user($_POST['username'], $_POST['password']);
        if(empty($result))
        {
            $login_result = $login->dbchk_user($_POST['username'], $_POST['password']);
            if($login_result==true)
            {
                $helper->redirect('players/choose_arena.php');
            }
            else
            {
                $error_msg = 'Invaid username and/or password';
            }
        }
        else
        {
            $error_msg = $result;
        }
    }
    $subTitle = 'Player Login'; 
?>
    
<?php include_once('includes/layouts/default_header.php'); ?>
<form action="<?php SELF;?>" method="POST">
    <fieldset>
        <legend><?php echo $subTitle; ?></legend>
        Username: <input type="text" name="username" /><br />
        Password: <input type="password" name="password" /><br />
        <input type="submit" name="submit" value="Login" />
        <?php echo $error_msg; ?>
    </fieldset>
</form>
<?php include_once('includes/layouts/default_footer.php'); ?>