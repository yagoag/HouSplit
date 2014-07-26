<?php
    if ($_POST['register']) {
        // Set up MySQL connection
        $db_handler = mysql_connect($mysql_server, $mysql_username, $mysql_password);
        $db_found = mysql_select_db($mysql_db, $db_handler);
        
        // Get username from POST
        $newuser = $_POST['username'];
        
        $user_exists = mysql_num_rows(mysql_query("SELECT * FROM members  WHERE username = '$newuser'")) >= 1;
        
        if ($user_exists)
            echo "Username already in use.";
        else {
            // Get rest of the POST information
            $name = $_POST['name'];
            $pass = $_POST['password'];
            
            // Set salt value for PDKDF2
            if ($salt_source == "random_bytes")
                $salt = openssl_random_pseudo_bytes(16);
            else
                $salt = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);

            // Hash password
            $pass = hash_pbkdf2("sha256", $pass, $salt, $crypt_iterations, 20);

            if ($db_found) {
                // Insert member into database
                mysql_query("INSERT INTO members (name, username, password, salt) VALUES ('$name', '$newuser', '$pass', '$salt')");
                
                // Close connection
                mysql_close($db_handler);
                
                // Show success message
                echo "User added to the database with success.";
            } else
                die();
        }
    } else
        die();
?>