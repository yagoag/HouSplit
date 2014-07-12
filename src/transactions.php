<?php
    include_once "config.php";

    // Set up MySQL connection
    $db_handler = mysql_connect($mysql_server, $mysql_username, $mysql_password);
    $db_found = mysql_select_db($mysql_db, $db_handler);
?>
<div class="title">Transactions</div>
<table>
    <tr class="header"><td>Date</td><td>Type</td><td>Name</td><td>Total Value</td><td>Divided Value</td></tr>
    <?php
        $db_info = mysql_query("SELECT * FROM members WHERE username = '$user'");
        $db_info = mysql_fetch_assoc($db_info);
        $userID = $db_info['id'];

        $db_info = mysql_query("SELECT * FROM portions WHERE memberID = '$userID'");

        while ($info = mysql_fetch_assoc($db_info)) {
            $paymentID = $info['paymentID'];
            $payment = mysql_query("SELECT * FROM payments WHERE id='$paymentID'");
            $payment = mysql_fetch_assoc($payment);
            echo '<tr>';
            echo '<td>' . date($dateformat, strtotime($payment['date'])) . '</td>';
            echo '<td>' . $payment['type'] . '</td>';
            echo '<td>' . $payment['name'] . '</td>';
            echo '<td>' . $currency . $payment['value'] . '</td>';
            echo '<td>' . $currency . $info['value'] . '</td></tr>';
        }
    ?>
</table>