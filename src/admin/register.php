<div class="title"><?php echo $lang['register_title']; ?></div>
<form id="register_form" name="register_form" method="post" action="?p=admin&act=register">
    <p><input type="text" size="35" name="name" placeholder="<?php echo $lang['name']; ?>" class="textbox" /></p>
    <p><input type="text" size="35" name="username" placeholder="<?php echo $lang['username']; ?>" class="textbox" /></p>
    <p><input type="password" size="35" name="password" placeholder="<?php echo $lang['password']; ?>" class="textbox" /></p>
    <p><input type="checkbox" name="admin" value="True"><?php echo $lang['member_is_admin']; ?></p>
    <br />
    <p><input type="submit" name="register" value="<?php echo $lang['register_title']; ?>" class="button" /></p>
</form>