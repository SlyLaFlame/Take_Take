<?php
session_start();

if (isset($_SESSION['login'])) {
    // Player is logged in, unset the session variable and destroy the session
    unset($_SESSION['login']);
    session_destroy();
    header('Location: login.php');
exit();
}