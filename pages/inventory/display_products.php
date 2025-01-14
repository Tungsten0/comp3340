<?php include '../../components/head.php';
if (isset($_COOKIE['role']) && $_COOKIE['role'] !== 'staff') {
} else {
    header('Location: ../../index.php');
    exit();
}
?>
    <title>Product Inventory</title>
    <link rel="stylesheet" href="../../css/products.css">
</head>
<body>
<header>
    <h1>Product Inventory</h1>
</header>
<div class="container">
    <h2>Product Inventory:</h2>
    <table>
        <thead>
        <tr>
            <th>Product Number</th>
            <th>Product Name</th>
            <th>Storage Quantity</th>
            <th>Storage Indicator</th>
            <th>Price</th>
        </tr>
        </thead>
        <tbody id="productTableBody">
        <!-- Product data will be dynamically added here -->
        </tbody>
    </table>
    <!-- Return Button -->
    <?php include '../../components/return_dashboard.php'; ?>
</div>

<script>
    // Sample data to simulate the output from the server
    const sampleData = [
        {
            productNumber: 101,
            productName: 'Product A',
            storageQuantity: 50,
            storageIndicator: 'A',
            price: 29.99
        },
        {
            productNumber: 102,
            productName: 'Product B',
            storageQuantity: 20,
            storageIndicator: 'B',
            price: 49.99
        },
        {
            productNumber: 103,
            productName: 'Product C',
            storageQuantity: 75,
            storageIndicator: 'A',
            price: 15.49
        }
    ];

    const productTableBody = document.getElementById('productTableBody');

    // Sort data by product number
    sampleData.sort((a, b) => a.productNumber - b.productNumber);

    sampleData.forEach(product => {
        const row = document.createElement('tr');
        row.innerHTML = `
                <td>${product.productNumber}</td>
                <td>${product.productName}</td>
                <td>${product.storageQuantity}</td>
                <td>${product.storageIndicator}</td>
                <td>${product.price.toFixed(2)}</td>
            `;

        productTableBody.appendChild(row);
    });
</script>
</body>
</html>
