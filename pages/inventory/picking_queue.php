<?php include '../../components/head.php';
if (isset($_COOKIE['role']) && $_COOKIE['role'] !== 'staff') {
} else {
    header('Location: ../../index.php');
    exit();
}
?>
<title>Picking Queue</title>
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../../css/picking_queue.css">

<script>
    let queue = [];
    let currentIndex = 0;

    async function fetchQueue() {
        try {
            const response = await fetch('../../php/fetch_orders.php');
            if (!response.ok) throw new Error('Network response was not ok');

            const data = await response.json();
            queue = data.filter(order => !order.fulfilled); // Filter out fulfilled orders
            if (queue.length === 0) {
                showError('There are no orders currently.');
            } else {
                displayCurrentItem();
            }
        } catch (error) {
            showError('An error occurred while fetching the queue.');
        }
    }

    async function fetchNextStorageLocation(productId) {
        try {
            const response = await fetch(`../../php/next_storage_location.php?product_id=${productId}`);
            if (!response.ok) throw new Error('Network response was not ok');

            const data = await response.json();
            return data.storage_location || 'N/A';
        } catch (error) {
            return 'N/A';
        }
    }

    async function displayCurrentItem() {
        if (queue.length === 0 || currentIndex >= queue.length) {
            showError('No more items in the queue.');
            return;
        }

        const item = queue[currentIndex];
        const productNumberElem = document.getElementById('product-number');
        const deliveryLocationElem = document.getElementById('delivery-location');
        const storageLocationElem = document.getElementById('storage-location');
        const barcodeInputElem = document.getElementById('barcode');
        const deliveryLocationInputElem = document.getElementById('delivery-location-input');
        const currentPositionElem = document.getElementById('current-position');

        if (!productNumberElem || !deliveryLocationElem || !storageLocationElem || !barcodeInputElem || !deliveryLocationInputElem || !currentPositionElem) {
            showError('Required elements are missing in the HTML.');
            return;
        }

        productNumberElem.textContent = item.product_id;
        deliveryLocationElem.textContent = item.delivery_location;

        const storageLocation = await fetchNextStorageLocation(item.product_id);
        storageLocationElem.textContent = storageLocation;

        barcodeInputElem.value = '';
        deliveryLocationInputElem.value = item.delivery_location;
        currentPositionElem.textContent = `${currentIndex + 1}/${queue.length}`;
        document.getElementById('confirm-section').classList.remove('hidden');
        document.getElementById('delivery-section').classList.add('hidden');
        clearError();
    }

    async function handleBarcodeConfirmation(event) {
        event.preventDefault();
        const barcode = document.getElementById('barcode').value;

        if (!barcode) {
            showError('Please enter a valid barcode.');
            return;
        }

        try {
            const response = await fetch('../../php/confirm_barcode.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ barcode, product_id: queue[currentIndex].product_id })
            });

            if (!response.ok) throw new Error('Network response was not ok');

            const data = await response.json();

            if (data.success) {
                document.getElementById('confirm-section').classList.add('hidden');
                document.getElementById('delivery-section').classList.remove('hidden');
                clearError();
            } else {
                showError(data.error || 'An error occurred.');
            }
        } catch (error) {
            showError('An error occurred while confirming the barcode.');
        }
    }

    async function handleDeliveryConfirmation(event) {
        event.preventDefault();
        const deliveryLocation = document.getElementById('delivery-location-input').value;

        if (!deliveryLocation) {
            showError('Please enter a delivery location.');
            return;
        }

        try {
            const response = await fetch('../../php/confirm_delivery.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ product_id: queue[currentIndex].product_id, delivery_location: deliveryLocation })
            });

            // Check if response is JSON
            const contentType = response.headers.get('Content-Type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Expected JSON response but got ' + contentType);
            }

            const data = await response.json();

            if (data.success) {
                alert('Delivery confirmed successfully!');
                currentIndex++;
                displayCurrentItem();
            } else {
                showError(data.error || 'An error occurred.');
            }
        } catch (error) {
            showError('An error occurred while confirming the delivery location.');
        }
    }

    function showError(message) {
        const errorMessageDiv = document.getElementById('error-message');
        errorMessageDiv.textContent = message;
        errorMessageDiv.classList.remove('hidden');
    }

    function clearError() {
        const errorMessageDiv = document.getElementById('error-message');
        errorMessageDiv.textContent = '';
        errorMessageDiv.classList.add('hidden');
    }

    window.onload = fetchQueue;

</script>
</head>
<body>
<div class="container">
    <h1>Picking Queue</h1>
    <div id="error-message" class="error-message hidden"></div>
    <div id="confirm-section">
        <h2>Product Details</h2>
        <div class="table-wrapper">
            <div class="table-blur"></div>
            <table>
                <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Delivery Location</th>
                    <th>Storage Location</th>
                    <th>Barcode</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td id="product-number"></td>
                    <td id="delivery-location"></td>
                    <td id="storage-location"></td>
                    <td>
                        <form onsubmit="handleBarcodeConfirmation(event)">
                            <input type="text" id="barcode" name="barcode" placeholder="Enter barcode" required>
                            <button type="submit">Confirm Barcode</button>
                        </form>
                    </td>
                </tr>
                </tbody>
            </table>
            <!-- Add the current position element here -->
            <div id="current-position"></div>
        </div>
    </div>
    <div id="delivery-section" class="hidden">
        <h2>Delivery Details</h2>
        <form onsubmit="handleDeliveryConfirmation(event)">
            <div class="form-group">
                <label for="delivery-location-input">Delivery Location:</label>
                <input type="text" id="delivery-location-input" name="delivery-location" placeholder="Enter delivery location" required>
            </div>
            <div class="button-group">
                <button type="submit">Confirm to Delivery Location</button>
            </div>
        </form>
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
    <div class="return-button-container">
        <a href="../<?php echo $dashboard_url; ?>" class="return-button">Return to Main Menu</a>
    </div>
</div>

</body>
</html>
