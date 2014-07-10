<?php
    include_once "config.php";

    // Set up MySQL connection
    $db_handler = mysql_connect($mysql_server, $mysql_username, $mysql_password);
    $db_found = mysql_select_db($mysql_db, $db_handler);
?>
<?php
    $db_info = mysql_query("SELECT * FROM members");
    while ($member = mysql_fetch_array($db_info))
        echo '<p>' . $member['name'] . ' - ' . $member['balance'] . '</p>';
?>