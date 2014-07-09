<?php
    session_start();

    if ($_POST['login']) {
        include_once "../config.php";
        
        // Set up MySQL connection
        $db_handler = mysql_connect($mysql_server, $mysql_username, $mysql_password);
        $db_found = mysql_select_db($mysql_db, $db_handler);

        // Get data from POST
        $user = $_POST['username'];
        $pass = $_POST['password'];

        if (empty($user)) {
            echo "Please, choose a username.";
        } elseif (empty($pass)) {
            echo "Please, choose a password.";
        } else {
            // (Try to) Select row with user's info 
            $db_info = mysql_query("SELECT * FROM members WHERE username = '$user'");
            if ($db_info) {
                // Turns query's result into an array with its info
                $db_info = mysql_fetch_assoc($db_info);

                // Set number of interations and hash password
                $iterations = 1000;
                $pass = hash_pbkdf2("sha256", $pass, $db_info['salt'], $iterations, 20);

                if ($pass == $db_info['password']) {
                    // Set username and userip of the session
                    $_SESSION['username'] = $user;
                    $_SESSION['userip'] = $_SERVER['REMOTE_ADDR'];

                    // Redirect user to main page
                    header("Location: ../");
                }
            } else {
                echo "Username does not exist.";
            }
            echo "Username and/or password do not match.";
        }
   }
?>