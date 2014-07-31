<?php
    if ($_POST['new_credit_transf']) {
        include_once "config.php";

        // Get POST values
        $name = $_POST['name'];
        $value = $_POST['value'];
        $member = $_POST['member'];
        
        // Connect to server
        $db_connect = mysqli_connect($mysql_server, $mysql_username, $mysql_password, $mysql_db);

        // Insert payment into database
        mysqli_query($db_connect, "INSERT INTO payments (name, date, type, value) VALUES ('$name', now(), 'Payment', $value)");

        // Get payment's ID
        $payment_id = mysqli_fetch_assoc(mysqli_query($db_connect, "SELECT MAX(id) AS payment_id FROM payments"));
        $payment_id = $payment_id['payment_id']; // Get content from returned array

        // Create payment portion and update balance of receptor
        $db_info = mysqli_query($db_connect, "SELECT * FROM members WHERE id = $member");
        $db_info = mysqli_fetch_assoc($db_info);
        $balance = $db_info['balance'] + $value;
        mysqli_query($db_connect, "INSERT INTO portions (memberID, paymentID, value) VALUES ('$member', '$payment_id', '$value')");
        mysqli_query($db_connect, "UPDATE members SET balance = '$balance' WHERE id = '$member'");

        // Create payment portion and update balance of payer
        $db_info = mysqli_query($db_connect, "SELECT * FROM members WHERE username = '$user'");
        $db_info = mysqli_fetch_assoc($db_info);
        $member = $db_info['id'];
        $balance = $db_info['balance'] - $value;
        mysqli_query($db_connect, "INSERT INTO portions (memberID, paymentID, value) VALUES ('$member', '$payment_id', '$value')");
        mysqli_query($db_connect, "UPDATE members SET balance = '$balance' WHERE id = '$member'");

        // Close connection
        mysqli_close($db_connect);

        // Show success message
        echo '<div class="title">' . $lang['success'] . '</div>';
        echo $lang['msg_cred_transf_added'];
    } else
        die();
?>