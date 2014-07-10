<?php
    if ($_POST['new_payment']) {
        include_once "config.php";

        // Get POST values
        $name = $_POST['name'];
        $value = $_POST['value'];
        $members = $_POST['members'];
        
        // Connect to server
        $db_handler = mysql_connect($mysql_server, $mysql_username, $mysql_password);
        $db_found = mysql_select_db($mysql_db, $db_handler);
        
        // Insert payment into database
        mysql_query("INSERT INTO payments (name, date, value) VALUES ('$name', now(), $value)");
        
        // Get payment's ID
        $payment_id = mysql_fetch_assoc(mysql_query("SELECT MAX(id) AS payment_id FROM payments"));
        $payment_id = $payment_id['payment_id']; // Get content from returned array
        
        // Divide payment by the number of members in it
        $value = round($value / (count($members) + 1), 2);

        // Create payment portions and update balances of the members selected
        foreach ($members as $member) {
            $db_info = mysql_query("SELECT * FROM members WHERE id = $member");
            $db_info = mysql_fetch_assoc($db_info);
            $balance = $db_info['balance'] - $value;
            mysql_query("INSERT INTO portions (memberID, paymentID, value) VALUES ('$member', '$payment_id', '$value')");
            mysql_query("UPDATE members SET balance = '$balance' WHERE id = '$member'");
        }
        
        // Create payment portion and update balance of payer
        $db_info = mysql_query("SELECT * FROM members WHERE username = '$user'");
        $db_info = mysql_fetch_assoc($db_info);
        $member = $db_info['id'];
        $balance = $db_info['balance'] + $value * count($members);
        mysql_query("INSERT INTO portions (memberID, paymentID, value) VALUES ('$member', '$payment_id', '$value')");
        mysql_query("UPDATE members SET balance = '$balance' WHERE id = '$member'");

        // Close connection
        mysql_close($db_handler);
        
        // Show success message
        echo "Payment added with success.";
    } else
        die();
?>