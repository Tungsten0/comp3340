<?php include '../components/header.php'; ?>
    <title>Material Handler Dashboard</title>
</head>
<body>
<header>
    <h1>Welcome Material Handler</h1>
    <nav class="navigation">
        <div class="dropdown">
            <a href="#">Inventory</a>
            <div class="dropdown-content">
                <a href="Manual_Add_Materials.html">Manually Add</a>
                <a href="Receive_PO.html">Add by PO</a>
                <a href="Put_Away_Materials.html">Put Away Inventory</a>
                <a href="Check_Inventory.html">Search Inventory</a>
                <a href="Edit_Inventory.html">Search Inventory</a>
            </div>
        </div>
        <a href="picking_queue.html">Order Queue</a>
        <a href="Profile_Edit.html">Profile</a>
    </nav>
    <button id="logoutBtn" onclick="logout()">Logout</button>
</header>

<main>
    <div class="wrapper">
        <span class="icon-close">
            <ion-icon name="close-outline"></ion-icon>
        </span>
        <div class="form-box">
            <h2>Order Material</h2>
            <form action="#">
                <div class="input-box">
                    <span class="icon"><ion-icon name="clipboard-outline"></ion-icon></span>
                    <input type="text" required>
                    <label>Material Name</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="cube-outline"></ion-icon></span>
                    <input type="number" required>
                    <label>Quantity</label>
                </div>
                <button type="submit" class="btn">Order</button>
            </form>
        </div>
    </div>
</main>

<footer>
    <p>&copy; 2024 Your Company</p>
</footer>

<script>
    function logout() {
        window.location.href = 'index.html';
    }
</script>

</body>
</html>
