<?php include '../components/head.php'; ?>
  <title>Picking Queue</title>
  <link rel="stylesheet" href="../css/picking_queue.css">

  <script>
    let queue = [];
    let currentIndex = 0;

    async function fetchQueue() {
      try {
        const response = await fetch('/api/picking-queue');
        if (!response.ok) throw new Error('Network response was not ok');

        const data = await response.json();
        queue = data.queue;
        if (queue.length === 0) {
          showError('There are no orders currently.');
        } else {
          displayCurrentItem();
        }
      } catch (error) {
        showError('An error occurred while fetching the queue.');
        console.error('Error:', error);
      }
    }

    function displayCurrentItem() {
      if (queue.length === 0 || currentIndex >= queue.length) {
        showError('No more items in the queue.');
        return;
      }

      const item = queue[currentIndex];
      document.getElementById('product-number').textContent = item.productNumber;
      document.getElementById('quantity-requested').textContent = item.quantityRequested;
      document.getElementById('storage-location').textContent = `${item.zone}-${item.number}-${item.level}`;
      document.getElementById('barcode').value = '';
      document.getElementById('delivery-location').value = '';
      document.getElementById('current-position').textContent = `${currentIndex + 1}/${queue.length}`;
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
        const response = await fetch('/api/confirm-barcode', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ barcode, productNumber: queue[currentIndex].productNumber })
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
        console.error('Error:', error);
      }
    }

    async function handleDeliveryConfirmation() {
      const deliveryLocation = document.getElementById('delivery-location').value;

      if (!deliveryLocation) {
        showError('Please enter a delivery location.');
        return;
      }

      try {
        const response = await fetch('/api/confirm-delivery', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ productNumber: queue[currentIndex].productNumber, deliveryLocation })
        });

        if (!response.ok) throw new Error('Network response was not ok');

        const data = await response.json();

        if (data.success) {
          currentIndex++;
          displayCurrentItem();
        } else {
          showError(data.error || 'An error occurred.');
        }
      } catch (error) {
        showError('An error occurred while confirming the delivery location.');
        console.error('Error:', error);
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
  <div class="status-bar" id="current-position">1/0</div>
  <!-- Error message area -->
  <div id="error-message" class="error-message hidden"></div>
  <div id="confirm-section">
    <h2>Product Details</h2>
    <div class="table-wrapper">
      <div class="table-blur"></div> <!-- Blur effect container -->
      <table>
        <thead>
        <tr>
          <th>Product Number</th>
          <th>Quantity Requested</th>
          <th>Storage Location</th>
          <th>Barcode</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td id="product-number"></td>
          <td id="quantity-requested"></td>
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
    </div>
  </div>
  <div id="delivery-section" class="hidden">
    <h2>Delivery Details</h2>
    <form onsubmit="handleDeliveryConfirmation()">
      <div class="form-group">
        <label for="delivery-location">Delivery Location:</label>
        <input type="text" id="delivery-location" name="delivery-location" placeholder="Enter delivery location" required>
      </div>
      <div class="button-group">
        <button type="submit">Confirm to Delivery Location</button>
      </div>
    </form>
  </div>
  <!-- Return Button -->
  <div class="return-button-container">
    <a href="material_handler_dashboard.html" class="return-button">Return to Main Menu</a>
  </div>
</div>
</body>
</html>
