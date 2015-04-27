<?php

include 'dbConn.php';
require("GlobalFunctions.php");

/*
$userId = $_POST['user_id'];
$currGameId = $_POST['currentGameId'];
$currGameNo = $_POST['currentgamenumber'];
$currgamestatus = $_POST['currentgamestatus'];
*/

/*
$code = 2 ; // $_POST['codeId'];
$arenaId = 2; //$_POST['arenaId'];
$gameNo = 6; //$_POST['gameNo'];
*/


$code = $_POST['codeId'];
$arenaId = $_POST['arenaId'];
$gameNo = $_POST['gameNo'];


function ProcessDeductions($GameId, $Winner)
{
	 $query = "SELECT * FROM bettingdata WHERE game_id = " . $GameId . " AND bet_type = '" . $Winner . "'";
	 $result = mysql_query($query);
	 
	 while ($row = mysql_fetch_array($result))
	 {	
	 	$bettingdataId = $row['betting_id'];
		$userId = $row['user_id'];
		$betType = $row['bet_type'];
		$amount =  $row['amount'];
		$betOddId = $row['bet_odd_id'];
		$multiplier = GetMultiplierFromOdd($betOddId, $Winner);

		//Take note of this		
		$userAddDed = $multiplier * $amount;	
		// For 10% Rake
		//$commission = $userAddDed * .1;
		//$forPlayer = $userAddDed * .9;

		// For 5% Rake
		//$commission = $userAddDed * .05;
		//$forPlayer = $userAddDed * .95;

		// For 3.5% Rake
		$commission = $userAddDed * .035;
		$forPlayer = $userAddDed * .965;
			
		//replace with .9 when wins
		
		//Original
		//$queryAddDeduct = "UPDATE users SET user_credits = (user_credits + " . $amount ." + " . ($forPlayer) . ")  WHERE user_id = " . $userId;		
		
		//Add Prize
		$queryAddDeduct = "UPDATE users SET user_credits = (user_credits + " . $forPlayer . ")  WHERE user_id = " . $userId;		
		mysql_query($queryAddDeduct);								
		
		$FinalBalance = GetUsersCurrentBalance($userId);
		InsertPointsHistory($userId, $GameId, $forPlayer, 1, "Winning payment " .  $userAddDed . " (" .$Winner. ") less 3.5% ", $FinalBalance);	
				
		//Return Capital
		$queryAddDeduct = "UPDATE users SET user_credits = (user_credits + " . $amount .")  WHERE user_id = " . $userId;		
		mysql_query($queryAddDeduct);	
		
		$FinalBalance = GetUsersCurrentBalance($userId);
		InsertPointsHistory($userId, $GameId, $amount, 1, "Returned, Bet Capital for Bet Odd Id " . $betOddId  , $FinalBalance);	
			
		Insertsabongpointsbank($userId, $GameId, $bettingdataId, $forPlayer, $commission);	
		
			
	 }
	 
	 $queryDeletebettingdata = "DELETE FROM bettingdata WHERE game_id = " . $GameId;
	 mysql_query($queryDeletebettingdata);
}



function ProcessBets($GameId)
{


	//Get All Bets List			
	$queryAllBets = "SELECT M.bet_odd_id, W.bet_oddw, M.bet_oddm, W.WTotal, M.MTotal FROM ( " .
							"SELECT 	B.bet_odd_id, B.bet_oddw, W1.Total as WTotal FROM ( " .
    							"SELECT bet_odd_id, bet_type, SUM(amount) as Total FROM bettingdata " .
								   "WHERE game_id = " . $GameId . " and bet_type = 'w' GROUP BY bet_odd_id, bet_type) as W1 " .
								    	"RIGHT JOIN betoddslist B ON B.bet_odd_id = W1.bet_odd_id " .
								 ") AS W ".
					 "INNER JOIN ( " .
				    		"SELECT B.bet_odd_id, B.bet_oddm, M1.Total as MTotal FROM ( " .
								"SELECT bet_odd_id, bet_type, SUM(amount) as Total FROM bettingdata " .
									"WHERE game_id = " . $GameId . " and bet_type = 'm' GROUP BY bet_odd_id, bet_type) as M1 " .
									    "RIGHT JOIN betoddslist B ON B.bet_odd_id = M1.bet_odd_id " .
								 ") AS M " .
							"ON M.bet_odd_id = W.bet_odd_id";
		

			
	
	$resultAllBets = mysql_query($queryAllBets);
		
	while ($row = mysql_fetch_array($resultAllBets))
	{	
		
		$betOddId = $row['bet_odd_id'];
		$betOddM = $row['bet_oddm'];
		$betOddW = $row['bet_oddw'];

		if ($row['MTotal'] == null || $row['MTotal'] == "")
		{
			$mTotal = 0;
		}
		else
		{
			$mTotal = $row['MTotal'];
		}
		
		if ($row['WTotal'] == null || $row['WTotal'] == "")
		{
			$wTotal = 0;
		}
		else
		{
			$wTotal = $row['WTotal'];
		}
				
	//	echo $betOddM  . " - " . $betOddW .  " - " . $mTotal.  " - " . $wTotal . " <br> ";
		
		$mbetnew = 0;
		$wbetnew = 0;
		$mreturn = 0;
		$wreturn = 0;
		
		ProcessBet($mTotal, $wTotal, $betOddM, $betOddW, $mbetnew, $wbetnew, $mreturn, $wreturn);
		
		if ($mreturn > 0)
		{
			//echo "returing to M amount of " . $mreturn . "<br>";
	        ProcessBetReturns($GameId, 'm', $betOddId, $mreturn);
		}
		
		if ($wreturn > 0)
		{
			//echo "returing to W amount of " . $wreturn . "<br>";
	        ProcessBetReturns($GameId, 'w', $betOddId, $wreturn);
		}

	}
	
	
}

//" AND arena_id=" . $arenaId .
function ProcessBetReturns($GameId, $betType, $betOddId, $deductamount)
{
	//Get Betting Data;
	$queryGetAllBets = "SELECT * FROM bettingdata WHERE game_id = " . 
	$GameId . " and bet_type = '" . $betType . "' and bet_odd_id = " . 
	$betOddId . " ORDER BY betting_id DESC";
	
	$result = mysql_query($queryGetAllBets);
	while ($row = mysql_fetch_array($result))
	{
		$bettingId = $row['betting_id'];
		$userId = $row['user_id'];
		$betamount = $row['amount'];
		
		$newbetamount = 0;
		
		if ($betamount <= $deductamount)
		{
			//Return Deducted Credit;			
			
			$deductamount = $deductamount - $betamount;	
			
			$query = "UPDATE users SET user_credits = user_credits + " . $betamount . " WHERE user_id = "  . $userId;
			mysql_query($query);	
			
			InsertPointsHistory($userId, $GameId, $betamount, 2, "Returned No Counter part bet", GetUsersCurrentBalance($userId));
			
			$query2 = "DELETE FROM bettingdata WHERE betting_id = " . $bettingId;
			mysql_query($query2);
		}
		else if (($betamount > $deductamount) && ($deductamount > 0))
		{
			//Return Points to User
			$query = "UPDATE users SET user_credits = user_credits + " . $deductamount . " WHERE user_id = "  . $userId;
			mysql_query($query);
			
			InsertPointsHistory($userId, $GameId, $deductamount, 2, "Returned, No Counter part bet", GetUsersCurrentBalance($userId));
		
			$newbetamount = $betamount - $deductamount;
			$deductamount = 0;
			
			//Decrease betting amount		
			$query2 = "UPDATE bettingdata SET amount = " . $newbetamount . " WHERE betting_id = " . $bettingId;
			mysql_query($query2);			
			
						
		}
		
	}
	

}


function CreateNewGame($arenaId, $gamenumber)
{
	$currentGameId = 0;

	$query = "INSERT INTO game (arena_id, gamenumber, gamestatus) " . 
			 "VALUES (" . $arenaId . "," . $gamenumber . ",'wo')";

	mysql_query($query);
		
	//Get last insert
	$result = mysql_query("SELECT * FROM game WHERE arena_id = " . $arenaId . " ORDER BY game_id DESC LIMIT 0,1");	
	while ($row = mysql_fetch_array($result))
	{
		$currentGameId = $row['game_id'];	
	}

	$query = "UPDATE currentgamedisplay SET " . 
			" game_id = " . $currentGameId . 
			", gamenumber = " . $gamenumber . 
			" , gamestatus = 'Betting Will Open Soon', gamewinner = '' WHERE arena_id= " . $arenaId;
	mysql_query($query);
	
	$queryClearBettingData = "DELETE FROM bettingdata WHERE arena_id = " . $arenaId;
	mysql_query($queryClearBettingData);

	/*
	 * update arena table
	* make arena online
	*/
	$arenaSQL = "UPDATE arena SET online = '1' WHERE arena_id = $arenaId";
	mysql_query($arenaSQL);
	
	return $currentGameId;	

}


$gameId =  GetCurrentGameId($arenaId);
$query = "";

echo $gameId . "<br>";

if ($code == 0) //Create new fight
{
	 CreateNewGame($arenaId, $gameNo);
	 //Delete current betting data where arena id = $arenaId
	 
}
elseif ($code == 1)
{
	UpdateGameAndCurrentGameDisplay($arenaId, $gameId, "o");
}
elseif  ($code == 2)
{
	ProcessBets($gameId);
	UpdateGameAndCurrentGameDisplay($arenaId, $gameId, "bc");
}
elseif  ($code == 3)
{
	ProcessDeductions($gameId , 'm');	
	UpdateGameAndCurrentGameDisplay($arenaId, $gameId, "dm");

}
elseif  ($code == 4)
{
	ProcessDeductions($gameId , 'w');
	UpdateGameAndCurrentGameDisplay($arenaId, $gameId, "dw");

}
elseif  ($code == 5)
{
    ReturnAllBets($gameId, "Game draw bet returned");
	UpdateGameAndCurrentGameDisplay($arenaId, $gameId, "d");
}
elseif  ($code == 6)
{
    ReturnAllBets($gameId,"Game cancelled bet returned");
	UpdateGameAndCurrentGameDisplay($arenaId, $gameId, "c");
}
elseif  ($code == 7)
{
	//Return Bets Left
    	//ReturnAllBets($gameId, "Game Has Been Ended");
	UpdateGameAndCurrentGameDisplay($arenaId, $gameId, "e");
}
	
mysql_close();

?>
