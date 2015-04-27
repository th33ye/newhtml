<?php

include 'dbConn.php';
	
$result = mysql_query("SELECT * FROM betoddslist order by bet_odd_id");

	$mybet = "<table id='mybet'>";	

	$mybet .= "<tr>" .
		 "<th>WALA</th> " .
		 "<th>ODDS</th> " .
		 "<th>MERON</th> ".
 		 "<th id='hidecol'>&nbsp;</th> " .	
 		 "<th>WINNING</th> " .	
		 "</tr>";
			
	while ($row = mysql_fetch_array($result))
	{	
		$mybet .= "<tr> " . 
			 "<td align='center' style='color:green'> " . 
			 	"<input type='text' name='bw-" . $row['bet_odd_id'] . "' id='bw-" . $row['bet_odd_id'] . 
				 "' size='5px' maxlength='6' style='text-align:center' onkeypress=\"keyPressed(event, this)\"/>" .
  			     "<input type='hidden' name='bw-" . $row['bet_odd_id'] . "h' id='bw-" . $row['bet_odd_id'] . "h' value=''/>"  .
			 "<td style='color:red' align='center' id='OddId-" . $row['bet_odd_id'] . "'>" . $row['bet_oddw'] . "-" . $row['bet_oddm'] . "</td>" .
			 "<td align='center' style='color:blue'> " .
			  "<input type='text' name='bm-" . $row['bet_odd_id'] . 
			  "' id='bm-" . $row['bet_odd_id'] . 
			  "' size='5px' maxlength='6' style='text-align:center'  onkeypress=\"keyPressed(event, this)\"/>" .
			  "<input type='hidden' name='bm-" . $row['bet_odd_id'] . "h' id='bm-" . $row['bet_odd_id'] . "h' value=''/>" .			  
			  "</td>" .
 	 		 "<td id='hidecol'></td> " .	
  	 		 "<td class='colWin' name='win" . $row['bet_odd_id'] . "' id='win" . $row['bet_odd_id'] . "'>0.00</td> " .	
			 "</tr>";		
	}
	
	//<input  type='text' id='bw" . $row['bet_odd_id'] . "' style='width:20'></td>
	//<input type='text' id='bm" . $row['bet_odd_id'] . "' style='width:20'>	
	$mybet .= "</table> <input type='button' id='btnPlacebet' onclick='clearBetTable();LoadMyBets()' value='Re-confirm Placed Bets'/>";
	
   mysql_free_result($result);		
   mysql_close();

   echo $mybet;
?>


