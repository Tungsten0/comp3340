<?php include '../components/head.php'; ?>

    <title>Create Purchase Order</title>
    <link rel="stylesheet" href="../css/create_PO.css">
</head>
<body>
<header>
    <h1>Create Purchase Order</h1>
</header>
<div class="container">
    <div class="company-name-container">
        <label for="company-name">Company Name:</label>
        <input type="text" id="company-name" name="company-name" required>
    </div>

    <table id="po-table">
        <thead>
        <tr>
            <th>Product Number</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Remove</th>
        </tr>
        </thead>
        <tbody>
        <!-- Row template for up to 15 items -->
        <tr>
            <td><input type="text" name="product-number[]" class="product-number" required></td>
            <td><input type="text" name="product-name[]" readonly></td>
            <td><input type="number" name="quantity[]" required></td>
            <td><input type="text" name="price[]" readonly></td>
            <td><button type="button" class="remove-btn">Remove</button></td>
        </tr>
        </tbody>
    </table>

    <div class="btn-container">
        <button type="button" class="btn" onclick="addRow()">Add Item</button>
        <button type="submit" class="btn">Order</button>
    </div>
</div>

<div class="btn-container">
    <a href="admin_dashboard.html" class="return-btn">Return to Main Menu</a>
</div>

<script>
    const maxRows = 15;
    const mockProductData = {
        '001': { name: 'Widget', price: '19.99' },
        '002': { name: 'Gadget', price: '29.99' }
        // Add more mock data here
    };

    function addRow() {
        const tableBody = document.querySelector('#po-table tbody');
        const rowCount = tableBody.rows.length;

        if (rowCount < maxRows) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><input type="text" name="product-number[]" class="product-number" required></td>
                <td><input type="text" name="product-name[]" readonly></td>
                <td><input type="number" name="quantity[]" required></td>
                <td><input type="text" name="price[]" readonly></td>
                <td><button type="button" class="remove-btn">Remove</button></td>
            `;
            tableBody.appendChild(row);

            // Add event listener to the new remove button
            row.querySelector('.remove-btn').addEventListener('click', function() {
                row.remove();
            });

            // Add event listener to the new product number input
            row.querySelector('.product-number').addEventListener('change', function() {
                fetchProductData(this.value, (data) => {
                    this.closest('tr').querySelector('input[name="product-name[]"]').value = data.name;
                    this.closest('tr').querySelector('input[name="price[]"]').value = data.price;
                });
            });
        } else {
            alert('Maximum of 15 items allowed.');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initial setup for remove buttons
        document.querySelectorAll('.remove-btn').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('tr').remove();
            });
        });

        // Initial setup for product number inputs
        document.querySelectorAll('.product-number').forEach(input => {
            input.addEventListener('change', function() {
                fetchProductData(this.value, (data) => {
                    this.closest('tr').querySelector('input[name="product-name[]"]').value = data.name;
                    this.closest('tr').querySelector('input[name="price[]"]').value = data.price;
                });
            });
        });
    });

    function fetchProductData(productNumber, callback) {
        // Mock data fetch
        const data = mockProductData[productNumber] || { name: '', price: '' };
        callback(data);
    }
</script>
</body>
</html>
