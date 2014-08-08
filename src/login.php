<?php
    if ($loggedin)
        header("Location: index.php");
?>
<div class="title"><?php echo $lang['login']; ?></div>
<form id="login_form" name="login_form" method="post" action="?act=login">
    <p><input type="text" size="35" name="username" placeholder="<?php echo $lang['username']; ?>" class="textbox" /></p>
    <p><input type="password" size="35" name="password" placeholder="<?php echo $lang['password']; ?>" class="textbox" /></p>
    <br />
    <p><input type="submit" name="login" value="<?php echo $lang['login']; ?>" class="button" /></p>
</form>