<?php

    session_start();
    require_once('../includes/helpers.php');
    require_once('../includes/dbconn.php');
    require_once('../includes/btnclass.php');
    // $helpers->validate_session($_SESSION['user_user_id'],"../");
    // Return bet_amount
    // Return user credit
    $queryCredit = "SELECT DISTINCT(user_id) FROM runningcredits";
    $execQueryCredit = mysql_query($queryCredit);
    echo "<table border=\"1\">";
    echo "<tr><td>Username</td><td>E-mail</td><td>Country</td><td>Credits</td><td>Date Created</td></tr>";
    while($rowCredit = mysql_fetch_array($execQueryCredit, MYSQL_ASSOC)){
        //echo $rowCredit['user_id']." - ";
        // Get username
        $username = "SELECT user_username, user_email, user_country FROM users WHERE user_id = ".$rowCredit['user_id']."";
        $execUsername = mysql_query($username);
        $rowUsername = mysql_fetch_array($execUsername);
        echo "<tr>";
        echo "<td>".$rowUsername['user_username']."</td><td>".$rowUsername['user_email']."</td><td>".$rowUsername['user_country']."</td>";
        // Get latest date
        $latest = "SELECT credits, date_created FROM runningcredits WHERE user_id = ".$rowCredit['user_id']." ORDER BY date_created DESC LIMIT 1";
        $execlatest = mysql_query($latest);
        $row = mysql_fetch_array($execlatest);
        echo "<td>".$row['credits']."</td><td>".$row['date_created']."</td>";
        echo "</tr>";
    }
    echo "</table>";
    

?>
