<?php include '../components/head.php'; ?>
    <title>Items on Order Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard_style.css">
    <link rel="stylesheet" href="../css/user_dashboard.css">

</head>
<body>
<div class="dashboard-container">
    <h1><span id="user-name">User</span></h1>
    <h2>Items on Order</h2>
    <table id="items-table">
        <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Delivery Location</th>
        </tr>
        </thead>
        <tbody id="items-list">
        <!-- Items will be dynamically added here -->
        </tbody>
    </table>
    <p id="no-items-message" style="display: none;">No Items on Order</p>
</div>
<!-- Button Container -->
<div class="button-container">
    <button onclick="location.href='dashboard.html'" class="return-button">Return to Main Menu</button>
</div>

<script src="scripts/dashboard_script.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const itemsList = document.getElementById('items-list');
        const noItemsMessage = document.getElementById('no-items-message');

        // Example data - replace with actual data fetching logic
        const items = [
            { product: 'Widget A', quantity: 10, location: 'Warehouse 1' },
            { product: 'Widget B', quantity: 5, location: 'Warehouse 2' },
            // Add more items as needed
        ];

        if (items.length === 0) {
            noItemsMessage.style.display = 'block';
            itemsList.style.display = 'none';
        } else {
            noItemsMessage.style.display = 'none';
            itemsList.style.display = 'table-row-group'; // Ensures table rows are displayed correctly

            items.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.product}</td>
                    <td>${item.quantity}</td>
                    <td>${item.location}</td>
                `;
                itemsList.appendChild(row);
            });
        }
    });
</script>

<script src="dashboard_script.js"></script>
</body>
</html>
