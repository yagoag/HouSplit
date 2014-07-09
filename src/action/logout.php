<?php
    session_start();

    unset($_SESSION['username']);
    unset($_SESSION['userip']);

    header("Location: ../");
?>