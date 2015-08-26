<?php
    if ($connection = new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_db)) {
        $db_info = $connection->prepare('SELECT * FROM members');
        $db_info->execute();
?>
<div class="title"><?php echo $lang['transactions_title']; ?></div>
<table class="transactions paginated" style="width: 70%;">
    <thead><tr><th style="width: 15%;"><?php echo $lang['date']; ?></th><th style="width: 12%;"><?php echo $lang['type']; ?></th><th style="width: 10%;"><?php echo $lang['payer']; ?></th><th style="width: 33%;"><?php echo $lang['name']; ?></th><th style="width: 15%;"><?php echo $lang['total_value']; ?></th><th style="width: 15%;"><?php echo $lang['your_share']; ?></th></tr></thead>
    <?php
        $query = $connection->prepare('SELECT * FROM portions WHERE memberID = (SELECT id FROM members WHERE username = ?) ORDER BY id DESC');
        $query->bind_param('s', $_SESSION['username']);
        $query->execute();
        $db_info = $query->get_result();

        while ($info = $db_info->fetch_assoc()) {
            $query = $connection->prepare('SELECT * FROM transactions WHERE id=?');
            $query->bind_param('i', $info['transactionID']);
            $query->execute();
            $transaction = $query->get_result()->fetch_assoc();
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
            $query = $connection->prepare('SELECT * FROM members WHERE id=?');
            $query->bind_param('i', $transaction['payer']);
            $query->execute();
            $payer = $query->get_result()->fetch_assoc();
            echo '<td>' . $payer['name'] . '</td>';
            echo '<td>' . $transaction['name'] . '</td>';
            echo '<td>' . $currency . number_format($transaction['value'], 2) . '</td>';
            echo '<td>' . $currency . number_format($info['value'], 2) . '</td></tr>';
        }

            $connection->close();

    ?>
</table>
<script type="text/javascript" src="js/pagination.js" ></script>
<?php
    } else {
        echo '<div class="title">' . $lang['error'] . '</div>';
        echo $lang['error'] . ' ' . $connection->connect_errno . ': ' . $connection->connect_error;
    }
?>
