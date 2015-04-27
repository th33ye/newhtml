<?php

include 'dbConn.php';


function GetTotalBetOfUser($userid, $betoddid, $gameid, $betType)
{		
		$totalBet = 0;
		
		$query = "select sum(amount) as totalbet from bettingdata where " .
				  " user_id = " . $userid.  " and bet_odd_id = ". $betoddid . " and game_id =". $gameid 
				  . " and bet_type = '". $betType ."'";
				  
		$result = mysql_query($query);
		
 		while ($row = mysql_fetch_array($result))
		{
			$totalBet = $row['totalbet'];	
		}
		
		if ($totalBet == "")
		{
			$totalBet = 0;
		}
		
		return $totalBet;

}


function GetCurrentGameStatus($arenaId, $gameId)
{	
		$currentGameStatus = "";
		$query = "select * from currentgamedisplay  where arena_id = " .  $arenaId . " and game_id = " . $gameId;
		$result = mysql_query($query);
		
 		while ($row = mysql_fetch_array($result))
		{
			$currentGameStatus = $row['gamestatus'];	
		}
		
		return $currentGameStatus;
 
}



function GetUsersCurrentBalance($userId)
{	
		$usercredits = 0;
		$queryGetCurrentBalance = "SELECT user_credits FROM users WHERE user_id = " . $userId;
		$resultBalance = mysql_query($queryGetCurrentBalance);
		
 		while ($row = mysql_fetch_array($resultBalance))
		{
			$usercredits = $row['user_credits'];	
		}
		
		return $usercredits;
 
}



function InsertBetHistory($arenaId, $gameId, $betType, $userId, $betOdds, $betamount, $description)
{
		//Insert Bet History
		$betQueryHs = "INSERT INTO bettingdatahistory " .
		"(arena_id, game_id, bet_type, user_id, bet_odd_id, amount, datecreated, description)" .
		" VALUES (" . $arenaId . "," . $gameId .", '" . $betType  ."', " . 
					 $userId . ", " . $betOdds  . ", " . $betamount . ", now(), '" . $description . "')";						 	
		mysql_query ($betQueryHs);
}


//These functions should be placed in a global variable
//function InsertPointsHistory($userId, $transactedamount, $TransactedTypeId, $description, $FinalBalance)
//{
//
//	$query = " INSERT INTO pointsaudit (user_id, transactiondate, transactedamount, transactiontype_id, description, remainingbalance) VALUES " .
//			 " (" . $userId  . ", Now() ," . $transactedamount . ", " . $TransactedTypeId . " , '" . $description . "'," . $FinalBalance .  " ) ";

				
	//echo $query;
//	mysql_query($query);

//}
// modified to include gameId in pointsaudit
function InsertPointsHistory($userId, $GameId, $transactedamount, $TransactedTypeId, $description, $FinalBalance)
{

	$query = " INSERT INTO pointsaudit (user_id, game_id, transactiondate, transactedamount, transactiontype_id, description, remainingbalance) VALUES " .
			 " (" . $userId  . ", " . $GameId . ", Now() ," . $transactedamount . ", " . $TransactedTypeId . " , '" . $description . "'," . $FinalBalance .  " ) ";

				
	//echo $query;
	mysql_query($query);

}

function ProcessBet($mbetOrig, $wbetOrig, $odd1, $odd2, &$mbet, &$wbet, &$mtoreturn, &$wtoreturn)
{	
	$mbet = $mbetOrig;
	$wbet = $wbetOrig;
	
	$mtopay = 0;
	$wtopay = 0;
	
	$mtoreturn = 0;
	$wtoreturn = 0;
							
	$mtopay = $mbet * ($odd2 / $odd1);
	$wtopay = $wbet * ($odd1 / $odd2);
				
	$mbetIsGood = false;
	$wbetIsGood = false;
	
	if ($mbet >= $wtopay)
	{
		$mbetIsGood = true;
	}
	else if ($mbet < $wtopay)
	{
		$mbetIsGood = false;               
	}
	
	if ($wbet >= $mtopay)
	{
		$wbetIsGood = true;
	}
	else
	{
		$wbetIsGood = false;
	}
	
	if ($mbetIsGood && !$wbetIsGood) 
	{
		$mbet = $wbet * ($odd1 / $odd2);
		$mtoreturn = $mbetOrig - $mbet;
	}
	
	if (!$mbetIsGood && $wbetIsGood) 
	{
		$wbet = $mbet * ($odd2 / $odd1);
		$wtoreturn = $wbetOrig - $wbet;
	}
	
}


function Insertsabongpointsbank($userId, $gameId, $bettingdataId, $amountgivenToPlayer, $commissionamount)
{
	$queryInsert = "INSERT INTO sabongpointsbank (fromuser_id,fromgame_id, bettingdata_id, datereceived, amountgiven, commissionamount) " .
				   "VALUES (" . $userId . ", " . $gameId .", " . $bettingdataId .",  Now(), " . $amountgivenToPlayer . ", " . $commissionamount . ");";
				   
	mysql_query($queryInsert);				   

}



function GetMultiplierFromOdd($betOddId, $Winner)
{
	$output = 0;
	
	if ($Winner == 'm')
	{
		$query = "select bet_oddw/bet_oddm as Multiplier from betoddslist where bet_odd_id = " . $betOddId;
	}
	elseif ($Winner == 'w')
	{
		$query = "select bet_oddm/bet_oddw as Multiplier from betoddslist where bet_odd_id = " . $betOddId;
	}
	
    $result = mysql_query($query);
	
	while ($row = mysql_fetch_array($result))
	{
	 	$output = $row['Multiplier'];
	}
	
	return $output;
}




function ReturnAllBets($GameId, $drawOrCancel)
{
	 $query = "SELECT * FROM bettingdata WHERE game_id = " . $GameId;
	 $result = mysql_query($query);
	 
	 while ($row = mysql_fetch_array($result))
	 {	
	 	$bettingdataId = $row['betting_id'];
		$userId = $row['user_id'];
		$betType = $row['bet_type'];
		$amount =  $row['amount'];
		$betOddId = $row['bet_odd_id'];
		$multiplier = GetMultiplierFromOdd($betOddId, $Winner);
		$userAddDed = $amount;			
			
		$queryAddDeduct = "UPDATE users SET user_credits = user_credits + " . $amount . "   WHERE user_id = " . $userId;
		mysql_query($queryAddDeduct);	
		
		InsertPointsHistory($userId, $GameId, $amount, 2, $drawOrCancel, GetUsersCurrentBalance($userId));
		
		$queryDeletebettingdata = "DELETE FROM bettingdata where betting_id = " .  $bettingdataId;
		mysql_query($queryDeletebettingdata);				
		
	 }

}

function GetCurrentGameId($arenaId)
{
	$result = mysql_query("SELECT * FROM game WHERE arena_id = " . $arenaId . " ORDER BY game_id DESC LIMIT 0,1");
	
	while ($row = mysql_fetch_array($result))
	{
		$currentGameId = $row['game_id'];	
	}
	
	
	return $currentGameId;
}

function InsertBettingDataHistory($arenaId, $gameId, $betType, $userId, $betOdds, $betamount, $oddmark, $description)
{
	//Insert Bet History
			$betQueryHs = "INSERT INTO bettingdatahistory " .
			"(arena_id, game_id, bet_type, user_id, bet_odd_id, amount, datecreated, oddmark, description)" .
			" VALUES (" . $arenaId . "," . $gameId .", '" . $betType  ."', " . 
						 $userId . ", " . $betOdds  . ", " . $betamount . ", now(), '" . $oddmark. "', '" . $description . "')";						 	
			mysql_query ($betQueryHs);
}

function InsertBettingData($arenaId, $gameId, $betType, $userId, $betOdds, $betamount, $oddmark)
{
			$betQuery = "INSERT INTO bettingdata(arena_id, game_id, bet_type, user_id, bet_odd_id, amount, datecreated, oddmark) " .
						"VALUES (" . $arenaId . "," . $gameId .", '" . $betType  ."', " . 
						 $userId . ", " . $betOdds  . ", " . $betamount . ", now(), '" . $oddmark . "')";	
			mysql_query ($betQuery);
}



	//game statuses
	/*
		'o' = Open
		'bc' = betting close
		'd' = draw
		'dm' = Done meron wins'
		'dw' = Done wala wins'
		'c'= cancelled;
		'p' = Paused;
		'wo' will open;
		'e' = Game Ended
	*/

function UpdateGameAndCurrentGameDisplay($arenaId, $gameId, $gameStatus)
{
	$statusDisplay = "";
	$fightResult = "";
	$gameStart = "";
	$gameEnd = "";
	
	if ($gameStatus == "wo")
	{
		$fightResult = "";
		$statusDisplay = "Betting Will Open Soon";
	}
	elseif ($gameStatus == "o")
	{
		$fightResult = "";
		$statusDisplay = "Betting Open";
	}
	elseif ($gameStatus == "bc")
	{
		$fightResult = "";
		$statusDisplay = "Betting Close";
		$gameStart = ", gamestart=Now() ";
	}
	elseif ($gameStatus == "dm")
	{
		$fightResult = "MERON WINS";
		$statusDisplay = "Betting Close";
		$gameEnd = ", gameend=Now() ";
	}
	elseif ($gameStatus == "dw")
	{
		$fightResult = "WALA WINS";
		$statusDisplay = "Betting Close";
		$gameEnd = ", gameend=Now() ";
	}
	elseif ($gameStatus == "c")
	{
		$fightResult = "Game Cancelled";
		$statusDisplay = "Betting Close";
	}
	elseif ($gameStatus == "d")
	{
		$fightResult = "Game Draw";
		$statusDisplay = "Betting Close";
		$gameEnd = ", gameend=Now() ";
	}
	elseif ($gameStatus == "e")
	{
		$fightResult = "";
		$statusDisplay = "Game Has Been Ended";
	}
		
	
	$query = "UPDATE currentgamedisplay SET gamestatus = '" . $statusDisplay . "', gamewinner = '" . $fightResult ."' " .
			" WHERE arena_id = " . $arenaId;		
	mysql_query($query);		
		
	if ($gameStatus != "e")
	{
		$queryg = "UPDATE game SET gamestatus='" . $gameStatus . "', winner='". $winner. "'" 
										. $gameStart . $gameEnd . " WHERE game_id = " . $gameId;

	} 
   elseif ($gameStatus == "e")
   {
	   	/*
	   	 * update arena table
	   	* make arena offline
	   	*/
	   	$arenaSQL = "UPDATE arena
	   	SET online = '0'
	   	WHERE arena_id = $arenaId";
	   	mysql_query($arenaSQL);
	   	   	
      	$queryg = "UPDATE users SET user_login_status = '0'";
   }
	
	mysql_query($queryg);
}




function CheckForCancellation($betType, $ReturnamountRequest, $betOdds, $GameId, &$Message, $userId)
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
							"ON M.bet_odd_id = W.bet_odd_id WHERE  M.bet_odd_id = " . $betOdds;
	

		
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
		
		$mbetnew = 0;
		$wbetnew = 0;
		$mreturn = 0;
		$wreturn = 0;
		
		ProcessBet($mTotal, $wTotal, $betOddM, $betOddW, $mbetnew, $wbetnew, $mreturn, $wreturn);		
	
	}
	

		$allowedReturn = 0;


		if ($betType == "m")
		{
			if ($mreturn >=  $ReturnamountRequest)
			{
				$allowedReturn = $ReturnamountRequest;
			}
			elseif ($mreturn == 0)
			{
				$allowedReturn = 0;
			}
			elseif ($mreturn > 0)
			{
				$allowedReturn =  $mreturn;
			}
		}
		elseif ($betType == "w")
		{
			if ($wreturn >=  $ReturnamountRequest)
			{
				$allowedReturn = $ReturnamountRequest;
			}
			elseif ($wreturn == 0)
			{
				$allowedReturn = 0;
			}
			elseif ($wreturn > 0)
			{
				$allowedReturn = $wreturn;
			}
		}
		
		return $allowedReturn;
		
		
		
}


function ProcessBetCancellation($GameId, $betType, $betOddId, $deductamount, $userId)
{
	//Get Betting Data;
	$queryGetAllBets = "SELECT * FROM bettingdata WHERE game_id = " . 
	$GameId . " and bet_type = '" . $betType . "' and bet_odd_id = " . 
	$betOddId . " AND user_id = " . $userId . " ORDER BY betting_id DESC";
	
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
			
         InsertPointsHistory($userId, $GameId, $betamount, 2, "Bet Modified by User", GetUsersCurrentBalance($userId));
			//InsertPointsHistory($userId, $betamount, 2, "Bet Modified by User", GetUsersCurrentBalance($userId));
			
			$query2 = "DELETE FROM bettingdata WHERE betting_id = " . $bettingId;
			mysql_query($query2);
		}
		else if (($betamount > $deductamount) && ($deductamount > 0))
		{
			//Return Points to User
			$query = "UPDATE users SET user_credits = user_credits + " . $deductamount . " WHERE user_id = "  . $userId;
			//echo $query . "<br>";
			mysql_query($query);			
			
			//echo "Inserting History. Bet Modified by User <br>";
         InsertPointsHistory($userId, $GameId, $deductamount, 2, "Bet Modified by User", GetUsersCurrentBalance($userId));
			//InsertPointsHistory($userId,  $deductamount, 2, "Bet Modified by User", GetUsersCurrentBalance($userId));
		
			$newbetamount = $betamount - $deductamount;
			$deductamount = 0;
			
			//Decrease betting amount		
			$query2 = "UPDATE bettingdata SET amount = " . $newbetamount . " WHERE betting_id = " . $bettingId;
			//echo $query2 . "<br>";
			mysql_query($query2);						
						
		}
		
	}

}





?>
