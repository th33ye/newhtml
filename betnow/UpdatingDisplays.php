<?php

include 'dbConn.php';


function getAllBets($gameId, $arenaId)
{
	$result = mysql_query("SELECT bet_type, bet_odd_id, SUM(amount) as Total FROM bettingdata WHERE game_id = " . $gameId . 
					" AND arena_id = "  . $arenaId . " GROUP BY bet_odd_id, bet_type, arena_id ");
	
	$outputStr = "";
	
	while ($row = mysql_fetch_array($result))
	{
		$num = $row['Total'];
			
		$outputStr = $outputStr . $row['bet_type'] . $row['bet_odd_id'] . "|" . number_format($num, 2, '.', '');
		$outputStr  = $outputStr . ",";
	}
	
	mysql_free_result($result);
	
	return $outputStr;
}


function getUserBets($gameId, $arenaId, $userId)
{
			
		$result = mysql_query("SELECT user_id, bet_type, bet_odd_id, SUM(amount) as Total FROM bettingdata WHERE game_id = " . $gameId 		
				. " AND arena_id = "  . $arenaId . " AND  user_id = " . $userId . " GROUP BY bet_odd_id, bet_type, arena_id ");
		
		
		$outputStr = "";
		
		while ($row = mysql_fetch_array($result))
		{
			$num = $row['Total'];
				
			$outputStr = $outputStr . "b" . $row['bet_type'] . "-". $row['bet_odd_id'] . "|" . number_format($num, 2, '.', '');
			$outputStr  = $outputStr . ",";
		}

		mysql_free_result($result);
		
		return $outputStr;
		


}

function getCurrentGameDisplay($arenaId, &$gameId)
{
	
	$result = mysql_query("SELECT * FROM currentgamedisplay WHERE arena_id = " . $arenaId );
	
	$outputStr = "";
	
	while ($row = mysql_fetch_array($result))
	{
		$outputStr = $row['game_id'] . "|" . $row['gamenumber'] . "|" . $row['gamestatus'] . "|" . $row['gamewinner'];
		$gameId = $row['game_id'];
	}	
	
	
	mysql_free_result($result);
	
	return $outputStr;
}


function GetUsersCurrentBalance($userId)
{	
		$usercredits = 0;
		$queryGetCurrentBalance = "SELECT user_credits FROM users WHERE user_id = " . $userId;
		//$queryGetCurrentBalance = "SELECT FORMAT(user_credits,3) FROM users WHERE user_id = " . $userId;
		$resultBalance = mysql_query($queryGetCurrentBalance);
		
 		while ($row = mysql_fetch_array($resultBalance))
		{
			$usercredits = $row['user_credits'];
			//$usercredits = number_format($row['user_credits'], 2, '.', '');	

		}
		
		mysql_free_result($resultBalance);
		
		return number_format($usercredits, 2, '.', ''); 
		//return $usercredits;
}

	$arenaId = $_POST['arenaId'];
	$userId = $_POST['userId'];
	$gameId = "";
	
	$gameDisplay =  getCurrentGameDisplay($arenaId, $gameId);
	$allBets =  getAllBets($gameId, $arenaId);
	$userCredit = GetUsersCurrentBalance($userId);

   mysql_close($connected);	
	 echo $gameDisplay . "|" . $userCredit . "/" .  $allBets;
	 
	 // getAllBets($gameId, $arenaId) . "/" . 
	 // getCurrentGameDisplay($arenaId) . "/". 
 	 //getUserBets($gameId, $arenaId, $userId) . "/" . 


?>
