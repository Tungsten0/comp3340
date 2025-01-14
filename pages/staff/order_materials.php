<?php include '../../components/head.php'; ?>
<title>Items on Order Dashboard</title>
<link rel="stylesheet" href="../../css/dashboard_style.css">
<link rel="stylesheet" href="../../css/order_materials.css">

</head>
<body>
<header>
    <h1>Order Material</h1>
</header>
<div class="container">
    <form id="orderForm" method="POST" action="../../php/order_material.php">
        <div class="form-group">
            <label for="productNumber">Product Number:</label>
            <input type="text" id="productNumber" name="productNumber" required>
        </div>
        <div class="form-group">
            <label for="location">Location:</label>
            <select id="location" name="location" required>
                <option value="" disabled selected>Select a location</option>
                <option value="building1">Building 1</option>
                <option value="building2">Building 2</option>
                <option value="building3">Building 3</option>
            </select>
        </div>
        <div class="btn-container">
            <button type="submit" class="btn">Order</button>
        </div>
    </form>
</div>

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

</body>
</html>
