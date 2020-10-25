<?php
    session_name ("aplikaceples");
    session_start();
    unset($_SESSION['id']);
    unset($_SESSION['nick']);
    session_destroy();

    header("location:../../index.php");
    exit;
?>