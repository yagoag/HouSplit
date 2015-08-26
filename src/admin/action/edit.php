<?php
    if ($_POST['edit'] && $loggedin && $admin) {
        // Make sure values are valid to concatenate with the query
        if (!array_key_exists('admin', $_POST))
            $_POST['admin'] = 0;
        if (array_key_exists('deactivate', $_POST))
            $_POST['deactivate'] = 0;   // Note inverted value

        if ($connection = new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_db)) {
            $connection->prepare('UPDATE members SET admin = ?, active = ? WHERE id = ?');
            $connection->bind_param('iii', $_POST['admin'], $_POST['deactivate'], $_POST['member']);
            if ($connection->execute()) {
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
