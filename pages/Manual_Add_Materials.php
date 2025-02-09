<?php include '../components/head.php'; ?>
    <title>Add Materials to Warehouse</title>
    <link rel="stylesheet" href="../css/add_materials.css">

    <script>
        async function handleAddMaterials(event) {
            event.preventDefault(); // Prevent default form submission

            // Get the form elements
            const productNumber = document.getElementById('product-number').value;
            const quantity = parseInt(document.getElementById('quantity').value, 10);

            // Validate inputs
            if (!productNumber || isNaN(quantity) || quantity <= 0) {
                alert('Please enter a valid product number and quantity.');
                return;
            }

            // Send data to the backend
            try {
                const response = await fetch('/api/add-materials', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ productNumber, quantity })
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
                alert('An error occurred while adding materials.');
            }
        }

        function clearForm() {
            document.getElementById('product-number').value = '';
            document.getElementById('quantity').value = '';
            document.getElementById('result-section').classList.add('hidden');
        }
    </script>
</head>
<body>
<div class="container">
    <h1>Add Materials to Warehouse</h1>
    <form onsubmit="handleAddMaterials(event)">
        <div class="form-group">
            <label for="product-number">Product Number:</label>
            <input type="text" id="product-number" name="product-number" placeholder="Enter product number" required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" placeholder="Enter quantity" required>
        </div>
        <div class="button-group">
            <button type="submit">Add Materials</button>
            <button type="button" onclick="clearForm()">Clear</button>
        </div>
    </form>
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
