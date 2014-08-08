<?php
    include_once "config.php";

    // Set up MySQL connection
    $db_connect = mysqli_connect($mysql_server, $mysql_username, $mysql_password, $mysql_db);
?>
<div class="title"><?php echo $lang['transactions_title']; ?></div>
<table class="transactions paginated" style="width: 70%;">
    <thead><tr><th style="width: 15%;"><?php echo $lang['date']; ?></th><th style="width: 12%;"><?php echo $lang['type']; ?></th><th style="width: 10%;"><?php echo $lang['payer']; ?></th><th style="width: 33%;"><?php echo $lang['name']; ?></th><th style="width: 15%;"><?php echo $lang['total_value']; ?></th><th style="width: 15%;"><?php echo $lang['your_share']; ?></th></tr></thead>
    <?php
        $db_info = mysqli_query($db_connect, "SELECT * FROM members WHERE username = '$user'");
        $db_info = mysqli_fetch_assoc($db_info);
        $userID = $db_info['id'];

        $db_info = mysqli_query($db_connect, "SELECT * FROM portions WHERE memberID = '$userID' ORDER BY id DESC");

        while ($info = mysqli_fetch_assoc($db_info)) {
            $transaction = $info['transactionID'];
            $transaction = mysqli_query($db_connect, "SELECT * FROM transactions WHERE id='$transaction'");
            $transaction = mysqli_fetch_assoc($transaction);
            echo '<tr>';
            echo '<td>' . date($dateformat, strtotime($transaction['date'])) . '</td>';
            echo '<td>';
            if ($transaction['type'] == 'CredTransf')
                echo $lang['type_credtransf'];
            elseif ($transaction['type'] == 'Bill')
                echo $lang['type_bill'];
            else
                echo $lang['type_payment'];
            echo '</td>';
            $payer = $transaction['payer'];
            $payer = mysqli_query($db_connect, "SELECT * FROM members WHERE id='$payer'");
            $payer = mysqli_fetch_assoc($payer);
            echo '<td>' . $payer['name'] . '</td>';
            echo '<td>' . $transaction['name'] . '</td>';
            echo '<td>' . $currency . number_format($transaction['value'], 2) . '</td>';
            echo '<td>' . $currency . number_format($info['value'], 2) . '</td></tr>';
        }

        mysqli_close($db_connect);
    ?>
</table>
<script type="text/javascript" src="js/pagination.js" ></script>