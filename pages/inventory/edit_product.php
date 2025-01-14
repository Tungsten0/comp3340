<?php include '../../components/head.php';
if (isset($_COOKIE['role']) && $_COOKIE['role'] !== 'staff') {
} else {
    header('Location: ../../index.php');
    exit();
}
?>
    <title>Inventory Management</title>
    <link rel="stylesheet" href="../../css/inventory.css">
</head>

<body>
    <header>
        <h1>Inventory Management</h1>
    </header>
    <div class="container">
        <div class="button-container">
            <button class="main-button" onclick="showForm('add')">Add Product</button>
            <button class="main-button" onclick="showForm('edit')">Edit Product</button>
            <button class="main-button" onclick="showForm('remove')">Remove Product</button>
            <button class="main-button" onclick="showProducts()">Display All Products</button>
        </div>

        <!-- Add Product Form -->
        <div id="add-product-form" class="form-container">
            <button class="close-btn" onclick="closeForm()">x</button>
            <legend>
                <h2>Adding Product:</h2>
            </legend>
            <label for="add-product-number">Product Number:</label>
            <input type="text" id="add-product-number" required>
            <label for="add-product-name">Product Name:</label>
            <input type="text" id="add-product-name" required>
            <label for="add-quantity">Storage Quantity:</label>
            <input type="number" id="add-quantity" required>
            <label for="add-price">Price:</label>
            <input type="number" id="add-price" step="0.1" required>
            <label for="add-storage">Storage Indicator:</label>
            <input type="text" id="add-storage" required>
            <button type="submit" onclick="addProduct()">Add Product</button>
        </div>

        <!-- Edit Product Form -->
        <div id="edit-product-form" class="form-container">
            <button class="close-btn" onclick="closeForm()">x</button>
            <legend>
                <h2>Edit Product:</h2>
            </legend>
            <label for="edit-product-number">Product Number:</label>
            <input type="text" id="edit-product-number" required>
            <button type="button" onclick="fetchProductDetails()">Fetch Details</button>
            <div id="edit-details">
                <label for="edit-new-name">New Product Name:</label>
                <input type="text" id="edit-new-name">
                <label for="edit-quantity">New Quantity:</label>
                <input type="number" id="edit-quantity">
                <label for="edit-price">New Price:</label>
                <input type="number" id="edit-price" step="0.1">
                <label for="edit-storage">New Storage Indicator:</label>
                <input type="text" id="edit-storage">
                <button type="submit" onclick="editProduct()">Edit Product</button>
            </div>
            <div id="edit-loading" style="display: none;">Loading...</div>
        </div>

        <!-- Remove Product Form -->
        <div id="remove-product-form" class="form-container">
            <button class="close-btn" onclick="closeForm()">x</button>
            <legend>
                <h2>Remove Product:</h2>
            </legend>
            <label for="remove-product-number">Product Number:</label>
            <input type="text" id="remove-product-number" required>
            <button type="button" onclick="fetchProductToRemove()">Fetch Product</button>
            <div id="remove-details">
                <p id="remove-product-info"></p>
                <button type="submit" id="removeProductButton" onclick="removeProduct()">Remove Product</button>
            </div>
            <div id="remove-loading" style="display: none;">Loading...</div>
        </div>

        <!-- Display All Products -->
        <div id="productList" class="form-container">
            <button class="close-btn" id="closeProductListBtn">x</button>
            <table>
                <thead>
                    <tr>
                        <th>Product Number</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Storage</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    <!-- Products will be dynamically inserted here -->
                </tbody>
            </table>
        </div>
    </div>

    <?php include '../../components/return_dashboard.php'; ?>

    <script>
        function showForm(formType) {
            document.getElementById('add-product-form').style.display = 'none';
            document.getElementById('edit-product-form').style.display = 'none';
            document.getElementById('remove-product-form').style.display = 'none';

            if (formType === 'add') {
                document.getElementById('add-product-form').style.display = 'block';
            } else if (formType === 'edit') {
                document.getElementById('edit-product-form').style.display = 'block';
                document.getElementById('edit-details').style.display = 'none';
            } else if (formType === 'remove') {
                document.getElementById('remove-product-form').style.display = 'block';
                document.getElementById('remove-details').style.display = 'none';
            }
        }

        function closeForm() {
            document.getElementById('add-product-form').style.display = 'none';
            document.getElementById('edit-product-form').style.display = 'none';
            document.getElementById('remove-product-form').style.display = 'none';
            document.getElementById('productList').style.display = 'none'; // Hide product list when closing any form
        }

        function fetchProductDetails() {
            const productNumber = document.getElementById('edit-product-number').value.toLowerCase();
            const product = mockProducts[productNumber];
            const editDetails = document.getElementById('edit-details');
            const editLoading = document.getElementById('edit-loading');

            if (product) {
                editLoading.style.display = 'none';
                editDetails.style.display = 'block';
                document.getElementById('edit-new-name').value = product.name;
                document.getElementById('edit-quantity').value = product.quantity;
                document.getElementById('edit-price').value = product.price;
                document.getElementById('edit-storage').value = product.storage;
            } else {
                editLoading.style.display = 'none';
                editDetails.style.display = 'none';
                alert('Product not found!');
            }
        }

        function fetchProductToRemove() {
            const productNumber = document.getElementById('remove-product-number').value.toLowerCase();
            const product = mockProducts[productNumber];
            const removeDetails = document.getElementById('remove-details');
            const removeLoading = document.getElementById('remove-loading');
            const removeProductInfo = document.getElementById('remove-product-info');

            if (product) {
                removeLoading.style.display = 'none';
                removeDetails.style.display = 'block';
                removeProductInfo.innerHTML = `
                Name: ${product.name}<br>
                Quantity: ${product.quantity}<br>
                Price: $${product.price}<br>
                Storage: ${product.storage}
            `;
            } else {
                removeLoading.style.display = 'none';
                removeDetails.style.display = 'none';
                alert('Product not found!');
            }
        }

        function removeProduct() {
            const productNumber = document.getElementById('remove-product-number').value.toLowerCase();
            if (mockProducts[productNumber]) {
                delete mockProducts[productNumber];
                alert('Product removed successfully!');
                document.getElementById('remove-product-number').value = '';
                document.getElementById('remove-details').style.display = 'none';
            } else {
                alert('Product not found!');
            }
        }

        function showProducts() {
            const productList = document.getElementById('productList');
            productList.style.display = 'block';

            const tableBody = document.getElementById('productTableBody');
            tableBody.innerHTML = ''; // Clear previous content

            for (const [key, product] of Object.entries(mockProducts)) {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${key}</td>
                <td>${product.name}</td>
                <td>${product.quantity}</td>
                <td>$${product.price}</td>
                <td>${product.storage}</td>
            `;
                tableBody.appendChild(row);
            }

            document.getElementById('closeProductListBtn').addEventListener('click', function () {
                productList.style.display = 'none';
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const returnBtn = document.getElementById('returnBtn');
            returnBtn.addEventListener('click', function () {
                window.location.href = 'material_handler_dashboard.html';
            });
        });
    </script>
</body>

</html>