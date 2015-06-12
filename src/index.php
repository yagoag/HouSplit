<?php
    require_once "config.php";
    require_once "action/session.php";

    if (file_exists('languages/' . $language . '.php'))
        require_once 'languages/' . $language . '.php';
    else
        require_once 'languages/en_US.php';
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $republica; ?></title>
    <link href="css/style.css" media="all" rel="Stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico" />
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script>
</head>

<body>
    <div id="login_status">
        <?php
            if ($loggedin) {
                echo '<div class="username"><a href="?p=account"><img src="img/edit.png" /></a> ' . $_SESSION['username'] . '</div>';
                echo '<div class="logout"><a href="?act=logout">' . $lang['logout'] . '</a></div>';
            } else
                echo '<div class="username"><a href="?p=login">' . $lang['login'] . '</a></div>';
        ?>
    </div>
    <div id="header">
        <img class="logo" src="img/logo.png" /><?php echo $republica; ?>
    </div>
    <div id="sidebar">
        <?php if ($loggedin) { ?>
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
                <?php if ($admin) { ?>
                    <a href="?p=admin">
                        <div class="option"><?php echo $lang['administration_title']; ?></div>
                        <div class="description"><?php echo $lang['administration_description']; ?></div>
                    </a>
                <?php }
            } else { ?>
                <a href="?p=login">
                    <div class="option"><?php echo $lang['login']; ?></div>
                    <div class="description"><?php echo $lang['login_description']; ?></div>
                </a>
        <?php } ?>
    </div>
    <div id="content">
        <?php
            if ($loggedin) {
                if (isset($_GET['p'])) {
                    $page = $_GET['p'] . ".php";
                    if (file_exists($page))
                        require $page;
                    else
                        require "404.php";
                } elseif (isset($_GET['act'])) {
                    $page = "action/" . $_GET['act'] . ".php";
                    if (file_exists($page))
                        require $page;
                    else
                        require "404.php";
                } else
                    require "balance.php";
            } else {
                if (isset($_GET['act'])) {
                    $page = "action/" . $_GET['act'] . ".php";
                    if ($page = "action/login.php")
                        require $page;
                    else
                        require "login.php";
                } else
                    require "login.php";
            }
        ?>
    </div>
    <div id="footer">HouSplit Beta - Copyright &copy; 2014-2015, Yago Arroyo</div>
</body>
</html>