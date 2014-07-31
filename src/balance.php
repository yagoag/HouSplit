<?php
    include_once "config.php";

    // Set up MySQL connection
    $db_connect = mysqli_connect($mysql_server, $mysql_username, $mysql_password, $mysql_db);
?>
<div class="title"><?php echo $lang['balance_title']; ?></div>
<div class="balance">
    <table>
        <?php
            $db_info = mysqli_query($db_connect, "SELECT * FROM members ORDER BY balance DESC");
            while ($member = mysqli_fetch_array($db_info)) {
                // Get balance into a variable
                $balance = $member['balance'];

                // Print name of the member
                echo '<tr><td>' . $member['name'] . '</td>';

                // Print balance module
                echo '<td class="bal ';
                if ($balance < 0)
                    echo 'negative';
                elseif ($balance == 0)
                    echo 'neutral';
                else
                    echo 'positive';
                echo '">' . $currency . number_format(abs($member['balance']), 2) . '</td>';

                // Print debit/credit
                if ($balance < 0)
                    echo '<td class="negative">D</td>';
                elseif ($balance == 0)
                    echo '<td></td>';
                else
                    echo '<td class="positive">C</td>';

                echo '</tr>' . PHP_EOL;
            }
            mysqli_close($db_connect);
        ?>
    </table>
</div>