<?php
$request = $_SERVER['REQUEST_URI'];

// Define your routing rules
//Render main content here
if (isset($_COOKIE['user_id'])) {
  // The user_id cookie has been set
  $user_id = $_COOKIE['user_id'];
  echo "User ID: " . htmlspecialchars($user_id);
  header('Location: /pages/home.php');
} else {
  // The user_id cookie has not been set
  echo "User ID cookie is not set.";
  switch ($request) {
    case '/login' :
      require __DIR__ . '/pages/login.php';
      break;
    default:
      http_response_code(404);
      require __DIR__ . '/pages/404.php';
      break;
  }
}