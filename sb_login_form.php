<h2>Sign in</h2>
<form name="frm" method="post" action="login_process.php">
	<div class="email-div">
		<label for="username">
			<strong class="username-label">Username</strong>
		</label>
		<input type="text" name="username" id="username">
	</div>
	<div class="passwd-div">
		<label for="passwd">
			<strong class="passwd-label">Password</strong>
		</label>
		<input type="password" name="passwd" id="passwd">
	</div>
	<input type="submit" name="SignIn" id="SignIn" value="Sign in" />
</form>
<ul>
	<li>
		<a href="sbnew_register.php">Create an account</a>
	</li>
</ul>

<?php
	if (isset($_SESSION['errormessage']) && $_SESSION['errormessage'] <> "") {
		echo '<span style="color:#FFFF00; font-size: 12; line-height: 17px;">' . $_SESSION['errormessage'] . '</span></td>';
	}
?>