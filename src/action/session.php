<?php
    session_start();

    if (!isset($_SESSION['username']) || $_SESSION['userip'] != $_SERVER['REMOTE_ADDR']) {
        $loggedin = false;
    } else {
        $loggedin = true;
        $user = $_SESSION['username'];
    }
?>