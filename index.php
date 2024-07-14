<?php
  $request = $_SERVER['REQUEST_URI'];

  // Define your routing rules
  //Render main content here
  //check cookies for login session
  //if not logged in, show login form
  //if logged in, show dashboard/main page
  switch ($request) {
    case '/login' :
      require __DIR__ . '/pages/login.php';
      break;
    case '/' :
      require __DIR__ . '/pages/home.php';
      break;
    case '/about' :
      require __DIR__ . '/pages/about.php';
      break;
    case '/chats' :
      require __DIR__ . '/pages/contact.php';
      break;
      // Add more routes as needed
    default:
      http_response_code(404);
      require __DIR__ . '/pages/404.php';
      break;
  }

