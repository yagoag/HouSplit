<?php
    if ($_POST['register']) {
        if ($connection = new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_db)) {
            $query = $connection->prepare('SELECT * FROM members WHERE username = ?');
            $query->bind_param('s', $_POST['username']);
            $query->execute();
            $user_exists = $query->get_result()->num_rows > 0;

            if ($user_exists) {
                echo '<div class="title">' . $lang['error'] . '</div>';
                echo $lang['error_username_in_use'];
            } else {
                if (!empty($_POST['username']) && !empty($_POST['name']) && !empty($_POST['password'])) {
                    $salt = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);

                    if ($alphanum_salt)
                        $salt = md5($new_salt);

                    $password = hash_pbkdf2("sha256", $_POST['password'], $salt, $crypt_iterations, 20);

                    $query = $connection->prepare('INSERT INTO members (name, username, password, salt, admin) VALUES (?, ?, ?, ?, ?)');
                    $query->bind_param('ssssi', $_POST['name'], $_POST['username'], $password, $salt, 1);

                    if ($query->execute()) {
                        echo '<div class="title">' . $lang['success'] . '</div>';
                        echo $lang['msg_admin_created'];
                    } else {
                        echo '<div class="title">' . $lang['error'] . '</div>';
                        echo $lang['msg_member_not_registered'];
                    }

                    $connection->close();

                } else {
                    echo '<div class="title">' . $lang['error'] . '</div>';
                    echo $lang['error_fill_all_register'];
                }
            }
        } else {
            echo '<div class="title">' . $lang['error'] . '</div>';
            echo $lang['error'] . ' ' . $connection->connect_errno . ': ' . $connection->connect_error;
        }
    }
?>

<div class="title"><?php echo $lang['new_admin_account']; ?></div>
<form id="register_form" name="register_form" method="post" action="?p=install">
    <p><input type="text" size="35" name="name" placeholder="<?php echo $lang['name']; ?>" class="textbox" /></p>
    <p><input type="text" size="35" name="username" placeholder="<?php echo $lang['username']; ?>" class="textbox" /></p>
    <p><input type="password" size="35" name="password" placeholder="<?php echo $lang['password']; ?>" class="textbox" /></p>
    <br />
    <p><input type="submit" name="register" value="<?php echo $lang['register_title']; ?>" class="button" /></p>
</form>