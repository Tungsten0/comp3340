<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
session_start();
if (isset($_COOKIE['uid'])) {
    // The uid cookie has been set
    $uid = $_COOKIE['uid'];
    $role = $_COOKIE['role'];

    if ($role == 'admin') {
        header("Location: /pages/admin_dashboard.php");
    } elseif ($role == 'inventory') {
        header("Location: /pages/inventory_dashboard.php");
    } elseif ($role == 'staff') {
        header("Location: /pages/user_dashboard.php");
    } else {
        http_response_code(404);
        header("Location: /pages/404.php");
    }
} else {
    // The uid cookie has not been set
    ?> <script>console.log("User ID cookie is not set.");</script> <?php
    header('Location: login.html#login_not_set');
}