<?php
// Created by Arvin C. San Andres
session_start();
// Connect to the database first thing
require_once "dbconn-chat.php";

//$_POST['requester'] = "new_chat";
//$_POST['arena'] = '1';
//$_POST['stored_id'] = '1';
//$_SERVER['REMOTE_ADDR'] = "127.0.0.1"; 
//$_POST['user_name'] = "phoenix";
//$_POST['chat_body'] = "test";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Section 1 - Corresponds with section 1 in our flash AS3 script - Initial chat body request

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_POST['requester'] == "initial_request") {
   
    $status_line = "initial load";
    $body = "";
    $STH = $DBH->query("SELECT id, user_name, chat_body, date_time FROM chats ORDER BY date_time"); 
    $STH->setFetchMode(PDO::FETCH_OBJ);
    while($row = $STH->fetch()) { 
        $id = $row->id;
	    $user_name = $row->user_name;
	    $chat_body = $row->chat_body;
	    $date_time = $row->date_time;
	    $chat_body = stripslashes($row->chat_body);
        //$chat_body = eregi_replace("&#39;", "'", $chat_body);
		//$chat_body = preg_replace("&#39;", "'", htmlspecialchars($chat_body, ENT_QUOTES));
	
        $body .= '<b><font color="#006699">' . $user_name . ': </font></b> 
	    <font color="#0F0F0F" size="+2"> ' . $chat_body . '</font>
        <br />';

		$usql = "UPDATE chats SET new_chat = '0' WHERE id = {$id}";
		$DBH->query($usql);	
    }
    $STH = $DBH->query("SELECT id FROM chats ORDER BY id DESC LIMIT 1"); 
    $STH->setFetchMode(PDO::FETCH_OBJ);    
    $row = $STH->fetch();
    $stored_id = $row->id;    
    /*
	$sql = mysql_query("SELECT id FROM chats ORDER BY id DESC LIMIT 1");
	$stored_id = 0;
    while($row = mysql_fetch_array($sql)) { 
	    $stored_id = $row["id"];
    }
     * 
     */
    $sql = "SELECT gamenumber, gamestatus, gamewinner FROM currentgamedisplay WHERE arena_id = {$_POST['arena']}";
    $STH = $DBH->query($sql);
    $STH->setFetchMode(PDO::FETCH_OBJ);
    $row = $STH->fetch();

    //echo "stored_id=$stored_id&statusline=$status_line&username=$user_name&game_no=$game_no&game_status=$game_status&game_result=$game_result&returnBody=$body";
    echo "stored_id=$stored_id&statusline=$status_line&username=$user_name&game_no={$row->gamenumber}&game_status={$row->gamestatus}&game_result={$row->gamewinner}&returnBody=$body";

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Section 2 - Corresponds with section 2 in our flash AS3 script - check for new chats

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_POST['requester'] == "chat_check") {
	
	$latest_id = 0;
	$status_line = "not_new";
	$stored_id = $_POST['stored_id'];
    $STH = $DBH->query("SELECT id FROM chats ORDER BY id DESC LIMIT 1"); 
    $STH->setFetchMode(PDO::FETCH_OBJ);    
    $row = $STH->fetch();
    $latest_id = $row->id;
    $body = "";
    $user_name = "";
    /*
    $sql = mysql_query("SELECT id FROM chats ORDER BY id DESC LIMIT 1"); 
    while($row = mysql_fetch_array($sql)) { 
	    $latest_id = $row["id"];
    }
     * 
     */
	
    if ($latest_id > $stored_id) {
         
		 $status_line = "is_new";
// 	     $body = "";

        $STH = $DBH->query("SELECT id, user_name, chat_body, date_time FROM chats ORDER BY date_time"); 
        $STH->setFetchMode(PDO::FETCH_OBJ);
         
//         $sql = mysql_query("SELECT * FROM chats ORDER BY date_time"); 
        while($row = $STH->fetch()) {
            $id = $row->id;
            $user_name = $row->user_name;
            $chat_body = $row->chat_body;
            $date_time = $row->date_time;
            $chat_body = stripslashes($row->chat_body);
			//$chat_body = eregi_replace("&#39;", "'", $chat_body);
			//$chat_body = preg_replace("&#39;", "'", htmlspecialchars($chat_body, ENT_QUOTES));

            $body .= '<b><font color="#006699">' . $user_name . ': </font></b> 
            <font color="#0F0F0F" size="+2"> ' . $chat_body . '</font>
            <br />';		  
        
//			$usql = "UPDATE chats SET new_chat = '0' WHERE id = {$row['id']}";
//			mysql_query($usql);		  
            
    		$usql = "UPDATE chats SET new_chat = '0' WHERE id = {$id}";
        	$DBH->query($usql);	
        }
          
//        echo "stored_id=$stored_id&statusline=$status_line&username=$user_name&game_no=$game_no&game_status=$game_status&game_result=$game_result&returnBody=$body";         
//		  echo "stored_id=$latest_id&statusline=$status_line&returnBody=$body";
	}
    $sql = "SELECT gamenumber, gamestatus, gamewinner FROM currentgamedisplay WHERE arena_id = {$_POST['arena']}";
    $STH = $DBH->query($sql);
    $STH->setFetchMode(PDO::FETCH_OBJ);
    $row = $STH->fetch();

    echo "stored_id=$latest_id&statusline=$status_line&username=$user_name&game_no={$row->gamenumber}&game_status={$row->gamestatus}&game_result={$row->gamewinner}&returnBody=$body";            
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Section 3 - Corresponds with section 3 in our flash AS3 script - parsing new chats that are submitted

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_POST['requester'] == "new_chat") {

    $user_ip = $_SERVER['REMOTE_ADDR']; 
    $user_name = $_POST['user_name'];
    $chat_body = $_POST['chat_body'];

    // Cleanse user input of SQL injection attacks before going to database		
    //$chat_body = eregi_replace("'", "&#39;", $chat_body);
    //$chat_body = eregi_replace("`", "&#39;", $chat_body);
    //$chat_body = preg_replace("'", "&#39;", htmlspecialchars($chat_body, ENT_QUOTES));	 
    //$chat_body = preg_replace("`", "&#39;", htmlspecialchars($chat_body, ENT_QUOTES));
    //$chat_body = mysql_real_escape_string($chat_body);

    // delete any chat posts off of the tail end ------------------
    /*   $sqldeleteComments = mysql_query("SELECT id FROM chats ORDER BY date_time ASC LIMIT 0,1"); 

    while($row = mysql_fetch_array($sqldeleteComments)){ 
                $cb_id = $row["id"];
                $deleteComments = mysql_query("DELETE FROM chats WHERE id='$cb_id'"); 
    }   */
    // End delete any comments off of the tail end -------------	 
    // Add this chat to the chat table
    $STH = $DBH->prepare("INSERT INTO chats (user_ip, user_name, chat_body, date_time) 
                 VALUES(?,?,?,now())");
    $STH->execute(array($user_ip, $user_name, $chat_body));
    $latest_id = $DBH->lastInsertId();
    //$sql = mysql_query("INSERT INTO chats (user_ip, user_name, chat_body, date_time) 
//                VALUES('$user_ip','$user_name','$chat_body',now())")  
//            or die (mysql_error());

//    $latest_id = mysql_insert_id();

    $statusline = "";
    $body = "";
    $STH = $DBH->query("SELECT id, user_name, chat_body, date_time FROM chats WHERE new_chat = '1' ORDER BY date_time"); 
    $STH->setFetchMode(PDO::FETCH_OBJ);     
//     $sql = mysql_query("SELECT * FROM chats WHERE new_chat = '1' ORDER BY date_time"); 
//     while($row = mysql_fetch_array($sql)) {
    while($row = $STH->fetch()) {
        $id = $row->id;
        $user_name = $row->user_name;
        $chat_body = $row->chat_body;
        $date_time = $row->date_time;
        $chat_body = stripslashes($row->chat_body);
         //$chat_body = eregi_replace("&#39;", "'", $chat_body);
		 //$chat_body = preg_replace("&#39;", "'", htmlspecialchars($chat_body, ENT_QUOTES));
	
        $body .= '<b><font color="#006699">' . $user_name . ': </font></b> 
        <font color="#0F0F0F" size="+2"> ' . $chat_body . '</font>
        <br />';		  
        
//		$usql = "UPDATE chats SET new_chat = '0' WHERE id = {$row['id']}";
//		mysql_query($usql);
        $usql = "UPDATE chats SET new_chat = '0' WHERE id = {$id}";
        $DBH->query($usql);	
    }
    
    $sql = "SELECT gamenumber, gamestatus, gamewinner FROM currentgamedisplay WHERE arena_id = {$_POST['arena']}";
    $STH = $DBH->query($sql);
    $STH->setFetchMode(PDO::FETCH_OBJ);
    $row = $STH->fetch();

    echo "stored_id=$latest_id&statusline=$statusline&username=$user_name&game_no={$row->gamenumber}&game_status={$row->gamestatus}&game_result={$row->gamewinner}&returnBody=$body"; 
     
//    echo "stored_id=$stored_id&statusline=$status_line&username=$user_name&game_no=$game_no&game_status=$game_status&game_result=$game_result&returnBody=$body";   
    // echo "stored_id=$latest_id&statusline=poopoo&returnBody=$body";

} // close first if for post
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// close the mysql connection we made at the top of our script
$DBH = null;
?>
