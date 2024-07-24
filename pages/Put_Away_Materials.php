<?php include '../components/head.php'; ?>
    <title>Put Away Product</title>
    <link rel="stylesheet" href="../css/putaway_materials.css">
    <script>
        async function handlePutAway(event) {
            event.preventDefault(); // Prevent default form submission

            const barcode = document.getElementById('barcode').value;

            if (!barcode) {
                alert('Please enter a valid barcode.');
                return;
            }

            try {
                const response = await fetch(`/api/lookup-product/${encodeURIComponent(barcode)}`);
                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                const resultSection = document.getElementById('result-section');
                const resultTableBody = document.getElementById('result-table-body');

                if (data.error) {
                    resultSection.classList.add('hidden');
                    alert(data.error);
                    return;
                }

                resultTableBody.innerHTML = `
                    <tr>
                        <td>${data.productNumber}</td>
                        <td>${data.quantity}</td>
                        <td>${data.currentLocation}</td>
                    </tr>
                `;

                resultSection.classList.remove('hidden');
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while looking up the product.');
            }
        }

        async function confirmLocation() {
            const barcode = document.getElementById('barcode').value;
            const newLocation = document.getElementById('new-location').value;

            if (!barcode || !newLocation) {
                alert('Please enter a valid barcode and new location.');
                return;
            }

            try {
                const response = await fetch('/api/confirm-location', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ barcode, newLocation })
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();

                if (data.success) {
                    alert('Location confirmed successfully.');
                } else {
                    alert(data.error || 'An error occurred.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while confirming the location.');
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <h1>Put Away Product</h1>
        <form onsubmit="handlePutAway(event)">
            <div class="form-group">
                <label for="barcode">Barcode:</label>
                <input type="text" id="barcode" name="barcode" placeholder="Enter barcode" required>
            </div>
            <div class="button-group">
                <button type="submit">Look Up Product</button>
                <button type="button" onclick="window.location.href='material_handler_dashboard.html'">Return to Main
                    Menu</button>
            </div>
        </form>
        <div id="result-section" class="hidden">
            <h2>Product Details</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product Number</th>
                        <th>Quantity</th>
                        <th>Current Location</th>
                    </tr>
                </thead>
                <tbody id="result-table-body">
                    <!-- Data will be populated here -->
                </tbody>
            </table>
            <div class="form-group">
                <label for="new-location">New Location:</label>
                <input type="text" id="new-location" name="new-location" placeholder="Enter new location" required>
            </div>
            <div class="button-group">
                <button type="button" onclick="confirmLocation()">Confirm Location</button>
                <button type="button" onclick="window.location.href='admin_dashboard.html'">Return to Main Menu</button>
            </div>
        </div>
    </div>
</body>

</html>