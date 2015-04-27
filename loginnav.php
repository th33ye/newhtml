
<script language="JavaScript" type="text/JavaScript">
        gameWin = null;
        function openGameWindow() {
        
            var openNew = true;
            if (gameWin) { if (!gameWin.closed) openNew = false; }
            if (openNew) {
                var w = 1024;
                var h = 768;
                var x = ((screen.width/2) - (w/2));
                var y = ((screen.height/2) - (h/2));
               /*
			    if (window.screen) {
                    w = screen.width;
                    h = screen.height;
                }*/
                var phpFile = "game.php";
                gameWin = window.open(phpFile,
	  "Game", "toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0," +
	  "resizable=1,width=" + w + ",innerWidth=" + w + ",height=" + h + ",innerHeight=" + h +
	  ",left=" + x + ",top=" + y + ",screenX=" + x + ",screenY=" + y);
            }
            gameWin.focus();
        }
</script>
<?php
	/* check if there's an online arena
	 * and display the link for arena
	 * else display "Arena Offline"  
	 */
	include 'dbconn.php';   // mysqli
	$arenaSQL = "SELECT arena_id, arena_name FROM arena WHERE online";
	$cnt = 0;
	if ($result = mysqli_query($link, $arenaSQL)) 
	{
		$cnt = mysqli_num_rows($result);
		// if theres online arena $cnt is not zero
		if ($cnt > 0)
		{ 
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$_SESSION['user_arena_id'] = $row['arena_id'];
			$_SESSION['arenaId'] = $row['arena_id'];
			$_SESSION['arena'] = $row['arena_name'];
		}
	} 
?>

<h2>Welcome, <?php echo $_SESSION['user_username'];?>!</h2>
<ul>
	<li>
		<?php
			if ($cnt==0)
			{
		?>
				<span>Arena Offline</span>
		<?php
			} 
			else 
			{
				if ($_SESSION['vip'])
				{
					$url = "betnow/GamePlayer-wsy.php?qs=" . $_SESSION['user_id'];
				}
				else if ($_SESSION['user_credits'] < 5)
				{
					if ($_SESSION['with_chat'])
						$url = "betnow/GamePlayer-wsy.php?qs=" . $_SESSION['user_id'];
					else 
						$url = "betnow/GamePlayer-strip.php?qs=" . $_SESSION['user_id'];
				}
				else if ($_SESSION['user_credits'] >= 5)
				{
					if ($_SESSION['with_chat'])
						$url = "betnow/GamePlayer-wsy.php?qs=" . $_SESSION['user_id'];
					else
						$url = "betnow/GamePlayer-working-wout-chat.php?qs=" . $_SESSION['user_id'];
				}
		?>
				<span><a href=<?php echo $url; ?>><?php echo ucfirst($row['arena_name']) . " Online"; ?></a></span> 
		<?php 		
			} 
		?>	
	</li>
	<li>
		<a href="sbnew_bettinghistory.php">Bet History</a>
	</li>
	<li>
		<a href="sbnew_changepassword.php">Change Password</a>
	</li>
	<li>
		<a href="logout.php">Logout</a>
	</li>
</ul>
