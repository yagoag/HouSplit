<?php
    if ($loggedin)
        header("Location: index.php");
?>
<div id="login-container">
	<form id="login-form" name="login-form" method="post" action="action/login.php">
		<input type="text" name="username" placeholder="Username" class="textBox" />
		<input type="password" name="password" placeholder="Password" class="textBox" />
		
		<input type="submit" name="login" value="Login" class="button" />
	</form>
</div>