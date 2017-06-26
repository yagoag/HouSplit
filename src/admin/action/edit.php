<?php
    if ($_POST['edit'] && $loggedin && $admin) {
        // Make sure values are valid to concatenate with the query
        if (!array_key_exists('admin', $_POST))
            $_POST['admin'] = 0;
        if (array_key_exists('deactivate', $_POST))
            $_POST['deactivate'] = 0;   // Note inverted value
		else
			$_POST['deactivate'] = 1;   // Note inverted value
		
        if ($connection = new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_db)) {
            if ($connection->query('UPDATE members SET admin = '.$_POST['admin'].', active = '.$_POST['deactivate'].' WHERE id = '.$_POST['member'])) {
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