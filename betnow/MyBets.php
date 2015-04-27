<?php

include 'dbConn.php';

$userId = $_POST['userId'];
$gameId = $_POST['gameId'];
$arenaId = $_POST['arenaId'];


$result = mysql_query("SELECT user_id, bet_type, bet_odd_id, SUM(amount) as Total FROM bettingdata WHERE game_id = " . $gameId . " AND arena_id = "  . $arenaId . " AND  user_id = " . $userId . " GROUP BY bet_odd_id, bet_type, arena_id ");


$outputStr = "";

while ($row = mysql_fetch_array($result))
{
	$num = $row['Total'];
		
	$outputStr = $outputStr . "b" . $row['bet_type'] . "-". $row['bet_odd_id'] . "|" . number_format($num, 2, '.', '');
	$outputStr  = $outputStr . ",";
}

echo $outputStr;

mysql_free_result($result);
mysql_close();

?>
