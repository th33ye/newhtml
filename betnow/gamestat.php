<?php
/*
    gamestat.php
    process the displaying of game result
 
    Created by: dPhoenix
 */
include_once('dbconn-chat.php');

if ($_POST['function'] == 'gameresult') {
	$sql = "SELECT gamenumber, gamestatus, gamewinner FROM currentgamedisplay WHERE arena_id = {$_POST['arena']}";
	$STH = $DBH->query($sql);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$row = $STH->fetch();

	$game = array('gamenumber'=>$row->gamenumber,'gamestatus'=>$row->gamestatus,'gameresult'=>$row->gamewinner);
    echo json_encode($game);
}

?>
