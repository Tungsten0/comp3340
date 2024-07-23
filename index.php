<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$request = $_SERVER['REQUEST_URI'];

// Define your routing rules
//Render main content here
if (isset($_COOKIE['uid'])) {
  // The uid cookie has been set
  $uid = $_COOKIE['uid'];
  $role = $_COOKIE['role'];

  switch ($role) {
    case 'admin':
      echo "in admin";
      break;
    case 'inventory':
      echo "in inventory";
      break;
    default: //default is staff
      echo "in staff";
      break;
  }

  switch ($request) {
    case '/':
      echo "in /";
      require __DIR__ . '/pages/admin_dashboard.html';
      break;
    case '/add_user':
      echo "in add user";
      require __DIR__ . '/pages/Add_User.php';
      break;
    default:
      echo "in default";
      http_response_code(404);
      require __DIR__ . '/pages/404.php';
      break;
  }
} else {
  // The uid cookie has not been set
  ?> <script>console.log("User ID cookie is not set.");</script> <?php
  header('Location: /login.html#login_not_set');
}