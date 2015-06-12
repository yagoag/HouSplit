<?php
    if ($_POST['new_payment'] && $loggedin) {
        $value = str_replace(',', '.', $_POST['value']); // Replace comma with dot as decimal operator
        
        if ($connection = new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_db)) {
            $query = $connection->prepare('SELECT * FROM members WHERE username = ?');
            $query->bind_param('s', $user);
            $query->execute();
            $db_info = $query->get_result()->fetch_assoc();
            $member = $db_info['id'];

            $query = $connection->prepare('INSERT INTO transactions (name, payer, date, type, value) VALUES (?, ?, now(), \'CredTransf\', ?)');
            $query->bind_param('sid', $_POST['name'], $member, $value);
            $query->execute();

            // Get transactions's ID
            $query = $connection->prepare('SELECT MAX(id) AS transaction_id FROM transactions');
            $query->execute();
            $transaction = $query->get_result()->fetch_assoc();
            $transaction = $transaction['transaction_id'];

            // Create payment portion and update balance of payer
            $balance = $db_info['balance'] + $value;
            $query = $connection->prepare('INSERT INTO portions (memberID, transactionID, value) VALUES (?, ?, ?)');
            $query->bind_param('iid', $member, $transaction, $value);
            $query->execute();
            $query = $connection->prepare('UPDATE members SET balance = ? WHERE id = ?');
            $query->bind_param('di', $balance, $member);
            $query->execute();

            // Create payment portion and update balance of receiver
            $member = $_POST['member'];
            $query = $connection->prepare('SELECT * FROM members WHERE id = ?');
            $query->bind_param('i', $member);
            $query->execute();
            $db_info = $query->get_result()->fetch_assoc();
            $balance = $db_info['balance'] - $value;
            $query = $connection->prepare('INSERT INTO portions (memberID, transactionID, value) VALUES (?, ?, ?)');
            $query->bind_param('iid', $member, $transaction, $value);
            $query->execute();
            $query = $connection->prepare('UPDATE members SET balance = ? WHERE id = ?');
            $query->bind_param('di', $balance, $member);
            $query->execute();

            $connection->close();

            echo '<div class="title">' . $lang['success'] . '</div>';
            echo $lang['msg_cred_transf_added'];
        } else {
            echo '<div class="title">' . $lang['error'] . '</div>';
            echo $lang['error'] . ' ' . $connection->connect_errno . ': ' . $connection->connect_error;
        }
    } else
        die();
?>