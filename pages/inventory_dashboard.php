<?php include '../components/head.php';
if (isset($_COOKIE['role']) && $_COOKIE['role'] === 'inventory') {
} else {
    header('Location: ../index.php');
    exit();
}?>
    <title>Material Handler Dashboard</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include '../components/inventory_header.php'; ?>

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

<?php include '../components/footer.php'; ?>

</body>
</html>
