<?php

include 'dbConn.php';
//include 'Global.php';

require("GlobalFunctions.php");

$betamount = $_POST['betamount'];
$betType = $_POST['betType'];
$betOdds = $_POST['betOdds'];

$userId = $_POST['userId'];
$gameId = $_POST['gameId'];
$betMode = $_POST['betMode'];
$arenaId = $_POST['arenaId'];

/*
$betamount = 100;
$betType = 'm';
$betOdds = 1;

$userId = 14;
$gameId = 2;
$betMode = 'place';
$arenaId = 1;
*/

//echo $betamount . " " . $betType . " " . $betOdds . " " . $userId . " " . $gameId . " " . $betMode;
//echo "Placing BetarenaId=1&betamount=200&betType=m&betOdds=1&gameId=2&userId=1&betMode=place";



try
{
	$betQuery = "";
	
	if ($betMode == 'place')
	{			
		// if betting status == 'open' then proceed
		
		$gamestatus = GetCurrentGameStatus($arenaId, $gameId);
		
		if ($gamestatus == "Betting Open")
		{
			//Get current bet
			$totalBetOnOdd = GetTotalBetOfUser($userId, $betOdds, $gameId, $betType);
			$currBal = GetUsersCurrentBalance($userId);
			
			if ((floatval($currBal) + floatval($totalBetOnOdd)) >=  floatval($betamount))
			{
                if (($currBal - $betamount) >= 0) {
                    //Check User Credit Points
                    InsertBettingData($arenaId, $gameId, $betType, $userId, $betOdds, $betamount, '');

                    InsertBettingDataHistory($arenaId, $gameId, $betType, $userId, $betOdds, $betamount, '', "User Places Bet");

                    //Deduct from Credits
                    $updateCredit = "UPDATE users Set user_credits = user_credits - " . $betamount . " WHERE user_id = " . $userId;
                    mysql_query ($updateCredit);

                    InsertPointsHistory($userId, $gameId, $betamount, 6, "Placed Bet (" . $betType . ") for Odd Id " .
                        $betOdds, GetUsersCurrentBalance($userId));
                }
			}
		}	
	
		
	}
	
	mysql_close();
	
}
catch (Exception $e) 
{
	echo $e;
    //echo 'Caught exception: ',  $e->getMessage(), "\n";
}


?>
