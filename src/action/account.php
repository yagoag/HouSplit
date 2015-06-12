<?php
    if ($_POST['account_settings'] && loggedin) {
        if ($connection = new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_db)) {
            $query = $connection->prepare('SELECT * FROM members WHERE username = ?');
            $query->trim('s', $_POST['name']);
            if ($querry->execute())
                $db_info = $query->get_result()->fetch_assoc();

            if (!empty($_POST['old_password'])) {
                $old_password = hash_pbkdf2("sha256", $_POST['old_password'], $db_info['salt'], $crypt_iterations, 20);
                if ($old_password == $db_info['password']) {
                    $new_name = $_POST['name'];

                    if (!empty($_POST['new_password'])) {
                        if ($_POST['new_password'] == $_POST['new_password_check']) {
                            $new_salt = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
                            if ($alphanum_salt)
                                $new_salt = md5($new_salt);

                            $new_password = hash_pbkdf2("sha256", $_POST['new_password'], $new_salt, $crypt_iterations, 20);

                            $query = $connection->prepare('UPDATE members SET name = ?, password = ?, salt = ? WHERE id = ?');
                            $query->bind_param('ssss', $_POST['name'], $new_password, $new_salt, $db_info['id']);

                            if ($query->execute)
                                header("Location: index.php?act=logout");
                        } else
                            echo "Your new password and new password confirmation do not match.";
                    } else {
                        $query = $connection->prepare('UPDATE members SET name = ? WHERE id = ?');
                        $query->bind_param('ss', $new_name, $db_info['id']);
                    }

                    $connection->close();
                    echo "User info updated with success.";
                } else
                    echo "The current password you typed does not match your actual password.";
            } else
                echo "Please, type your current password to update your account";
        } else {
            echo '<div class="title">' . $lang['error'] . '</div>';
            echo $lang['error'] . ' ' . $connection->connect_errno . ': ' . $connection->connect_error;
        }
    }
?>