<?php include '../../components/head.php';
if (isset($_COOKIE['role']) && $_COOKIE['role'] !== 'staff') {
} else {
    header('Location: ../../index.php');
    exit();
}
?>
<title>Delete Inventory</title>
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../../css/edit_inventory.css">
</head>

<body>
<div class="container">
    <h1>Delete Inventory</h1>
    <form onsubmit="handleDelete(event)">
        <div class="form-group">
            <label for="barcode">Storage Location:</label>
            <input type="text" id="barcode" name="barcode" placeholder="Enter storage location" required>
        </div>
        <div class="button-group">
            <button type="submit">Check Inventory</button>
            <?php include '../../components/return_dashboard.php'; ?>
        </div>
    </form>
    <div id="inventory-result" class="hidden">
        <h2>Inventory Details</h2>
        <table>
            <thead>
            <tr>
                <th>Product ID</th>
                <th>Zone</th>
                <th>Storage Number</th>
                <th>Storage Level</th>
                <th>Quantity</th>
                <th>Barcode</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="inventory-table-body">
            <!-- Data will be populated here -->
            </tbody>
        </table>
    </div>
</div>

<script>
    async function handleDelete(event) {
        event.preventDefault(); // Prevent default form submission

        const barcodeInput = document.getElementById('barcode');
        const barcode = barcodeInput.value.trim().toUpperCase();

        if (!barcode) {
            alert('Please enter a storage location.');
            return;
        }

        try {
            const response = await fetch('../../php/search_inventory.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ storageLocation: barcode })
            });

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`Network response was not ok: ${errorText}`);
            }

            const data = await response.json();

            if (data.length > 0) {
                const tableBody = document.getElementById('inventory-table-body');
                tableBody.innerHTML = ''; // Clear previous data

                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.product_id}</td>
                        <td>${item.zone}</td>
                        <td>${item.storage_number}</td>
                        <td>${item.storage_level}</td>
                        <td>${item.quantity}</td>
                        <td><svg id="barcode-${item.barcode}"></svg></td>
                        <td><button onclick="deleteInventory('${item.barcode}')">Delete</button></td>
                    `;
                    tableBody.appendChild(row);
                });

                document.getElementById('inventory-result').classList.remove('hidden');

                // Generate barcodes after the elements are added to the DOM
                data.forEach(item => {
                    generateBarcode(`barcode-${item.barcode}`, item.barcode);
                });
            } else {
                alert('No inventory data found for the given storage location.');
                document.getElementById('inventory-result').classList.add('hidden');
            }
        } catch (error) {
            console.error('Error:', error);
            alert(`An error occurred while fetching inventory data: ${error.message}`);
        }
    }

    function generateBarcode(elementId, value) {
        JsBarcode(`#${elementId}`, value, {
            format: 'code128',
            displayValue: true,
        });
    }

    async function deleteInventory(barcode) {
        const confirmDelete = confirm('Are you sure you want to delete this inventory item?');
        if (!confirmDelete) return;

        try {
            const response = await fetch('../../php/delete_inventory.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ barcode })
            });

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`Network response was not ok: ${errorText}`);
            }

            alert('Inventory item deleted successfully.');
            handleDelete(new Event('submit')); // Refresh the inventory list
        } catch (error) {
            console.error('Error:', error);
            alert(`An error occurred while deleting the inventory item: ${error.message}`);
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
</body>
</html>
