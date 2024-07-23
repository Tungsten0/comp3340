<?php include '../php/header.php'; ?>
    <title>Product Inventory</title>
    <link rel="stylesheet" href="../css/check_inventory.css">
</head>

<body>
    <div class="container">
        <h1>Product Inventory</h1>
        <form onsubmit="handleInventorySubmit(event)">
            <div class="form-group">
                <label for="product-number">Product Number:</label>
                <input type="text" id="product-number" name="product-number" placeholder="Enter product number"
                    required>
            </div>
            <div class="button-group">
                <button type="submit">Check Inventory</button>
            </div>
        </form>
        <div id="inventory-result" class="hidden">
            <h2>Inventory Details</h2>
            <p id="total-quantity"></p>
            <table>
                <thead>
                    <tr>
                        <th>Zone</th>
                        <th>Storage Number</th>
                        <th>Storage Level</th>
                        <th>Quantity</th>
                        <th>Barcode</th> <!-- Added Barcode Column -->
                    </tr>
                </thead>
                <tbody id="inventory-table-body">
                    <!-- Data will be populated here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Return Button at the Bottom -->
    <div class="return-button-container">
        <a href="material_handler_dashboard.html" class="return-button">Return to Main Menu</a>
    </div>

    <script>
        function handleInventorySubmit(event) {
            event.preventDefault(); // Prevent default form submission

            // Get the form elements
            const productNumberInput = document.getElementById('product-number');

            // Retrieve the product number and convert to upper case
            const productNumber = productNumberInput.value.trim().toUpperCase();

            // Check if product number is filled
            if (!productNumber) {
                alert('Please enter a product number.');
                return;
            }

            // Simulate fetching inventory data (replace this with actual data fetching)
            const inventoryData = {
                "P001": [
                    { "zone": "Z01", "number": "001", "level": "A", "quantity": 10, "barcode": "123456789012" },
                    { "zone": "Z02", "number": "003", "level": "B", "quantity": 5, "barcode": "987654321098" }
                ],
                "P002": [
                    { "zone": "Z01", "number": "002", "level": "C", "quantity": 20, "barcode": "564738291056" },
                    { "zone": "Z03", "number": "004", "level": "D", "quantity": 15, "barcode": "192837465091" }
                ]
                // Add more example data as needed
            };

            // Convert all keys in inventoryData to upper case for comparison
            const inventoryDataUpper = Object.keys(inventoryData).reduce((acc, key) => {
                acc[key.toUpperCase()] = inventoryData[key];
                return acc;
            }, {});

            const productData = inventoryDataUpper[productNumber] || [];

            if (productData.length > 0) {
                let totalQuantity = 0;
                const tableBody = document.getElementById('inventory-table-body');
                tableBody.innerHTML = ''; // Clear previous data

                productData.forEach(item => {
                    totalQuantity += item.quantity;
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.zone}</td>
                        <td>${item.number}</td>
                        <td>${item.level}</td>
                        <td>${item.quantity}</td>
                        <td>${item.barcode}</td> <!-- Added Barcode Data -->
                    `;
                    tableBody.appendChild(row);
                });

                document.getElementById('total-quantity').textContent = `Total Quantity: ${totalQuantity}`;
                document.getElementById('inventory-result').classList.remove('hidden');
            } else {
                alert('No inventory data found for the given product number.');
                document.getElementById('inventory-result').classList.add('hidden');
            }
        }
    </script>
</body>

</html>