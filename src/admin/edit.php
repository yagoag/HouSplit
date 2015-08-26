<?php
    if (!$connection = new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_db)) {
        echo '<div class="title">' . $lang['error'] . '</div>';
        echo $lang['error'] . ' ' . $connection->connect_errno . ': ' . $connection->connect_error;
        die();
    }
?>
<div class="title"><?php echo $lang['edit_member']; ?></div>
<form id="edit_account" name="edit_account" method="post" action="?p=admin&act=edit">
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
    <p><input type="checkbox" name="deactivate" value="True"><?php echo $lang['deactivate_account']; ?></p>
    <p><input type="checkbox" name="admin" value="True"><?php echo $lang['member_is_admin']; ?></p>
    <br />
    <p><input type="submit" name="edit" value="<?php echo $lang['update_account']; ?>" class="button" /></p>
</form>
