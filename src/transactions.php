<?php
    include_once "config.php";

    // Set up MySQL connection
    $db_connect = mysqli_connect($mysql_server, $mysql_username, $mysql_password, $mysql_db);
?>
<div class="title"><?php echo $lang['transactions_title']; ?></div>
<table class="paginated" style="width: 70%;">
    <thead><tr><th style="width: 15%;"><?php echo $lang['date']; ?></th><th style="width: 12%;"><?php echo $lang['type']; ?></th><th style="width: 40%;"><?php echo $lang['name']; ?></th><th style="width: 15%;"><?php echo $lang['total_value']; ?></th><th><?php echo $lang['your_share']; ?></th></tr></thead>
    <?php
        $db_info = mysqli_query($db_connect, "SELECT * FROM members WHERE username = '$user'");
        $db_info = mysqli_fetch_assoc($db_info);
        $userID = $db_info['id'];

        $db_info = mysqli_query($db_connect, "SELECT * FROM portions WHERE memberID = '$userID' ORDER BY id DESC");

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
<script type="text/javascript" src="js/pagination.js" ></script>