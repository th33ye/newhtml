<?php
    require_once('../classes/ini_classes.php');
    if($_POST['binan'])
    {
        $_SESSION['user_arena_id'] = 1;
		$_SESSION['arenaId'] = 1;
		
		// if vip redirect to full functionality
		if($_SESSION['vip'])
		{
			$helper->redirect('../../betnow/GamePlayer.php');
		}
		// we have not need for this
		// if credit is < 5, redirect to no chat
		elseif($_SESSION['user_credits'] < 5)
		{
			if($_SESSION['with_chat']) 
				$helper->redirect('../../betnow/GamePlayer.php');
			else
				$helper->redirect('../../betnow/GamePlayer-strip.php');
		}
		// if has credit
		elseif($_SESSION['user_credits'] >= 5)
		//else
		{
			if($_SESSION['with_chat']) 
				$helper->redirect('../../betnow/GamePlayer.php');
			else
				$helper->redirect('../../betnow/GamePlayer-working-wout-chat.php');
		}
        //$helper->redirect('index.php');
    }
    else if($_POST['cabuyao'])
    {
        $_SESSION['user_arena_id'] = 2;
		$_SESSION['arenaId'] = 2;
		
		// if vip redirect to full functionality
		if($_SESSION['vip'])
		{
			$helper->redirect('../../betnow/GamePlayer.php');
		}
		// we have not need for this
		// if credit is < 5, redirect to no chat
		elseif($_SESSION['user_credits'] < 5)
		{
			if($_SESSION['with_chat'])
				$helper->redirect('../../betnow/GamePlayer.php');
			else
				$helper->redirect('../../betnow/GamePlayer-strip.php');
		}
		// if has credit
		elseif($_SESSION['user_credits'] >= 5)
		//else
		{
			if($_SESSION['with_chat'])
				$helper->redirect('../../betnow/GamePlayer.php');
			else
				$helper->redirect('../../betnow/GamePlayer-working-wout-chat.php');
		}		
    }   
    $subTitle = 'Choose Arena';
    include_once('../includes/layouts/default_header.php'); ?>
    <form action="<?php echo SELF; ?>" method="post">
        <fieldset id="choose_arena">
			<legend><h1>Choose Arena</h1></legend>
				<input type="submit" name="cabuyao" value="Roligon Mega Cockpit" />
			<!--
				<input type="submit" name="cabuyao" value="Pasig Square Garden" /> 
				<input type="submit" name="binan" value="Binan Cockpit Arena" />
				<input type="submit" name="binan" value="Pasig Square Garden" /> 
			-->
        </fieldset>
    </form>
    <?php include_once('../includes/layouts/default_footer.php'); ?>
