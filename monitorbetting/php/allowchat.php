<?php
$userid = $_POST['userid'];

$host = 'localhost';
$dbname = 'ABENMACH_SabongnowProd';
$user = 'coreprodadm';
$pass = '123CoreProdAdm890';

try {
	$success = 1;

	// connect to MySQL thru PDO
	$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
}
catch(PDOException $e) {
	$retData = $e->getMessage();
}

$sql = "UPDATE users SET with_chat = '1' WHERE user_id = '$userid'";

$stmt = $DBH->prepare($sql);
$stmt->execute();

$DBH = null;

print json_encode(array('success' => $success));

?>
