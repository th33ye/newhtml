<?php

include 'dbConn.php';
require("GlobalFunctions.php");



	$betamount = $_POST['betamount'];
	$betType = $_POST['betType'];
	$betOdds = $_POST['betOdds'];	
	$userId = $_POST['userId'];
	$gameId = $_POST['gameId'];
	$betMode = $_POST['betMode'];
	$arenaId = $_POST['arenaId'];

/*
	$betamount = $_GET['betamount'];
	$betType = $_GET['betType'];
	$betOdds = $_GET['betOdds'];
	
	$userId = $_GET['userId'];
	$gameId = $_GET['gameId'];
	$betMode = $_GET['betMode'];
	$arenaId = $_GET['arenaId'];

*/

	$Message = "";
	$AllowedRequestamount = 0;
	$NewBetamount =0;
	$ReturnamountRequest = 0;  
	
	$gamestatus = GetCurrentGameStatus($arenaId, $gameId);
		
	if ($gamestatus == "Betting Open")
	{
			//Get Exact Matching Bet
			$getBetQuery =	" SELECT bet_type, bet_odd_id, sum(amount) as amount From bettingdata WHERE " .
							" arena_id = " . $arenaId . " AND game_id = " . $gameId . " AND user_id = " . $userId . 
							" AND bet_odd_id = " . $betOdds . " AND bet_type = '". $betType .
							 "' GROUP BY arena_id, game_id, bet_type, user_id, bet_odd_id ";
						
			
			$result = mysql_query($getBetQuery);
				
			while ($row = mysql_fetch_array($result))
			{
				$betType = $row['bet_type'];
				$AllowedRequestamount = $row['amount'];	
			}
			
			
			//if betting status is open proceed else do not proceed
			//Means there is no existing bet for this users
			if ($AllowedRequestamount == 0)
			{
				$Message = "You did not place any bets ony this Odd, you cannot modify.";
			}
			elseif ($betamount > $AllowedRequestamount)
			{
				$Message = "Your request to modify " . number_format($betamount, 2, '.', '') . 
							" is not allowed, your bet for this Odd is only " .
							$AllowedRequestamount;
			}
			else if ($betamount <= $AllowedRequestamount)
			{
				//$NewBetamount = $AllowedRequestamount -  $betamount;				
				$ReturnamountRequest = $betamount;
			}
			else
			{		
				//$NewBetamount = 0;
				$ReturnamountRequest = $betamount;		
			}
			
			 
			 if ($Message == "")
			 {	 
					$allowedReturn = CheckForCancellation($betType, $ReturnamountRequest, $betOdds, $gameId, $Message, $userId);
					
					if ($allowedReturn <= 0)
					{
						$Message = "Your bet cannot be cancelled, another bet has been set to accept your challenge";
					}
					elseif ($ReturnamountRequest >  $allowedReturn)
					{				
						ProcessBetCancellation($gameId, $betType, $betOdds, $allowedReturn, $userId);
						$Message =  "Betting on this Odd has been set you can only get " . number_format($allowedReturn, 2, '.', '') .
									 " from your modification " ;
					}
					else
					{
						ProcessBetCancellation($gameId, $betType, $betOdds, $allowedReturn, $userId);
						$Message = "Your bet has been returned " . number_format($allowedReturn, 2, '.', '');
					}
			 }
	
	}
	else
	{
		$Message = "You cannot cancel your bet game has been closed.";
	}		
	
 	echo $Message;

?>