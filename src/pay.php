<?php
    if ($connection = new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_db)) {
        $db_info = $connection->prepare('SELECT * FROM members');
        $db_info->execute();
        $connection->close();
?>
<div class="title"><?php echo $lang['new_payment_title']; ?></div>
<form id="new_payment" name="new_payment" method="post" action="?act=pay">
    <p><input type="text" size="35" name="name" placeholder="<?php echo $lang['name']; ?>" /></p>
    <p><input type="text" size="35" name="value" placeholder="<?php echo $lang['value']; ?>" /></p>
    <br />
    <p>
        <select name="member">
        <?php
            while ($member = $db_info->fetch_array())
                if ($member['username'] != $_SESSION['username'] && $member['active'])
                    echo '<option value="' . $member['id'] . '">' . $member['name'] . '</option>';
            mysqli_close($db_connect);
        ?>
        </select>
    </p>
    <br />
    <p><input type="submit" name="new_payment" value="<?php echo $lang['add_payment']; ?>" /></p>
</form>
<?php
    } else {
        echo '<div class="title">' . $lang['error'] . '</div>';
        echo $lang['error'] . ' ' . $connection->connect_errno . ': ' . $connection->connect_error;
    }
?>
