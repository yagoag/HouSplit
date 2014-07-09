<?php
    session_start();
    $loggedin = (isset($_SESSION['username']) && $_SESSION['userip'] == $_SERVER['REMOTE_ADDR']);
    if ($loggedin)
        $user = $_SESSION['username'];
?>