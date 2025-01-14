<header>
    <h1>Welcome Material Handler</h1>
    <nav class="navigation">
        <div class="dropdown">
            <a href="">Inventory</a>
            <div class="dropdown-content">
                <a href="../pages/inventory/add_inventory.php">Add to Inventory</a>
                <a href="../pages/inventory/putaway_materials.php">Put Away Inventory</a>
                <a href="../pages/inventory/search_inventory.php">Search Inventory</a>
                <a href="../pages/inventory/delete_inventory.php">Delete Inventory</a>
            </div>
        </div>
        <a href="../pages/inventory/picking_queue.php">Order Queue</a>
    </nav>
    <form action="../php/logout.php" method="POST">
        <button id="logoutBtn" class="return-button" type="submit">Logout</button>
    </form>
</header>