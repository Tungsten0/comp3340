<?php include '../../components/head.php'; ?>
<title>Items on Order Dashboard</title>
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../../css/dashboard_style.css">
<link rel="stylesheet" href="../../css/user_dashboard.css">
</head>
<body>
<div class="dashboard-container">
    <h1><span id="user-name">User</span></h1>
    <h2>Items on Order</h2>
    <table id="items-table">
        <thead>
        <tr>
            <th>Product</th>
            <th>Delivery Location</th>
            <th>Requester</th>
            <th>Fulfilled</th>
        </tr>
        </thead>
        <tbody id="items-list">
        <!-- Items will be dynamically added here -->
        </tbody>
    </table>
    <p id="no-items-message" style="display: none;">No Items on Order</p>
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
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const itemsList = document.getElementById('items-list');
        const noItemsMessage = document.getElementById('no-items-message');

        fetch('../../php/fetch_orders.php')
            .then(response => response.json())
            .then(data => {
                // Uncomment the following line for debugging purposes
                // console.log('Data received:', data);

                if (data.length === 0) {
                    noItemsMessage.style.display = 'block';
                    itemsList.style.display = 'none';
                } else {
                    noItemsMessage.style.display = 'none';
                    itemsList.style.display = 'table-row-group';

                    data.forEach(item => {
                        // Uncomment the following line for debugging purposes
                        // console.log('Processing item:', item);

                        const row = document.createElement('tr');

                        const productCell = document.createElement('td');
                        productCell.textContent = item.product_id || 'N/A';
                        row.appendChild(productCell);

                        const locationCell = document.createElement('td');
                        locationCell.textContent = item.delivery_location || 'N/A';
                        row.appendChild(locationCell);

                        const requesterCell = document.createElement('td');
                        requesterCell.textContent = item.requester || 'N/A';
                        row.appendChild(requesterCell);

                        const fulfilledCell = document.createElement('td');
                        fulfilledCell.textContent = item.fulfilled ? 'Yes' : 'No';
                        row.appendChild(fulfilledCell);

                        itemsList.appendChild(row);

                        // Uncomment the following line for debugging purposes
                        // console.log('Row added:', row.innerHTML);
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                noItemsMessage.style.display = 'block';
                noItemsMessage.textContent = 'Error fetching order data';
            });
    });
</script>

</body>
</html>
