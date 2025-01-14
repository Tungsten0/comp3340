<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';

    $data = json_decode(file_get_contents('php://input'), true);
    $number = $data['number'];

    $sql = "DELETE FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $number);

    if ($stmt->execute()) {
        header("Location: ../pages/admin/products.php#product-removed");
    } else {
        header("Location: ../pages/admin/products.php#product-remove-error");
    }

    $stmt->close();
    $conn->close();
}
?>
