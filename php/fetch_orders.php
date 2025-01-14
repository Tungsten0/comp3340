<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
include '../config/db_connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch orders that are not fulfilled
$sql = "SELECT order_id, product_id, delivery_location, requester, fulfilled FROM orders WHERE fulfilled = FALSE";
$result = $conn->query($sql);

$orders = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $orders[] = array(
            "order_id" => $row["order_id"],
            "product_id" => $row["product_id"],
            "delivery_location" => $row["delivery_location"],
            "requester" => $row["requester"],
            "fulfilled" => (bool)$row["fulfilled"]
        );
    }
}

$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($orders);
?>
