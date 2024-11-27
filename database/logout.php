<?php

if (isset($_GET['user'])) {
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['admin'])) {
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../admin/index.php");
    exit();
}

