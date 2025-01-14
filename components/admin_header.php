<header>
    <h1>Welcome Admin</h1>
    <nav class="navigation">
        <div class="dropdown">
            <a href="#">User Functions</a>
            <div class="dropdown-content">
                <a href="../pages/staff/order_materials.php">Order Material</a>
                <a href="../pages/staff/view_orderqueue.php">View Order Queue</a>
            </div>
        </div>
        <div class="dropdown">
            <a href="#">Inventory</a>
            <div class="dropdown-content">
                <a href="../pages/inventory/add_inventory.php">Manually Add</a>
                <a href="../pages/inventory/search_inventory.php">Check Inventory</a>
                <a href="../pages/inventory/delete_inventory.php">Delete Inventory</a>
            </div>
        </div>
        <div class="dropdown">
            <a href="#">Manage</a>
            <div class="dropdown-content">
                <a href="../pages/admin/user_control.php">Users</a>
                <a href="../pages/admin/products.php">Products</a>
                <a href="../pages/admin/warehouse.php">Warehouse</a>
            </div>
        </div>
<!--        <div class="dropdown">-->
<!--            <a href="#">Purchasing Orders</a>-->
<!--            <div class="dropdown-content">-->
<!--                <a href="Create_PO.html">Create</a>-->
<!--                <a href="View_PO.html">View</a>-->
<!--            </div>-->
<!--        </div>-->
    </nav>
    <form action="../php/logout.php" method="POST">
        <button id="logoutBtn" class="return-button" type="submit">Logout</button>
    </form>
</header>