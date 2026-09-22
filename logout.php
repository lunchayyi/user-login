<?php
session_start();

// Clear all stored session variables
session_unset();

// Destroy the session completely
session_destroy();

// Redirect back to the login page
header("Location: login.php");
exit();
?>

