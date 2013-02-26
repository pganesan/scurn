<?php
include 'DBUtil.php';
session_start();
// clear session
session_destroy();
?>

<form action="logout.php" method="post" id="login" name="login">
		<p id="loginError" class="ui-state-error ui-corner-all">
			<span class="ui-icon ui-icon-alert"></span>
			<span></span>
		</p>
	<label for="user">Username
		<br />
		<input type="text" id="user" name="user" value="" size="20" maxlength="20"/>
	</label>
	<br />
	<br />
	<label for="pass">Password
		<br />
		<input type="password" id="pass" name="pass" value="" size="20" maxlength="20" />
	</label>
	<br />
	<br />
	<input type="submit" value="Sign in" id="loginButton" name="loginButton" />
	&nbsp;&nbsp;&nbsp; <button id="newuser"><span class="ui-icon ui-icon-person"></span>New user?</button>
</form>
