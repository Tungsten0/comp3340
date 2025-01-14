<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the user is logged in by checking for cookies
    if (isset($_COOKIE['uid'])) {
        // Destroy cookies by setting their expiration date to a time in the past
        setcookie('uid', '', time() - 3600, "/");
    }

    if (isset($_COOKIE['username'])) {
        setcookie('username', '', time() - 3600, "/");
    }

    if (isset($_COOKIE['name'])) {
        setcookie('name', '', time() - 3600, "/");
    }

    if (isset($_COOKIE['role'])) {
        setcookie('role', '', time() - 3600, "/");
    }

    // Redirect to the login page or home page
    header("Location: ../login.html");
    exit;
} else {
    // Redirect to the home page if accessed directly
    header("Location: ../index.php");
    exit;
}
?>
