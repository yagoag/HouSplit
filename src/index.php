<?php
    include_once "action/session.php";
    include_once "config.php";

    if (file_exists('languages/' . $language . '.php'))
        include_once 'languages/' . $language . '.php';
    else
        include_once 'languages/en_US.php';
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
                echo '<div class="username"><a href="?p=account"><img src="img/edit.png" /></a> ' . $user . '</div>';
                echo '<div class="logout"><a href="?act=logout">' . $lang['logout'] . '</a></div>';
            } else
                echo '<div class="username"><a href="?p=login">' . $lang['login'] . '</a></div>';
        ?>
    </div>
    <div id="header">
        <img class="logo" src="img/logo.png" /><?php echo $republica; ?>
    </div>
    <div id="sidebar">
        <a href="?p=balance">
            <div class="option"><?php echo $lang['balance_title']; ?></div>
            <div class="description"><?php echo $lang['balance_description']; ?></div>
        </a>
        <a href="?p=transactions">
            <div class="option"><?php echo $lang['transactions_title']; ?></div>
            <div class="description"><?php echo $lang['transactions_description']; ?></div>
        </a>
        <a href="?p=bill">
            <div class="option"><?php echo $lang['new_bill_title']; ?></div>
            <div class="description"><?php echo $lang['new_bill_description']; ?></div>
        </a>
        <a href="?p=pay">
            <div class="option"><?php echo $lang['new_payment_title']; ?></div>
            <div class="description"><?php echo $lang['new_payment_description']; ?></div>
        </a>
        <a href="?p=credit">
            <div class="option"><?php echo $lang['new_cred_transf_title']; ?></div>
            <div class="description"><?php echo $lang['new_cred_transf_description']; ?></div>
        </a>
        <a href="?p=register">
            <div class="option"><?php echo $lang['register_title']; ?></div>
            <div class="description"><?php echo $lang['register_description']; ?></div>
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
    <div id="footer">RePepeca Alpha 10 - Copyright &copy; 2014, Yago Arroyo</div>
</body>
</html>