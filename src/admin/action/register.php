<?php
    if ($_POST['register'] && $loggedin && $admin) {
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
                    // Make sure values are valid to concatenate with the query
                    if (!array_key_exists('admin', $_POST))
                        $_POST['admin'] = 0;

                    $query = $connection->prepare('INSERT INTO members (name, username, password, salt, admin) VALUES (?, ?, ?, ?, ?)');
                    $query->bind_param('ssssi', $_POST['name'], $_POST['username'], $password, $salt, $_POST['admin']);

                    if ($query->execute()) {
                        echo '<div class="title">' . $lang['success'] . '</div>';
                        echo $lang['msg_member_registered'];
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
    } else
        die();
?>