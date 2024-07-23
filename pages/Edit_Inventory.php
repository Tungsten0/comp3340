<?php include '../components/header.php'; ?>

    <title>Edit Inventory</title>
    <link rel="stylesheet" href="../css/edit_inventory.css">
</head>

<body>
    <div class="container">
        <h1>Edit Inventory</h1>
        <form onsubmit="handleEdit(event)">
            <div class="form-group">
                <label for="barcode">Barcode:</label>
                <input type="text" id="barcode" name="barcode" placeholder="Enter barcode" required>
            </div>
            <div class="button-group">
                <button type="submit">Check Inventory</button>
                <button type="button" onlick="window.location.href='material_handler_dashboard.html'">Return to Main
                    Menu</button>
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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="inventory-table-body">
                    <!-- Data will be populated here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Popup modal for editing location/quantity -->
    <div id="popup-modal" class="hidden">
        <div class="modal-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <h3>Edit Location and Quantity</h3>
            <div class="form-group">
                <label for="new-location">New Location:</label>
                <input type="text" id="new-location" placeholder="Enter new location" required>
            </div>
            <div class="form-group">
                <label for="new-quantity">New Quantity:</label>
                <input type="number" id="new-quantity" placeholder="Enter new quantity" required>
            </div>
            <button onclick="saveChanges()">Save Changes</button>
        </div>
    </div>
    
    <script>
        function handleEdit(event) {
            event.preventDefault(); // Prevent default form submission

            // Get the form elements
            const barcodeInput = document.getElementById('barcode');

            // Retrieve the product number and convert to upper case
            const barcode = barcodeInput.value.trim().toUpperCase();

            // Check if barcode is filled
            if (!barcode) {
                alert('Please enter a barcode.');
                return;
            }

            // Simulate fetching inventory data (replace this with actual data fetching)
            const inventoryData = {
                "123456789012": [
                    { "zone": "Z01", "number": "001", "level": "A", "quantity": 10, "barcode": "123456789012" },
                    { "zone": "Z02", "number": "003", "level": "B", "quantity": 5, "barcode": "123456789012" }
                ],
                "987654321098": [
                    { "zone": "Z01", "number": "002", "level": "C", "quantity": 20, "barcode": "987654321098" },
                    { "zone": "Z03", "number": "004", "level": "D", "quantity": 15, "barcode": "987654321098" }
                ]
                // Add more example data as needed
            };

            // Convert all keys in inventoryData to upper case for comparison
            const inventoryDataUpper = Object.keys(inventoryData).reduce((acc, key) => {
                acc[key.toUpperCase()] = inventoryData[key];
                return acc;
            }, {});

            const productData = inventoryDataUpper[barcode] || [];

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
                            <td>${item.barcode}</td> 
                            <td><button onclick="openPopup()">Edit location/quantity</button></td>
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

        // Function to open the popup modal
        function openPopup() {
            const modal = document.getElementById('popup-modal');
            modal.classList.add('show');
        }

        // Function to close the popup modal
        function closePopup() {
            const modal = document.getElementById('popup-modal');
            modal.classList.remove('show');
        }

        // Function to handle saving changes
        function saveChanges() {
            // Get new location and quantity inputs
            const newLocation = document.getElementById('new-location').value.trim();
            const newQuantity = parseInt(document.getElementById('new-quantity').value.trim(), 10);

            // Validate inputs (you can add more validation as needed)
            if (!newLocation || !newQuantity || newQuantity <= 0) {
                alert('Please enter valid values for new location and quantity.');
                return;
            }

            // Perform your save changes logic here (replace alert with actual functionality)
            alert(`New Location: ${newLocation}, New Quantity: ${newQuantity}`);

            // Close the popup after saving changes
            closePopup();
        }
    </script>
</body>

</html>