<?php

    require_once('../includes/ini_classes.php');
    $helpers->validate_session($_SESSION['user_user_id'],"../");
    if(isset($_POST['binan'])){
        $_SESSION['user_arena_id'] = 1;
       // $helpers->redirect("./");
       // $helpers->redirect("../../testbet/GameModule.php");
        $helpers->redirect("../../testbet2/GamePlayer.php");
    }
    if(isset($_POST['cabuyao'])){
        $_SESSION['user_arena_id'] = 2;
        //$helpers->redirect("../../testbet/GameModule.php");
        $helpers->redirect("../../testbet2/GamePlayer.php");
		//        $helpers->redirect("./");
    }
?>
<html>
    <head>
        <title>Game Console </title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>
    <body>
        <div id="container" >
            <div id="header"></div>
            <div id="body">
                <form action="<?php echo SELF; ?>" method="post">
                    <fieldset id="choose_arena">
                        <legend><h1>Choose Arena</h1></legend>
			<input type="submit" name="binan" value="Enter Arena" />
                        </fieldset>
                </form>
            </div>
            <div id="footer">Footer</div>
        </div>
    </body>
</html>
