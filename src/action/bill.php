<?php
    if ($_POST['new_payment'] && $loggedin) {
        $value = str_replace(',', '.', $_POST['value']);     // Replace comma with dot as decimal operator

        if ($connection = new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_db)) {
            $query = $connection->prepare('SELECT * FROM members WHERE username = ?');
            $query->bind_param('s', $_SESSION['username']);
            $query->execute();
            $db_info = $query->get_result()->fetch_assoc();

            // Insert transaction into database
            $query = $connection->prepare('INSERT INTO transactions (name, payer, date, type, value) VALUES (?, ?, now(), \'Bill\', ?)');
            $query->bind_param('sid', $_POST['name'], $db_info['id'], $value);
            $query->execute();

            // Get transaction's ID
            $transaction = $connection->prepare('SELECT MAX(id) AS transaction_id FROM transactions');
            $transaction->execute();
            $transaction = $transaction->fetch_assoc()['transaction_id'];

            $value = round($value / (count($_POST['members']) + 1), 2);  // Value or each portion

            // Create payment portion and update balance of payer
            $query = $connection->prepare('INSERT INTO portions (memberID, transactionID, value) VALUES (?, ?, ?)');
            $query->bind_param('iid', $db_info['id'], $transaction, $value);
            $query->execute();
            $query = $connection->prepare('UPDATE members SET balance = balance + ? WHERE id = ?');
            $payer_portion = $value * count($_POST['members']);
            $query->bind_param('di', $payer_portion, $db_info['id']);
            echo $query->execute();

            // Create payment portions and update balances of the members selected
            foreach ($_POST['members'] as $member) {
                $query = $connection->prepare('SELECT * FROM members WHERE id = ?');
                $query->bind_param('i', $member);
                $query->execute();
                $db_info = $query->get_result()->fetch_assoc();
                $balance = $db_info['balance'] - $value;
                $query = $connection->prepare('INSERT INTO portions (memberID, transactionID, value) VALUES (?, ?, ?)');
                $query->bind_param('iid', $member, $transaction, $value);
                $query->execute();
                $query = $connection->prepare('UPDATE members SET balance = balance - ? WHERE id = ?');
                $query->bind_param('di', $value, $member);
                $query->execute();
            }

            $connection->close();

            echo '<div class="title">' . $lang['success'] . '</div>';
            echo $lang['msg_bill_added'];
        } else {
            echo '<div class="title">' . $lang['error'] . '</div>';
            echo $lang['error'] . ' ' . $connection->connect_errno . ': ' . $connection->connect_error;
        }
    } else
        die();
?>
