<?php
    include_once "config.php";

    // Set up MySQL connection
    $db_connect = mysqli_connect($mysql_server, $mysql_username, $mysql_password, $mysql_db);
?>
<div class="title"><?php echo $lang['new_payment_title']; ?></div>
<form id="new_payment" name="new_payment" method="post" action="?act=pay">
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
    <p><input type="submit" name="new_payment" value="<?php echo $lang['add_payment']; ?>" /></p>
</form>