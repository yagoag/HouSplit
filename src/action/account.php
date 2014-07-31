<?php
    if ($_POST['account_settings']) {
        // Set up MySQL connection
        $db_connect = mysqli_connect($mysql_server, $mysql_username, $mysql_password, $mysql_db);

        // Get information from POST
        $name = $_POST['name'];

        // (Try to) Select row with user's info 
        $db_info = mysqli_query($db_connect, "SELECT * FROM members WHERE username = '$user'");
        if ($db_info)
            // Turns query's result into an array with its info
            $db_info = mysqli_fetch_assoc($db_info);

        if (!empty($_POST['old_password'])) {
            $old_password = $_POST['old_password'];

            // Hash password
            $old_password = hash_pbkdf2("sha256", $old_password, $db_info['salt'], $crypt_iterations, 20);

            // Verify current password
            if ($old_password == $db_info['password']) {
                $new_name = $_POST['name'];

                if (!empty($_POST['new_password'])) {
                    $new_password = $_POST['new_password'];

                    if ($new_password == $_POST['new_password_check']) {
                        // Set salt value for PDKDF2
                        $new_salt = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);

                        if ($alphanum_salt)
                            $new_salt = md5($new_salt);

                        // Hash password
                        $new_password = hash_pbkdf2("sha256", $new_password, $new_salt, $crypt_iterations, 20);

                        if ($db_connect) {
                            // Insert member into database
                            mysqli_query($db_connect, "UPDATE members SET name = '$new_name', password = '$new_password', salt = '$new_salt' WHERE id = '" . $db_info['id'] . "'");

                            // Log user out
                            header("Location: index.php?act=logout");
                        }
                    } else
                        echo "Your new password and new password confirmation do not match.";
                } else
                    if ($db_connect)
                        // Insert member into database
                        mysqli_query($db_connect, "UPDATE members SET name = '$new_name' WHERE id = '" . $db_info['id'] . "'");

                if ($db_connect) {
                    // Close connection
                    mysqli_close($db_connect);

                    // Show success message
                    echo "User info updated with success.";
                } else
                    die();
            } else
                echo "The current password you typed does not match your actual password.";
        } else
            echo "Please, type your current password to update your account";
    }
?>