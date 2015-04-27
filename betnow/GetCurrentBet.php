<?php

require("GlobalFunctions.php");

		
$betOdds = $_POST['betOdds'];
$userId = $_POST['userId'];
$gameId = $_POST['gameId'];	
$betType = $_POST['betType'];	


//$betOdds = 1;
//$userId = 1;
//$gameId = 109;
	
$totalBetOnOdd = 0;
$totalBetOnOdd = GetTotalBetOfUser($userId, $betOdds, $gameId, $betType);
echo $totalBetOnOdd;

?>