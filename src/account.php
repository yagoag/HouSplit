<?php
    // Set up MySQL connection
    $db_handler = mysql_connect($mysql_server, $mysql_username, $mysql_password);
    $db_found = mysql_select_db($mysql_db, $db_handler);

    // (Try to) Select row with user's info 
    $db_info = mysql_query("SELECT * FROM members WHERE username = '$user'");
    if ($db_info)
        // Turns query's result into an array with its info
        $db_info = mysql_fetch_assoc($db_info);
?>
<div class="title"><?php echo $lang['account_settings']; ?></div>
<form id="account_settings" name="account_settings" method="post" action="?act=account">
    <p><input type="text" name="name" class="textbox" placeholder="<?php echo $lang['name']; ?>" value="<?php echo $db_info['name']; ?>" /></p>
    <p><input type="password" name="new_password" placeholder="<?php echo $lang['new_password']; ?>" class="textbox" /></p>
    <p><input type="password" name="new_password_check" placeholder="<?php echo $lang['new_password_check']; ?>" class="textbox" /></p>
    <br />
    <p><input type="password" name="old_password" placeholder="<?php echo $lang['old_password']; ?>" class="textbox" /></p>
    <br />
    <p><input type="submit" name="account_settings" value="<?php echo $lang['update_account']; ?>" class="button" /></p>
</form>