<?php
    // Set up MySQL connection
    $db_connect = mysqli_connect($mysql_server, $mysql_username, $mysql_password, $mysql_db);
?>
<div class="title"><?php echo $lang['new_cred_transf_title']; ?></div>
<form id="new_credit_transf" name="new_credit_transf" method="post" action="?act=credit">
    <p><input type="text" size="35" name="name" placeholder="<?php echo $lang['name']; ?>" /></p>
    <p><input type="text" size="35" name="value" placeholder="<?php echo $lang['value']; ?>" /></p>
    <br />
    <p>
        <select name="member">
        <?php
            $db_info = mysqli_query($db_connect, "SELECT * FROM members");
            while ($member = mysqli_fetch_array($db_info))
                if ($member['username'] != $user)
                    echo '<option value="' . $member['id'] . '">' . $member['name'] . '</option>';
            mysqli_close($db_connect);
        ?>
        </select>
    </p>
    <br />
    <p><input type="submit" name="new_credit_transf" value="<?php echo $lang['add_transference']; ?>" /></p>
</form>