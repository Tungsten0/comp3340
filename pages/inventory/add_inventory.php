<?php include '../../components/head.php';
if (isset($_COOKIE['role']) && $_COOKIE['role'] !== 'staff') {
} else {
    header('Location: ../../index.php');
    exit();
}
?>
    <title>Add Materials to Warehouse</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/add_materials.css">
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
            const response = await fetch('../../php/add_inventory.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ productNumber, quantity })
            });

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`Network response was not ok: ${errorText}`);
            }

            const data = await response.json();

            // Display results
            const resultTableBody = document.getElementById('result-table-body');
            resultTableBody.innerHTML = ''; // Clear previous data

            data.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                        <td>${productNumber}</td>
                        <td>${item.barcode}</td>
                        <td>${item.location}</td>
                        <td><svg id="barcode-${item.barcode}"></svg></td>
                    `;
                resultTableBody.appendChild(row);
                generateBarcode(`barcode-${item.barcode}`, item.barcode);
            });

            document.getElementById('result-section').classList.remove('hidden');
        } catch (error) {
            console.error('Error:', error);
            alert(`An error occurred while adding materials: ${error.message}`);
        }
    }

    function generateBarcode(elementId, value) {
        JsBarcode(`#${elementId}`, value, {
            format: 'code128',
            displayValue: true,
        });
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
            <label for="quantity">Quantity (skids):</label>
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
                <th>Product ID</th>
                <th>Barcode</th>
                <th>Storage Location</th>
                <th>Generated Barcode</th>
            </tr>
            </thead>
            <tbody id="result-table-body">
            <!-- Data will be populated here -->
            </tbody>
        </table>
    </div>
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

<div class="btn-container">
    <a href="../<?php echo $dashboard_url; ?>" class="return-button">Return to Main Menu</a>
</div>
</body>
</html>
