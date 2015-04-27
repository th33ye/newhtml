<?php

$host = 'localhost';
$dbname = 'ABENMACH_SabongnowProd';
$user = 'coreprodadm';
$pass = '123CoreProdAdm890';

try {
    $success = 1;
    $tot_given_promo = 0;

    // connect to MySQl thru PDO
    $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

} 
catch(PDOException $e) {
    $retData = $e->getMessage();
}
$sql = "SELECT SUM(wu_bonus_credit) AS tot_given_promo FROM westernunion";

$stmt = $DBH->prepare($sql);
if ($stmt->execute()) {
    // we have records to display
    if ($stmt->rowCount()) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $tot_given_promo = $row['tot_given_promo'];
   }
} else {
        $retData = 'No players are betting yet.';
}

$DBH = null;

print json_encode(array('success' => $success, 'tot_given_promo' => $tot_given_promo));

?>
