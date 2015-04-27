<?php 
// place your DB_host, UserName, Password, and DB_Name below where shown
//mysql_connect("databaseHost","username","password") or die ("Could not connect.");
//mysql_select_db("databaseName") or die ("no database");

//mysql_connect("localhost","coreprodadm","123CoreProdAdm890") or die ("Could not connect.");
//mysql_select_db("ABENMACH_SabongnowProd") or die ("no database");
/*
$dbIConn = new mysqli("localhost","coreprodadm","123CoreProdAdm890","ABENMACH_SabongnowProd");

if ($dbIConn->connect_error) {
    die('Connect Error');
}
*/

$dbhost = "localhost";
$dbname = "ABENMACH_SabongnowProd";
$dbuser = "coreprodadm";
$dbpass = "123CoreProdAdm890";

try {
    # MySQL with PDO_MYSQL
    $DBH = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);  
}  
catch(PDOException $e) {  
    echo $e->getMessage();  
}

?>
