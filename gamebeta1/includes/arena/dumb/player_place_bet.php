<?php
    require_once('../../../classes/ini_classes.php');
    require_once('../../../classes/arena.php');

    $bet_amount = $_POST['amount'];
    $arena_id = $_SESSION['user_arena_id'];
    $user_id = $_SESSION['user_user_id'];
    $fight_id = $arena->fight_get_fight_id($arena_id);
    $bet_odd_id = $_POST['odds'];
    $bet_type = $_POST['bettype'];

	$result = $arena->bet_place($arena_id,$user_id,$fight_id,$bet_odd_id,$bet_type,$bet_amount);
	if($result==true)
	{
		echo "Bet has been placed";
	}
	else
	{
		echo $result;
	}