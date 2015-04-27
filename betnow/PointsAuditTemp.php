<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="PointsauditTemp.php" method="post">
<input name="UserId" type="text" />
<input name="" type="submit" />
</form>

<?php



if (!empty($_POST['UserId']))
{
include 'dbConn.php';

	$userId = $_POST['UserId'];
			
	$result = mysql_query("select * from pointsaudit where user_id = " . $userId . " ORDER by pointsaudit_id");
	
	
		echo "<table width='100%' border='1' cellspacing='0' cellpadding='0' bgcolor='#FFFFFF'>";	
	
		echo "<tr><td>transactiondate</td><td>transactedamount</td><td>description</td><td>remainingbalance</td></tr>";
			
				
		while ($row = mysql_fetch_array($result))
		{	
		   echo "<tr><td>" . $row['transactiondate'] . "</td><td>". $row['transactedamount']. "</td><td>". $row['description'] . "</td><td>". $row['remainingbalance'] ."</td></tr>";
		}
		
		mysql_free_result($result);
		
		echo "</table>";
			
	mysql_free_result($result);
	mysql_close();

}

?>

</body>
</html>

