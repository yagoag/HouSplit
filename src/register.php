<div class="title"><?php echo $lang['register_title']; ?></div>
<form id="register_form" name="register_form" method="post" action="?act=register">
    <p><input type="text" name="name" placeholder="<?php echo $lang['name']; ?>" class="textbox" /></p>
    <p><input type="text" name="username" placeholder="<?php echo $lang['username']; ?>" class="textbox" /></p>
    <p><input type="password" name="password" placeholder="<?php echo $lang['password']; ?>" class="textbox" /></p>
    <br />
    <p><input type="submit" name="register" value="<?php echo $lang['register_title']; ?>" class="button" /></p>
</form>