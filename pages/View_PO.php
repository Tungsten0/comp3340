<?php include '../components/head.php'; ?>
    <title>View Purchase Order</title>
    <link rel="stylesheet" href="../css/view_PO.css">
</head>
<body>
<header>
    <h1>View Purchase Order</h1>
</header>
<div class="container">
    <!-- Input PO Section -->
    <div class="section">
        <h2>Enter PO Number</h2>
        <form id="po-form">
            <label for="po-number">PO Number:</label>
            <input type="text" id="po-number" name="po-number" required>
            <button type="button" class="btn" onclick="fetchPO()">Search</button>
        </form>
    </div>

    <!-- Display PO Details Section -->
    <div class="section" id="po-details" style="display: none;">
        <h2>PO Details</h2>
        <table id="po-details-table">
            <thead>
            <tr>
                <th>Product Number</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            </thead>
            <tbody id="po-items">
            <!-- Items will be populated here -->
            </tbody>
        </table>
    </div>

    <!-- Display All POs Section -->
    <div class="section">
        <h2>All Purchase Orders</h2>
        <table id="all-po-table">
            <thead>
            <tr>
                <th>PO Number</th>
                <th>Company</th>
                <th>Total Quantity</th>
            </tr>
            </thead>
            <tbody id="all-po-items">
            <!-- PO data will be populated here -->
            </tbody>
        </table>
    </div>

    <div class="btn-container">
        <a href="admin_dashboard.html" class="return-btn">Return to Main Menu</a>
    </div>
</div>

<script>
    const mockPOData = {
        'PO123456': {
            company: 'Example Company',
            items: [
                { productNumber: '001', productName: 'Widget', quantity: 10, price: '19.99' },
                { productNumber: '002', productName: 'Gadget', quantity: 5, price: '29.99' }
            ]
        },
        'PO123457': {
            company: 'Another Company',
            items: [
                { productNumber: '003', productName: 'Doodad', quantity: 7, price: '14.99' }
            ]
        }
        // Add more mock PO data here
    };

    function fetchPO() {
        const poNumber = document.getElementById('po-number').value.trim().toUpperCase();
        const poDetailsSection = document.getElementById('po-details');
        const poItemsBody = document.getElementById('po-items');

        // Clear previous results
        poItemsBody.innerHTML = '';

        // Convert all keys to uppercase for case-insensitive comparison
        const poDataKeys = Object.keys(mockPOData).reduce((acc, key) => {
            acc[key.toUpperCase()] = mockPOData[key];
            return acc;
        }, {});

        // Fetch data for the given PO number
        const poData = poDataKeys[poNumber];

        if (poData) {
            poDetailsSection.style.display = 'block';
            poItemsBody.innerHTML = '';
            poData.items.forEach(item => {
                poItemsBody.innerHTML += `
                    <tr>
                        <td>${item.productNumber}</td>
                        <td>${item.productName}</td>
                        <td>${item.quantity}</td>
                        <td>${item.price}</td>
                    </tr>
                `;
            });
        } else {
            alert('PO Number not found.');
            poDetailsSection.style.display = 'none';
        }
    }

    function displayAllPOs() {
        const allPOItemsBody = document.getElementById('all-po-items');

        // Clear previous results
        allPOItemsBody.innerHTML = '';

        Object.entries(mockPOData).forEach(([poNumber, poData]) => {
            const totalQuantity = poData.items.reduce((sum, item) => sum + item.quantity, 0);

            allPOItemsBody.innerHTML += `
                <tr>
                    <td>${poNumber}</td>
                    <td>${poData.company}</td>
                    <td>${totalQuantity}</td>
                </tr>
            `;
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Display all POs when the page loads
        displayAllPOs();
    });
</script>
</body>
</html>
