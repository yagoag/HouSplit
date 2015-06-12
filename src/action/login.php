<?php
    if ($_POST['login']) {
        $connection = new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_db);

        if (empty($_POST['username'])) {
            echo '<div class="title">' . $lang['error'] . '</div>';
            echo $lang['error_type_user_login'];
        } elseif (empty($_POST['password'])) {
            echo '<div class="title">' . $lang['error'] . '</div>';
            echo $lang['error_type_pw_login'];
        } else {
            $query = $connection->prepare('SELECT * FROM members WHERE username = ?');
            $query->bind_param('s', $_POST['username']);
            if ($query->execute()) {
                $db_info = $query->get_result()->fetch_assoc();
                $connection->close();

                if ($db_info['active']) {
                    $password = hash_pbkdf2("sha256", $_POST['password'], $db_info['salt'], $crypt_iterations, 20);
                    if ($password == $db_info['password']) {
                        $_SESSION['username'] = $_POST['username'];
                        header("Location: index.php");
                    }
                } else {
                    echo '<div class="title">' . $lang['error'] . '</div>';
                    echo $lang['error_deactivated_account'];
                    die();
                }
            }

            echo '<div class="title">' . $lang['error'] . '</div>';
            echo $lang['error_user_pw_match'];
        }
   }
?>