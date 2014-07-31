<?php
    include_once "config.php";

    // Set up MySQL connection
    $db_connect = mysqli_connect($mysql_server, $mysql_username, $mysql_password, $mysql_db);
?>
<div class="title"><?php echo $lang['transactions_title']; ?></div>
<table>
    <tr class="header"><td><?php echo $lang['date']; ?></td><td><?php echo $lang['type']; ?></td><td><?php echo $lang['name']; ?></td><td><?php echo $lang['total_value']; ?></td><td><?php echo $lang['your_share']; ?></td></tr>
    <?php
        $db_info = mysqli_query($db_connect, "SELECT * FROM members WHERE username = '$user'");
        $db_info = mysqli_fetch_assoc($db_info);
        $userID = $db_info['id'];

        $db_info = mysqli_query($db_connect, "SELECT * FROM portions WHERE memberID = '$userID'");

        while ($info = mysqli_fetch_assoc($db_info)) {
            $paymentID = $info['paymentID'];
            $payment = mysqli_query($db_connect, "SELECT * FROM payments WHERE id='$paymentID'");
            $payment = mysqli_fetch_assoc($payment);
            echo '<tr>';
            echo '<td>' . date($dateformat, strtotime($payment['date'])) . '</td>';
            echo '<td>' . $payment['type'] . '</td>';
            echo '<td>' . $payment['name'] . '</td>';
            echo '<td>' . $currency . number_format($payment['value'], 2) . '</td>';
            echo '<td>' . $currency . number_format($info['value'], 2) . '</td></tr>';
        }

        mysqli_close($db_connect);
    ?>
</table>