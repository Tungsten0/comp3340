<?php
//temporarily display errors
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';

    $productNumber = $_POST['productNumber'];
    $location = $_POST['location'];
    $requester = $_COOKIE['username'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO orders (product_id, delivery_location, requester) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $productNumber, $location, $requester);

    // Execute the statement
    if ($stmt->execute()) {
        header("Location: ../pages/staff/order_materials.php#order-submitted");
    } else {
        header("Location: ../pages/staff/order_materials.php#order-submit-error");
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

}