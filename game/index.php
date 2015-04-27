<?php
    require_once('includes/ini_classes.php');
    if(isset($_POST['submit'])){
            $error = $login->validate_login_user($_POST['username'], $_POST['password']);
            if(empty($error)){
                // Proceed to database
                $err_userpass = $login->dbchk_user($_POST['username'], $_POST['password']);
                
            }
            if($error > 0){
                $err_required = $error;
            }
    }
?>
<html>
    <head>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <title>Sabong</title>
    </head>
    <body>
        <div id="container" >
            <div id="header"></div>
            <div id="body">
                <form action="<?php SELF;?>" method="POST">
                    <fieldset>
                        <legend>Login:</legend>
                        Username: <input type="text" name="username" /><br />
                        Password: <input type="password" name="password" /><br />
                        <input type="submit" name="submit" value="Login" />
                        <?php
                            if($err_required){
                                echo "<p>";
                                foreach($err_required as $error){
                                    echo $error."<br />";
                                }
                                echo "</p>";
                            }
                            if($err_userpass){
                                echo "<p>".$err_userpass."</p>";
                            }
                        ?>
                    </fieldset>
                </form>
            </div>
            <div id="footer"></div>
        </div>
    </body>
</html>
