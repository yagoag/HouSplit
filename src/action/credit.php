<?php
    if ($_POST['new_credit_transf']) {
        // Get POST values
        $name = $_POST['name'];
        $value = $_POST['value'];

        // Replace comma with dot as decimal operator
        $value = str_replace(',', '.', $value);
        
        // Connect to server
        $db_connect = mysqli_connect($mysql_server, $mysql_username, $mysql_password, $mysql_db);

        // Select payer's info and get their ID
        $db_info = mysqli_query($db_connect, "SELECT * FROM members WHERE username = '$user'");
        $db_info = mysqli_fetch_assoc($db_info);
        $member = $db_info['id'];

        // Insert transaction into database
        mysqli_query($db_connect, "INSERT INTO transactions (name, payer, date, type, value) VALUES ('$name', '$member', now(), 'CredTransf', $value)");

        // Get transactions's ID
        $transaction = mysqli_fetch_assoc(mysqli_query($db_connect, "SELECT MAX(id) AS transaction_id FROM transactions"));
        $transaction = $transaction['transaction_id']; // Get content from returned array

        // Create payment portion and update balance of payer
        $balance = $db_info['balance'] - $value;
        mysqli_query($db_connect, "INSERT INTO portions (memberID, transactionID, value) VALUES ('$member', '$transaction', '$value')");
        mysqli_query($db_connect, "UPDATE members SET balance = '$balance' WHERE id = '$member'");

        // Create payment portion and update balance of receptor
        $member = $_POST['member'];
        $db_info = mysqli_query($db_connect, "SELECT * FROM members WHERE id = $member");
        $db_info = mysqli_fetch_assoc($db_info);
        $balance = $db_info['balance'] + $value;
        mysqli_query($db_connect, "INSERT INTO portions (memberID, transactionID, value) VALUES ('$member', '$transaction', '$value')");
        mysqli_query($db_connect, "UPDATE members SET balance = '$balance' WHERE id = '$member'");

        // Close connection
        mysqli_close($db_connect);

        // Show success message
        echo '<div class="title">' . $lang['success'] . '</div>';
        echo $lang['msg_cred_transf_added'];
    } else
        die();
?>