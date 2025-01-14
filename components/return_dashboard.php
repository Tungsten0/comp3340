<?php
$role = $_COOKIE['role'];
switch ($role) {
    case 'admin':
        $dashboard_url = '../../pages/admin_dashboard.php';
        break;
    case 'inventory':
        $dashboard_url = '../../pages/inventory_dashboard.php';
        break;
    case 'staff':
        $dashboard_url = '../../pages/user_dashboard.php';
        break;
    default:
        $dashboard_url = '../../login.html';
        break;
}

?>

<div class="btn-container">
    <a href="../<?php echo $dashboard_url; ?>" class="return-button">Return to Main Menu</a>
</div>