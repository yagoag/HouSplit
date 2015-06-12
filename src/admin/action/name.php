<?php
    if ($_POST['edit'] && $loggedin && $admin) {
        if ($connection = new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_db)) {
            $query = $connection->prepare('UPDATE members SET name = ? WHERE id = ?');
            $query->bind_param('si', $_POST['name'], $_POST['member']);
            if ($query->execute()) {
                echo '<div class="title">' . $lang['success'] . '</div>';
                echo $lang['msg_account_updated'];
            } else {
                echo '<div class="title">' . $lang['error'] . '</div>';
                echo $lang['error_account_not_updated'];
            }
            $connection->close();
        } else {
            echo '<div class="title">' . $lang['error'] . '</div>';
            echo $lang['error'] . ' ' . $connection->connect_errno . ': ' . $connection->connect_error;
        }
    } else
        die();
?>