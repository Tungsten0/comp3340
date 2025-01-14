<?php
header('Content-Type: application/json');
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
if (isset($_GET['product_id'])) {
    include '../config/db_connection.php';

    $product_id = $_GET['product_id'];

    try {
        // Check database connection
        if ($conn->connect_error) {
            throw new Exception('Database connection failed: ' . $conn->connect_error);
        }

        // Fetch the next available storage location for the given product
        $sql = "SELECT storage_location FROM inventory WHERE product_id = ? AND available = 1 LIMIT 1";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            throw new Exception('SQL prepare statement failed: ' . $conn->error);
        }

        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === false) {
            throw new Exception('SQL execution failed: ' . $stmt->error);
        }

        if ($result->num_rows === 0) {
            throw new Exception('No available storage location found for this product.');
        }

        $row = $result->fetch_assoc();
        echo json_encode(['storage_location' => $row['storage_location']]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid product ID']);
}
?>
