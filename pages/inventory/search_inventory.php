<?php include '../../components/head.php';
if (isset($_COOKIE['role']) && $_COOKIE['role'] !== 'staff') {
} else {
    header('Location: ../../index.php');
    exit();
}
?>
<title>Product Inventory</title>
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../../css/check_inventory.css">
</head>

<body>
<div class="container">
    <h1>Product Inventory</h1>
    <form onsubmit="handleInventorySubmit(event)">
        <div class="form-group">
            <label for="product-number">Product Number:</label>
            <input type="text" id="product-number" name="product-number" placeholder="Enter product number" required>
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
                <th>Product ID</th>
                <th>Zone</th>
                <th>Storage Number</th>
                <th>Storage Level</th>
                <th>Quantity</th>
                <th>Barcode</th>
            </tr>
            </thead>
            <tbody id="inventory-table-body">
            <!-- Data will be populated here -->
            </tbody>
        </table>
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
            $dashboard_url = '../../pages/inventory.php';
            break;
        default:
            $dashboard_url = '../../login.html';
            break;
    }
    ?>
    <!-- Return Button at the Bottom -->
    <div class="return-button-container">
        <a href="../<?php echo $dashboard_url; ?>" class="return-button">Return to Main Menu</a>
    </div>
</div>

<script>
    async function handleInventorySubmit(event) {
        event.preventDefault(); // Prevent default form submission

        const productNumberInput = document.getElementById('product-number');
        const productNumber = productNumberInput.value.trim().toUpperCase();

        if (!productNumber) {
            alert('Please enter a product number.');
            return;
        }

        try {
            const response = await fetch('../../php/search_inventory.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ productNumber })
            });

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`Network response was not ok: ${errorText}`);
            }

            const data = await response.json();

            if (data.length > 0) {
                let totalQuantity = 0;
                const tableBody = document.getElementById('inventory-table-body');
                tableBody.innerHTML = ''; // Clear previous data

                data.forEach(item => {
                    totalQuantity += item.quantity;
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.product_id}</td>
                        <td>${item.zone}</td>
                        <td>${item.storage_number}</td>
                        <td>${item.storage_level}</td>
                        <td>${item.quantity}</td>
                        <td><svg id="barcode-${item.barcode}"></svg></td>
                    `;
                    tableBody.appendChild(row);
                });

                document.getElementById('total-quantity').textContent = `Total Quantity: ${totalQuantity}`;
                document.getElementById('inventory-result').classList.remove('hidden');

                // Generate barcodes after the elements are added to the DOM
                data.forEach(item => {
                    generateBarcode(`barcode-${item.barcode}`, item.barcode);
                });
            } else {
                alert('No inventory data found for the given product number.');
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
</script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
</body>
</html>
