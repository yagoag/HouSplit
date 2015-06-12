<?php
    if ($connection = new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_db)) {
        $query = $connection->prepare('SELECT * FROM members WHERE username = ?');
        $query->bind_param('s', $_SESSION['username']);
        $query->execute();
        $db_info = $query->get_result()->fetch_assoc();
        $connection->close();
?>
<div class="title"><?php echo $lang['account_settings']; ?></div>
<form id="account_settings" name="account_settings" method="post" action="?act=account">
    <p><input type="text" size="35" name="name" class="textbox" placeholder="<?php echo $lang['name']; ?>" value="<?php echo $db_info['name']; ?>" /></p>
    <p><input type="password" size="35" name="new_password" placeholder="<?php echo $lang['new_password']; ?>" class="textbox" /></p>
    <p><input type="password" size="35" name="new_password_check" placeholder="<?php echo $lang['new_password_check']; ?>" class="textbox" /></p>
    <br />
    <p><input type="password" size="35" name="old_password" placeholder="<?php echo $lang['old_password']; ?>" class="textbox" /></p>
    <br />
    <p><input type="submit" name="account_settings" value="<?php echo $lang['update_account']; ?>" class="button" /></p>
</form>
<?php
    } else {
        echo '<div class="title">' . $lang['error'] . '</div>';
        echo $lang['error'] . ' ' . $connection->connect_errno . ': ' . $connection->connect_error;
    }
?>