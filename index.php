<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$request = $_SERVER['REQUEST_URI'];

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
        if ($role == 'admin') {
          include __DIR__ . '/pages/admin_dashboard.php';
        } else if ($role == 'inventory') {
          require __DIR__ . '/pages/inventory.php';
        } else {
          require __DIR__ . '/pages/dashboard.php';
        }
        break;
    case '/admin_dashboard/add_user':
        require __DIR__ . '/pages/Add_User.php';
        break;
    case '/dashboard':
        require __DIR__ . '/pages/Dashboard.php';
        break;
    case '/check_inventory':
        require __DIR__ . '/pages/Check_Inventory.php';
        break;
    case '/inventory':
        require __DIR__ . '/pages/inventory.php';
        break;
    case '/products':
        require __DIR__ . '/pages/products.php';
        break;
    case '/warehouse':
        require __DIR__ . '/pages/warehouse.php';
        break;
    case '/view_PO':
        require __DIR__ . '/pages/View_PO.php';
        break;
    case '/create_PO':
        require __DIR__ . '/pages/Create_PO.php';
        break;
    case '/receive_PO':
        require __DIR__ . '/pages/Receiving_PO.php';
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