<?php
	session_start();
	if (!isset($_SESSION['admin_username'])) {
		header("location:index.php");
	}
	if ($_SESSION['admin_username'] !== "monitor") {
		header("location:index.php");
	}
?>
