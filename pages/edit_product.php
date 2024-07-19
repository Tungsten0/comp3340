<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $sql = "UPDATE products SET name=?, quantity=?, price=?, description=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sidsi", $name, $quantity, $price, $description, $product_id);

    if ($stmt->execute()) {
        echo "Product updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
