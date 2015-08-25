<?php
    if (!$connection = new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_db)) {
        echo '<div class="title">' . $lang['error'] . '</div>';
        echo $lang['error'] . ' ' . $connection->connect_errno . ': ' . $connection->connect_error;
        die();
    }
?>
<div class="title"><?php echo $lang['change_member_name']; ?></div>
<form id="edit_name" name="edit_name" method="post" action="?p=admin&act=name">
    <p>
        <select name="member">
        <?php
            $db_info = $connection->prepare('SELECT * FROM members');
            $db_info->execute();
            while ($member = $db_info->fetch_array())
                if ($member['username'] != $user)
                    echo '<option value="' . $member['id'] . '">' . $member['name'] . '</option>';
            $connection->close();
        ?>
        </select>
    </p>
    <p><input type="text" name="name" placeholder="<?php echo $lang['name']; ?>" /></p>
    <br />
    <p><input type="submit" name="edit" value="<?php echo $lang['update_account']; ?>" class="button" /></p>
</form>
