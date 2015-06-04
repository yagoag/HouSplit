<?php
    session_start();

    if (isset($_SESSION['username'])) {
        $connection = @new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_db); // @ used to suppress errors (which will be handled later)
                                                                                               // if debugging, you may want to remove @

        $query = $connection->prepare('SELECT * FROM members WHERE username = ? LIMIT 1');
        $query->bind_param('s', $_SESSION['username']);
        $query->execute();
        $db_info = $query->get_result();

        $connection->close();
        
        if ($db_info) {
            $db_info = mysqli_fetch_assoc($db_info);
            $loggedin = true;
            $user = $_SESSION['username'];
            $admin = $db_info['admin'];
        } else
            $loggedin = false;
    } else
        $loggedin = false;
?>