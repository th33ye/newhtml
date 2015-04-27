<?php

include('db.php');

$userid = $_POST['userid'];
/*
$host = 'localhost';
$dbname = 'ABENMACH_SabongnowProd';
$user = 'coreprodadm';
$pass = '123CoreProdAdm890';
*/
try {
    // connect to MySQl thru PDO
    $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    // prepare array for data storage
} 
catch(PDOException $e) {
    $retData = $e->getMessage();
}

$sql = "SELECT user_id, user_login_status FROM users WHERE user_id = '$userid'";
foreach($DBH->query($sql) as $row) {
   $logout = $row['user_login_status'];
}

$DBH = null;

print json_encode(array('logout' => $logout));

?>
