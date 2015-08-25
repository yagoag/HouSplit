<?php
    if ($connection = new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_db)) {
        $db_info = $connection->prepare('SELECT * FROM members');
        $db_info->execute();
        $connection->close();
?>
<div class="title"><?php echo $lang['new_bill_title']; ?></div>
<form id="new_payment" name="new_payment" method="post" action="?act=bill">
    <p><input type="text" size="35" name="name" placeholder="<?php echo $lang['name']; ?>" /></p>
    <p><input type="text" size="35" name="value" placeholder="<?php echo $lang['value']; ?>" /></p>
    <br />
    <div class="member_list">
        <p><input type="checkbox" onClick="toggle(this)" /> <strong><?php echo $lang['select_all_members']; ?></strong></p>
        <?php
            while ($member = $db_info->fetch_array())
                if ($member['username'] != $_SESSION['username'] && $member['active'])
                    echo '<p><input type="checkbox" name="members[]" value="' . $member['id'] . '" /> ' . $member['name'] . '</p>';
        ?>
    </div>
    <br />
    <p><input type="submit" name="new_payment" value="<?php echo $lang['add_bill']; ?>" /></p>
</form>
<script type="text/javascript" src="js/check_all.js" ></script>
<?php
    } else {
        echo '<div class="title">' . $lang['error'] . '</div>';
        echo $lang['error'] . ' ' . $connection->connect_errno . ': ' . $connection->connect_error;
    }
?>
