<?php

$host = 'localhost';
$dbname = 'ABENMACH_SabongnowProd';
$user = 'coreprodadm';
$pass = '123CoreProdAdm890';

try {
    $success = 1;

    // connect to MySQl thru PDO
    $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    // prepare array for data storage
    $betting_data['gamenumber'] = array();
    $betting_data['user_username'] = array();
    $betting_data['bet'] = array();
    $betting_data['odd'] = array();
    $betting_data['amount'] = array();

} 
catch(PDOException $e) {
    $retData = $e->getMessage();
}

$sql = "SELECT b.betting_id, g.gamenumber, u.user_username AS username, UPPER(b.bet_type) AS bet, o.bet_odd_id,
            IF (UPPER(b.bet_type) = 'W',
             CONCAT(CAST(o.bet_oddw AS CHAR), ' - ', CAST(o.bet_oddm AS CHAR)),
             CONCAT(CAST(o.bet_oddm AS CHAR), ' - ', CAST(o.bet_oddw AS CHAR))) AS odd,
             b.amount, FORMAT(u.user_credits,2) AS user_credits
         FROM bettingdata b
         LEFT JOIN users u
            ON b.user_id = u.user_id
         LEFT JOIN betoddslist o
            ON b.bet_odd_id = o.bet_odd_id
         LEFT JOIN game g
            ON b.game_id = g.game_id
         ORDER BY o.bet_odd_id";

$stmt = $DBH->prepare($sql);
if ($stmt->execute()) {
    // we have records to display
    $rows = $stmt->rowCount();
    if ($rows > 0) {
        // get each row
        $i = 0;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $betting_data[$i]['gamenumber'] = $row['gamenumber'];
            $betting_data[$i]['username'] = $row['username'];
            $betting_data[$i]['bet']  = $row['bet'];
            $betting_data[$i]['bet_odd_id']  = $row['bet_odd_id'];
            $betting_data[$i]['odd']  = $row['odd'];
            $betting_data[$i]['amount']  = $row['amount'];
            $betting_data[$i]['user_credits']  = $row['user_credits'];
            $i++;
        }
    }
    else
        $retData = 'No players are betting yet.';
}

$DBH = null;

print json_encode(array('success' => $success, 'rows' => $rows, 'betting_data' => $betting_data));

?>
