<?php
$userid = $_POST['userid'];

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

$sql = "UPDATE users SET pop_block = '0' WHERE user_id = '$userid'";

$stmt = $DBH->prepare($sql);
$stmt->execute();

$DBH = null;

print json_encode(array('success' => $success));

?>
