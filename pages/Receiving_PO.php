<?php include '../components/header.php'; ?>
    <title>Add Inventory to Warehouse</title>
    <link rel="stylesheet" href="../css/receiving_PO.css">
    <script>
        async function handlePOInput(event) {
            event.preventDefault(); // Prevent default form submission

            // Get the PO number
            const poNumber = document.getElementById('po-number').value;

            // Validate PO number
            if (!poNumber) {
                alert('Please enter a PO number.');
                return;
            }

            // Simulate fetching checklist data based on PO number (replace this with actual data fetching)
            const checklistData = {
                "20008": [
                    { productNumber: 'P010', description: 'Product A', orderedQuantity: 50 },
                    { productNumber: 'P011', description: 'Product B', orderedQuantity: 30 }
                ]
                // Add more example data as needed
            };

            // Fetch the checklist for the provided PO number
            const products = checklistData[poNumber] || [];

            if (products.length > 0) {
                const checklistTableBody = document.getElementById('checklist-table-body');
                checklistTableBody.innerHTML = ''; // Clear previous data

                // Populate the checklist
                products.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td><input type="checkbox" id="item-${index}" data-product-number="${item.productNumber}" data-description="${item.description}" data-ordered-quantity="${item.orderedQuantity}" data-index="${index}"></td>
                        <td>${item.productNumber}</td>
                        <td>${item.description}</td>
                        <td>${item.orderedQuantity}</td>
                        <td><input type="number" id="actual-quantity-${index}" placeholder="Actual Quantity" min="0" data-index="${index}"></td>
                    `;
                    checklistTableBody.appendChild(row);
                });

                // Show the checklist section
                document.getElementById('checklist-section').classList.remove('hidden');
            } else {
                alert('No products found for the given PO number.');
                document.getElementById('checklist-section').classList.add('hidden');
            }
        }

        async function postInventory() {
            const selectedItems = [];
            document.querySelectorAll('#checklist-table-body input[type="checkbox"]:checked').forEach(checkbox => {
                const index = checkbox.getAttribute('data-index');
                const actualQuantityInput = document.getElementById(`actual-quantity-${index}`);
                selectedItems.push({
                    productNumber: checkbox.getAttribute('data-product-number'),
                    description: checkbox.getAttribute('data-description'),
                    orderedQuantity: parseInt(checkbox.getAttribute('data-ordered-quantity'), 10),
                    actualQuantity: parseInt(actualQuantityInput.value, 10) || 0
                });
            });

            if (selectedItems.length === 0) {
                alert('Please select items to process.');
                return;
            }

            try {
                // Simulate posting inventory data (replace this with actual data posting)
                const response = await fetch('/api/post-inventory', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ items: selectedItems })
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();

                // Display results
                const resultTableBody = document.getElementById('result-table-body');
                resultTableBody.innerHTML = ''; // Clear previous data

                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.barcode}</td>
                        <td>${item.location}</td>
                    `;
                    resultTableBody.appendChild(row);
                });

                document.getElementById('result-section').classList.remove('hidden');
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while posting inventory.');
            }
        }

        function clearForm() {
            document.getElementById('po-number').value = '';
            document.getElementById('checklist-section').classList.add('hidden');
            document.getElementById('result-section').classList.add('hidden');
        }
    </script>
</head>
<body>
<div class="container">
    <h1>Add Inventory to Warehouse</h1>
    <form onsubmit="handlePOInput(event)">
        <div class="form-group">
            <label for="po-number">PO Number:</label>
            <input type="text" id="po-number" name="po-number" placeholder="Enter PO number" required>
        </div>
        <div class="button-group">
            <button type="submit">Generate Checklist</button>
            <button type="button" onclick="clearForm()">Clear</button>
        </div>
    </form>

    <!-- Checklist Section -->
    <div id="checklist-section" class="hidden">
        <h2>Confirm Details</h2>
        <table>
            <thead>
            <tr>
                <th>Select</th>
                <th>Product Number</th>
                <th>Description</th>
                <th>Ordered Quantity</th>
                <th>Actual Quantity</th>
            </tr>
            </thead>
            <tbody id="checklist-table-body">
            <!-- Checklist data will be populated here -->
            </tbody>
        </table>
        <div class="button-group">
            <button type="button" onclick="postInventory()">Post</button>
        </div>
    </div>

    <!-- Result Section -->
    <div id="result-section" class="hidden">
        <h2>Assigned Barcodes and Storage Locations</h2>
        <table>
            <thead>
            <tr>
                <th>Barcode</th>
                <th>Storage Location</th>
            </tr>
            </thead>
            <tbody id="result-table-body">
            <!-- Data will be populated here -->
            </tbody>
        </table>
    </div>
</div>

<!-- Return Button at the Bottom -->
<div class="return-button-container">
    <a href="material_handler_dashboard.html" class="return-button">Return to Main Menu</a>
</div>
</body>
</html>


