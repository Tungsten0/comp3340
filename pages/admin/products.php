<?php include '../../components/head.php';
if (isset($_COOKIE['role']) && $_COOKIE['role'] === 'admin') {
} else {
    header('Location: ../../index.php');
    exit();
}
?>
    <link rel="stylesheet" href="../../css/product_dashboard.css">
    <link rel="stylesheet" href="../../css/style.css">

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
        <legend><h2>Adding Product:</h2></legend>
        <form action="../../php/add_product.php" method="POST">
            <label for="add-product-number">Product Number:</label>
            <input type="text" id="add-product-number" name="number" required>
            <label for="add-product-name">Product Name:</label>
            <input type="text" id="add-product-name" name="name" required>
            <label for="add-quantity">Storage Quantity:</label>
            <input type="number" id="add-quantity" name="quantity" required>
            <label for="add-price">Price:</label>
            <input type="number" id="add-price" step="0.1" name="price" required>
            <button type="submit" >Add Product</button>
        </form>
    </div>

    <!-- Edit Product Form -->
    <div id="edit-product-form" class="form-container">
        <button class="close-btn" onclick="closeForm()">x</button>
        <legend><h2>Edit Product:</h2></legend>
        <label for="edit-product-number">Product Number:</label>
        <input type="text" id="edit-product-number" required>
        <button type="button" onclick="fetchProductDetails()">Fetch Details</button>
        <div id="edit-details" style="display: none;">
            <label for="edit-new-name">New Product Name:</label>
            <input type="text" id="edit-new-name">
            <label for="edit-quantity">New Quantity:</label>
            <input type="number" id="edit-quantity">
            <label for="edit-price">New Price:</label>
            <input type="number" id="edit-price" step="0.1">
            <button type="button" onclick="editProduct()">Edit Product</button>
        </div>
        <div id="edit-loading" style="display: none;">Loading...</div>
    </div>

    <!-- Remove Product Form -->
    <div id="remove-product-form" class="form-container">
        <button class="close-btn" onclick="closeForm()">x</button>
        <legend><h2>Remove Product:</h2></legend>
        <label for="remove-product-number">Product Number:</label>
        <input type="text" id="remove-product-number" required>
        <button type="button" onclick="fetchProductToRemove()">Fetch Product</button>
        <div id="remove-details" style="display: none;">
            <p id="remove-product-info"></p>
            <button type="button" id="removeProductButton" onclick="removeProduct()">Remove Product</button>
        </div>
        <div id="remove-loading" style="display: none;">Loading...</div>
    </div>

    <!-- Display All Products -->
    <div id="productList" class="form-container" style="display: none;">
        <button class="close-btn" id="closeProductListBtn">x</button>
        <table>
            <thead>
            <tr>
                <th>Product Number</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            </thead>
            <tbody id="productTableBody">
            <!-- Products will be dynamically inserted here -->
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
        $dashboard_url = '../../pages/user_dashboard.php';
        break;
    default:
        $dashboard_url = '../../login.html';
        break;
}

?>

<div class="btn-container">
    <a href="../<?php echo $dashboard_url; ?>" class="return-button">Return to Main Menu</a>
</div>
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
        const editDetails = document.getElementById('edit-details');
        const editLoading = document.getElementById('edit-loading');

        editLoading.style.display = 'block';
        editDetails.style.display = 'none';

        fetch(`../../php/fetch_product.php?number=${productNumber}`)
            .then(response => response.json())
            .then(product => {
                if (product) {
                    editLoading.style.display = 'none';
                    editDetails.style.display = 'block';
                    document.getElementById('edit-new-name').value = product.name;
                    document.getElementById('edit-quantity').value = product.quantity;
                    document.getElementById('edit-price').value = product.price;
                } else {
                    editLoading.style.display = 'none';
                    alert('Product not found!');
                }
            })
            .catch(error => {
                editLoading.style.display = 'none';
                alert('Error fetching product details: ' + error.message);
            });
    }

    function editProduct() {
        const productNumber = document.getElementById('edit-product-number').value.toLowerCase();
        const newName = document.getElementById('edit-new-name').value;
        const newQuantity = document.getElementById('edit-quantity').value;
        const newPrice = document.getElementById('edit-price').value;

        fetch('../../php/edit_product.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                number: productNumber,
                name: newName,
                quantity: newQuantity,
                price: newPrice
            })
        })
            .then(response => response.text())
            .then(data => {
                alert("Product successfully updated!");
            })
            .catch(error => {
                alert('Error editing product: ' + error.message);
            });
    }


    function fetchProductToRemove() {
        const productNumber = document.getElementById('remove-product-number').value.toLowerCase();
        const removeDetails = document.getElementById('remove-details');
        const removeLoading = document.getElementById('remove-loading');
        const removeProductInfo = document.getElementById('remove-product-info');

        removeLoading.style.display = 'block';
        removeDetails.style.display = 'none';

        fetch(`../../php/fetch_product.php?number=${productNumber}`)
            .then(response => response.json())
            .then(product => {
                if (product) {
                    removeLoading.style.display = 'none';
                    removeDetails.style.display = 'block';
                    removeProductInfo.innerHTML = `
                    Name: ${product.name}<br>
                    Quantity: ${product.quantity}<br>
                    Price: $${product.price}
                `;
                } else {
                    removeLoading.style.display = 'none';
                    alert('Product not found!');
                }
            })
            .catch(error => {
                removeLoading.style.display = 'none';
                alert('Error fetching product details: ' + error.message);
            });
    }

    function removeProduct() {
        const productNumber = document.getElementById('remove-product-number').value.toLowerCase();

        fetch('../../php/delete_product.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ number: productNumber })
        })
            .then(response => response.text())
            .then(data => {
                alert("product successfully deleted!"); //data
                document.getElementById('remove-product-number').value = '';
                document.getElementById('remove-details').style.display = 'none';
            })
            .catch(error => {
                alert('Error deleting product: ' + error.message);
            });
    }


    function showProducts() {
        const productList = document.getElementById('productList');
        productList.style.display = 'block';

        const tableBody = document.getElementById('productTableBody');
        tableBody.innerHTML = ''; // Clear previous content

        fetch('../../php/get_products.php')
            .then(response => response.json())
            .then(products => {
                products.forEach(product => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                    <td>${product.product_id}</td>
                    <td>${product.product_name}</td>
                    <td>${product.quantity}</td>
                    <td>$${product.price}</td>
                `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => {
                alert('Error fetching product list: ' + error.message);
            });

        document.getElementById('closeProductListBtn').addEventListener('click', function() {
            productList.style.display = 'none';
        });
    }


    document.addEventListener('DOMContentLoaded', function() {
        const returnBtn = document.getElementById('returnBtn');
        returnBtn.addEventListener('click', function() {
            window.location.href = '../admin_dashboard.php';
        });
    });
</script>
</body>
</html>
