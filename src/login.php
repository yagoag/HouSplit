<?php
    if ($loggedin)
        header("Location: index.php");
?>
<div class="title">Login</div>
<form id="login_form" name="login_form" method="post" action="?act=login">
    <p><input type="text" name="username" placeholder="Username" class="textbox" /></p>
    <p><input type="password" name="password" placeholder="Password" class="textbox" /></p>
    <br />
    <p><input type="submit" name="login" value="Login" class="button" /></p>
</form>