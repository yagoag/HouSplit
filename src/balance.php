<?php
    if ($connection = new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_db)) {
        $db_info = $connection->prepare('SELECT * FROM members ORDER BY balance DESC');
        $db_info->execute();
        $connection->close();
?>
<div class="title"><?php echo $lang['balance_title']; ?></div>
<div class="balance">
    <table>
    <?php
        while ($member = $db_info->fetch_array()) {
            if ($member['active']) {
                echo '<tr><td style="witdh: 20%;">' . $member['name'] . '</td>';
                echo '<td class="bal ';
                if ($member['balance'] < 0)
                    echo 'negative';
                elseif ($member['balance'] == 0)
                    echo 'neutral';
                else
                    echo 'positive';
                echo '">' . $currency . number_format(abs($member['balance']), 2) . '</td>';

                if ($member['balance'] < 0)
                    echo '<td class="negative">D</td>';
                elseif ($member['balance'] == 0)
                    echo '<td></td>';
                else
                    echo '<td class="positive">C</td>';

                echo '</tr>' . PHP_EOL;
            }
        }
    ?>
    </table>
</div>
<?php
    } else {
        echo '<div class="title">' . $lang['error'] . '</div>';
        echo $lang['error'] . ' ' . $connection->connect_errno . ': ' . $connection->connect_error;
    }
?>
