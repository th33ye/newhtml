<?php

include('db.php');

$userid = $_POST['userid'];
//$userid = '8619';
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

$sql = "SELECT user_id, user_credits FROM users WHERE user_id = '$userid'";
$block = '1';
foreach($DBH->query($sql) as $row) {
   $user_credit = (int)$row['user_credits'];
   $bsql = "SELECT SUM(amount) AS bettotal FROM bettingdata WHERE user_id = '$userid'";
   foreach($DBH->query($bsql) as $brow) {
      if (is_null($brow['bettotal']))
         $b_credit = 0;
      else
         $b_credit = (int)$brow['bettotal'];
   }
//   $block = $user_credit + $b_credit;
   if (($user_credit + $b_credit) >= 10)
      $block = '0';
}

$DBH = null;

print json_encode(array('block' => '0'));

?>
