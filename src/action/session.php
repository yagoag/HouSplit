<?php
    session_start();

    if (!isset($_SESSION['username']) || $_SESSION['userip'] != $_SERVER['REMOTE_ADDR']) {
        echo "Illegal session detected. Your session has been terminated.";
        die();
    }
?>