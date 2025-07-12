<?php
session_start(); // Start the session

// Check if the admin or player is logged in
if (isset($_SESSION['admin'])) {
    // Admin is logged in, unset the session variable and destroy the session
    unset($_SESSION['admin']);
    session_destroy();
    header('Location: admin.php');
}

?>
