<?php

session_start();

$host = 'localhost';
$dbname = 'ABENMACH_SabongnowProd';
$user = 'coreprodadm';
$pass = '123CoreProdAdm890';

try {
    $success = 1;

    // connect to MySQl thru PDO
    $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    // prepare array for data storage
    $fight_data['arena_id'] = array();
    $fight_data['gamenumber'] = array();
    $fight_data['gamestatus'] = array();
}
catch(PDOException $e) {
    $retData = $e->getMessage();
}

$sql = "SELECT arena_id, gamenumber, gamestatus
        FROM game
		WHERE arena_id = '" . $_SESSION['arenaId'] . "' and gamestart >= '2015-04-26 07:00:00'";

/*$sql = "SELECT arena_id, gamenumber, gamestatus
        FROM game
		WHERE arena_id = '" . $_SESSION['arenaId'] . "' and gamestart >= CURDATE()";
 */
    
/*$sql = "SELECT g.game_id, g.arena_id, g.gamenumber, g.gamestatus, g.gamestart, g.gameend,
            SUM(s.amountgiven) AS totalbet, SUM(s.commissionamount) AS rake 
         FROM game g 
         LEFT JOIN sabongpointsbank s
            ON g.game_id = s.fromgame_id
         WHERE gamestart >= CURDATE()
         GROUP BY game_id, arena_id 
         ORDER BY gamestart";
*/     

$stmt = $DBH->prepare($sql);
if ($stmt->execute()) {
    // we have records to display
    $rows = $stmt->rowCount();
    if ($rows > 0) {
        // get each row
        $i = 0;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//            $fight_data[$i]['arena_id'] = $row['arena_id'];
            $gs = "";
            $fight_data[$i]['gamenumber'] = $row['gamenumber'];
            switch ($row['gamestatus']) {
                case "dw":
                    $gs = "W";
                    break;
                case "dm":
                    $gs = "M";
                    break;
                case "c":
                    $gs = "C";
                    break;
                case "d":
                    $gs = "D";
					break;
				default:
					$gs = " ";
            }
                
           $fight_data[$i]['gamestatus']  = $gs;
//            $fight_data[$i]['gamestatus']  = $row['gamestatus'];
//            $fight_data[$i]['bets']  = number_format($row['totalbet'] + $row['rake'], 2, '.', ',');
//            $fight_data[$i]['rake']  = number_format($row['rake'], 2, '.', ',');
            $i++;
        }
    }
    else
        $retData = 'No players are betting yet.';
}

$DBH = null;

print json_encode(array('success' => $success, 'rows' => $rows, 'fight_data' => $fight_data));

?>
