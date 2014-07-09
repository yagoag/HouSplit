<?php include_once "action/session.php"; ?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>RePepeca</title>
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
        <img src="img/logo.png" />
        NAME OS ZEEW WEBSIETS
    </div>
    <div id="sidebar">
        <a href="?p=new_bill">
            <div class="option">New Bill</div>
            <div class="description">create a new bill</div>
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
                    include $_GET['p'] . ".php";
                } else
                    include "new_bill.php";
            } else
                include "login.php";
        ?>
    </div>
    <div id="footer">RePepeca Alpha 1 - Copyright &copy; 2014, Yago Arroyo</div>
</body>
</html>