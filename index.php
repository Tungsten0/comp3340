<?php
$request = $_SERVER['REQUEST_URI'];

// Define your routing rules
//Render main content here
if (isset($_COOKIE['uid'])) {
  // The uid cookie has been set
  $uid = $_COOKIE['uid'];
  ?> <script>console.log("User ID: " + <?php echo $uid; ?>);</script> <?php
  //echo "User ID: " . htmlspecialchars($uid);
  switch ($request) {
    case '/' :
      require __DIR__ . '/pages/Add_User.php';
      break;
    default:
      http_response_code(404);
      require __DIR__ . '/pages/404.php';
      break;
  }
} else {
  // The uid cookie has not been set
  ?> <script>console.log("User ID cookie is not set.");</script> <?php
  //echo "User ID cookie is not set.";
  header('Location: /pages/login.html');
  //require __DIR__ . '/pages/login.php';
}