<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';

    $data = json_decode(file_get_contents('php://input'), true);

    $number = $data['number'];
    $name = $data['name'];
    $quantity = $data['quantity'];
    $price = $data['price'];

    $sql = "UPDATE products SET product_name = ?, quantity = ?, price = ? WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sids", $name, $quantity, $price, $number);

    if ($stmt->execute()) {
        header("Location: ../pages/admin/products.php#product-updated");
    } else {
        header("Location: ../pages/admin/products.php#product-update-error");
    }

    $stmt->close();
    $conn->close();
}
?>
