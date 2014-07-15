<?php
    include_once "action/session.php";
    include_once "config.php";
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $republica; ?></title>
    <link href="css/style.css" media="all" rel="Stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico" />
</head>

<body>
    <div id="login_status">
        <?php
            if ($loggedin) {
                echo '<div class="username">' . $user . '</div>';
                echo '<div class="logout"><a href="action/logout.php">logout</a></div>';
            } else
                echo '<div class="username"><a href="?p=login">Login</a></div>';
        ?>
    </div>
    <div id="header">
        <img class="logo" src="img/logo.png" /><?php echo $republica; ?>
    </div>
    <div id="sidebar">
        <a href="?p=balance">
            <div class="option">Balance</div>
            <div class="description">see members' balance table</div>
        </a>
        <a href="?p=transactions">
            <div class="option">Transactions</div>
            <div class="description">show transactions list</div>
        </a>
        <a href="?p=bill">
            <div class="option">New Bill</div>
            <div class="description">create a new bill</div>
        </a>
        <a href="?p=pay">
            <div class="option">New Payment</div>
            <div class="description">make a new debit payment</div>
        </a>
        <a href="?p=credit">
            <div class="option">New Credit Transference</div>
            <div class="description">make a new credit transference</div>
        </a>
        <a href="?p=register">
            <div class="option">Register</div>
            <div class="description">register a new account</div>
        </a>
    </div>
    <div id="content">
        <?php
            if ($loggedin) {
                if (isset($_GET['p'])) {
                    $page = $_GET['p'] . ".php";
                    if (file_exists($page))
                        include $page;
                    else
                        include "404.php";
                } elseif (isset($_GET['act'])) {
                    $page = "action/" . $_GET['act'] . ".php";
                    if (file_exists($page))
                        include $page;
                    else
                        include "404.php";
                } else
                    include "balance.php";
            } else {
                if (isset($_GET['act'])) {
                    $page = "action/" . $_GET['act'] . ".php";
                    if ($page = "action/login.php")
                        include $page;
                    else
                        include "login.php";
                } else
                    include "login.php";
            }
        ?>
    </div>
    <div id="footer">RePepeca Alpha 8 - Copyright &copy; 2014, Yago Arroyo</div>
</body>
</html>