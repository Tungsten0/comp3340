<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$request = $_SERVER['REQUEST_URI'];

// Define your routing rules
//Render main content here
if (isset($_COOKIE['uid'])) {
  // The uid cookie has been set
  $uid = $_COOKIE['uid'];
  $role = $_COOKIE['role'];
  echo "User ID: " . htmlspecialchars($uid);
  echo "Role: " . htmlspecialchars($role);
  echo "request: " . htmlspecialchars($request);
  switch ($request) {
    case '/':
      echo "in /";
      include __DIR__ . '/test.html';
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
  echo "end of switch";
} else {
  echo "in else";
  // The uid cookie has not been set
  ?> <script>console.log("User ID cookie is not set.");</script> <?php
  echo "User ID cookie is not set.";
  $uid = $_COOKIE['uid'];
  echo "User ID: " . htmlspecialchars($uid);
  header('Location: /login.html#login_not_set');
}