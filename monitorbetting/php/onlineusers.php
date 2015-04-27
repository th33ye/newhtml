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
} 
catch(PDOException $e) {
    $retData = $e->getMessage();
}

$sql = "SELECT user_id, user_username, UPPER(user_country) AS country,
             FORMAT(user_credits,2) AS user_credits
         FROM users
         WHERE user_login_status = '1'";

$stmt = $DBH->prepare($sql);
if ($stmt->execute()) {
    // we have records to display
    $rows = $stmt->rowCount();
    if ($rows > 0) {
        // get each row
        $i = 0;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users_online[$i]['user_id'] = $row['user_id'];
            $users_online[$i]['user_username'] = $row['user_username'];
            $users_online[$i]['country']  = $row['country'];
            $users_online[$i]['user_credits']  = $row['user_credits'];
            $i++;
        }
    }
    else
        $retData = 'No players online yet.';
}

$DBH = null;

print json_encode(array('success' => $success, 'rows' => $rows, 'users_online' => $users_online));

?>
