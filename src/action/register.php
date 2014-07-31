<?php
    if ($_POST['register']) {
        // Set up MySQL connection
        $db_connect = mysqli_connect($mysql_server, $mysql_username, $mysql_password, $mysql_db);
        
        // Get username from POST
        $newuser = $_POST['username'];
        
        $user_exists = mysqli_num_rows(mysqli_query($db_connect, "SELECT * FROM members  WHERE username = '$newuser'")) >= 1;
        
        if ($user_exists) {
            echo '<div class="title">' . $lang['error'] . '</div>';
            echo $lang['error_username_in_use'];
        } else {
            // Get rest of the POST information
            $name = $_POST['name'];
            $pass = $_POST['password'];
            
            if (!empty($newuser) && !empty($name) && !empty($pass)) {
                // Set salt value for PDKDF2
                $salt = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);

                if ($alphanum_salt)
                    $salt = md5($new_salt);

                // Hash password
                $pass = hash_pbkdf2("sha256", $pass, $salt, $crypt_iterations, 20);

                if ($db_connect) {
                    // Insert member into database
                    mysqli_query($db_connect, "INSERT INTO members (name, username, password, salt) VALUES ('$name', '$newuser', '$pass', '$salt')");

                    // Close connection
                    mysqli_close($db_connect);

                    // Show success message
                    echo '<div class="title">' . $lang['success'] . '</div>';
                    echo $lang['msg_member_registered'];
                } else
                    die();
            } else {
                echo '<div class="title">' . $lang['error'] . '</div>';
                echo $lang['error_fill_all_register'];
            }
        }
    } else
        die();
?>