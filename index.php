<?php
$request = $_SERVER['REQUEST_URI'];

// Define your routing rules
//Render main content here
if (isset($_COOKIE['user_id'])) {
  // The user_id cookie has been set
  $user_id = $_COOKIE['user_id'];
  ?> <script>console.log("User ID: " + <?php echo $user_id; ?>);</script> <?php
  //echo "User ID: " . htmlspecialchars($user_id);
  switch ($request) {
    case '/login' :
      require __DIR__ . '/pages/login.html';
      break;
    default:
      http_response_code(404);
      require __DIR__ . '/pages/404.php';
      break;
  }
} else {
  // The user_id cookie has not been set
  ?> <script>console.log("User ID cookie is not set.");</script> <?php
  //echo "User ID cookie is not set.";
  header('Location: /pages/login.html');
  //require __DIR__ . '/pages/login.php';
}