<?php include '../../components/head.php';
if (isset($_COOKIE['role']) && $_COOKIE['role'] !== 'staff') {
} else {
    header('Location: ../../index.php');
    exit();
}?>
<title>Put Away Product</title>
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../../css/putaway_materials.css">
<script>
    async function handlePutAway(event) {
        event.preventDefault(); // Prevent default form submission

        const barcode = document.getElementById('barcode').value;

        if (!barcode) {
            alert('Please enter a valid barcode.');
            return;
        }

        try {
            const response = await fetch('../../php/lookup_product.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ barcode })
            });
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
                        <td>${data.product_id}</td>
                        <td>${data.quantity}</td>
                        <td>${data.current_location}</td>
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

        if (!barcode) {
            alert('Please enter a valid barcode.');
            return;
        }

        try {
            const response = await fetch('../../php/confirm_location.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ barcode })
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
            <button type="button"><a style="text-decoration: none; color: white" href="../<?php echo $dashboard_url; ?>" class="return-button">Return to Main Menu</a></button>
        </div>
    </form>
    <div id="result-section" class="hidden">
        <h2>Product Details</h2>
        <table>
            <thead>
            <tr>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Current Location</th>
            </tr>
            </thead>
            <tbody id="result-table-body">
            <!-- Data will be populated here -->
            </tbody>
        </table>
        <div class="button-group">
            <button type="button" onclick="confirmLocation()">Confirm Location</button>
            <button type="button" onclick="window.location.href='../inventory_dashboard.php'">Return to Main Menu</button>
        </div>
    </div>

</div>
</body>

</html>
