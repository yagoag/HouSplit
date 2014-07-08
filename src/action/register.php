<?php
	if ($_POST['register']) {
        include_once "../config.php";
        
        // Set up MySQL connection
        $db_handler = mysql_connect($mysql_server, $mysql_username, $mysql_password);
        $db_found = mysql_select_db($mysql_db, $db_handler);
        
        // Get username from POST
		$user = $_POST['username'];
        
        $user_exists = mysql_num_rows(mysql_query("SELECT * FROM members  WHERE username = '$user'")) >= 1;
        
        if ($user_exists)
            echo "Username already in use.";
        else {
            // Get rest of the POST information
            $name = $_POST['name'];
            $pass = $_POST['password'];
            
            // Set number of interations and salt value for PDKDF2
            $iterations = 1000;
            $salt = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);

            // Hash password
            $pass = hash_pbkdf2("sha256", $pass, $salt, $iterations, 20);

            if ($db_found) {
                // Insert member into database
                mysql_query("INSERT INTO members (name, username, password, salt) VALUES ('$name', '$user', '$pass', '$salt')");
                
                // Close connection
                mysql_close($db_handler);
                echo "User added to the database with success.";
            } else
                die();
        }
	} else
        die();
?>