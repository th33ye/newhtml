<?php


include 'dbConn.php';
	
$i=0;
	
$result = mysql_query("SELECT * FROM betoddslist order by bet_odd_id");

	$allbet = "<table id='allbet'>";	

	$allbet .= "<tr>";
   $allbet .= "<th id='wala'>WALA</th>";
   $allbet .= "<th id='odd'>ODDS</th>";
   $allbet .= "<th id='meron'>MERON</th>";
   $allbet .= "</tr>";
			
	while ($row = mysql_fetch_array($result))
	{
      if ($i % 2 != 0)
         $r = 0;
      else 
         $r = 1;
         	
		$allbet .= "<tr id='row" . $r . "'>";
      $allbet .= "<td id='wala'>
                  <div class='totbetcol' id='w" . $row['bet_odd_id'] . "'></div>
               </td>";
      $allbet .= "<td id='odd'>
                  " . $row['bet_oddw'] . " - " . $row['bet_oddm'] . "
               </td>";
      $allbet .= "<td id='meron'>
                  <div class='totbetcol' id='m" . $row['bet_odd_id'] . "'></div>
               </td>";
      $allbet .= "</tr>";
      $i++;
	}
	
	$allbet .= "</table>";
	
mysql_free_result($result);		
mysql_close();

echo $allbet;

?>
