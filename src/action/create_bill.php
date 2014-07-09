<?php
    if ($_POST['new_bill']) {
        include_once "../config.php";

        // Get POST values
        $name = $_POST['name'];
        $value = $_POST['value'];
        $members = $_POST['members'];
        
        // Connect to server
        $db_handler = mysql_connect($mysql_server, $mysql_username, $mysql_password);
        $db_found = mysql_select_db($mysql_db, $db_handler);
        
        // Insert bill into database
        mysql_query("INSERT INTO bills (name, date, value) VALUES ('$name', now(), $value)");
        
        // Get bill's ID
        $bill_id = mysql_fetch_assoc(mysql_query("SELECT MAX(id) AS bill_id FROM bills"));
        $bill_id = $bill_id['bill_id']; // Get content from returned array
        
        // Divide bill by the number of members in it
        $value = round($value / count($members), 2);
        
        // Create bill portions to each of the members involved
        foreach ($members as $member) {
            mysql_query("INSERT INTO portions (member, bill, value) VALUES ('$member', '$bill_id', '$value')");
        }
        
        // Close connection
        mysql_close($db_handler);
    } else
        die();
?>