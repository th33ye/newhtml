<?php

include 'dbConn.php';
$result = mysql_query("SELECT * FROM betoddslist");
$outputStr = ""; 

while ($row = mysql_fetch_array($result))
{				
	$outputStr = $outputStr . "w" . $row['bet_odd_id'] . ",";
	$outputStr = $outputStr . "m" . $row['bet_odd_id'] . ",";
}


echo $outputStr;
mysql_close();


?>
