<?php
    if ($connection = new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_db)) {
        $db_info = $connection->prepare('SELECT * FROM members');
        $db_info->execute();
        $connection->close();
?>
<div class="title"><?php echo $lang['new_cred_transf_title']; ?></div>
<form id="new_credit_transf" name="new_credit_transf" method="post" action="?act=credit">
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
    <p><input type="submit" name="new_credit_transf" value="<?php echo $lang['add_transference']; ?>" /></p>
</form>
<?php
    } else {
        echo '<div class="title">' . $lang['error'] . '</div>';
        echo $lang['error'] . ' ' . $connection->connect_errno . ': ' . $connection->connect_error;
    }
?>
