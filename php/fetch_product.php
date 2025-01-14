<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['number'])) {
    include '../config/db_connection.php';

    $number = $_GET['number'];

    $sql = "SELECT product_name AS name, quantity, price FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $number);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            echo json_encode($product);
        } else {
            echo json_encode(null);
        }
    } else {
        echo json_encode(['error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}