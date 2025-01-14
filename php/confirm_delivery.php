<?php
header('Content-Type: application/json');

// Uncomment these lines for error reporting during development
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';

    $data = json_decode(file_get_contents('php://input'), true);
    $product_id = $data['product_id'];
    $delivery_location = $data['delivery_location'];

    // Prepare response
    $response = ['success' => false, 'error' => 'Unknown error'];

    try {
        if ($conn->connect_error) {
            throw new Exception('Database connection failed: ' . $conn->connect_error);
        }

        $conn->begin_transaction();

        // Update orders
        $sql = "UPDATE orders SET fulfilled = 1 WHERE product_id = ? AND delivery_location = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception('SQL prepare statement failed for orders update: ' . $conn->error);
        }

        // Log SQL query and parameters
        $response['queries'][] = [
            'type' => 'UPDATE orders',
            'sql' => $sql,
            'parameters' => ['product_id' => $product_id, 'delivery_location' => $delivery_location]
        ];

        $stmt->bind_param("is", $product_id, $delivery_location);
        $stmt->execute();

        // Log the number of affected rows
        $affected_rows = $stmt->affected_rows;
        $response['affected_rows']['orders_update'] = $affected_rows;

        if ($affected_rows === 0) {
            throw new Exception('No rows were updated in orders.');
        }

        // Fetch correct storage_location for the product
        $sql = "SELECT storage_location FROM inventory WHERE product_id = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception('SQL prepare statement failed for inventory select: ' . $conn->error);
        }

        // Log SQL query and parameters
        $response['queries'][] = [
            'type' => 'SELECT inventory',
            'sql' => $sql,
            'parameters' => ['product_id' => $product_id]
        ];

        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!$row) {
            throw new Exception('No storage location found for product.');
        }

        $storage_location = $row['storage_location'];

        // Log the retrieved storage_location
        $response['storage_location'] = $storage_location;

        // Delete inventory
        $sql = "DELETE FROM inventory WHERE product_id = ? AND storage_location = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception('SQL prepare statement failed for inventory delete: ' . $conn->error);
        }

        // Log SQL query and parameters
        $response['queries'][] = [
            'type' => 'DELETE inventory',
            'sql' => $sql,
            'parameters' => ['product_id' => $product_id, 'storage_location' => $storage_location]
        ];

        $stmt->bind_param("is", $product_id, $storage_location);
        $stmt->execute();

        // Log the number of affected rows
        $affected_rows = $stmt->affected_rows;
        $response['affected_rows']['inventory_delete'] = $affected_rows;

        if ($affected_rows === 0) {
            throw new Exception('No rows were deleted from inventory.');
        }

        // Update warehouse
        $sql = "UPDATE warehouse SET availability = 'free' WHERE storage_location = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception('SQL prepare statement failed for warehouse update: ' . $conn->error);
        }

        // Log SQL query and parameters
        $response['queries'][] = [
            'type' => 'UPDATE warehouse',
            'sql' => $sql,
            'parameters' => ['storage_location' => $storage_location]
        ];

        $stmt->bind_param("s", $storage_location);
        $stmt->execute();

        // Log the number of affected rows
        $affected_rows = $stmt->affected_rows;
        $response['affected_rows']['warehouse_update'] = $affected_rows;

        $conn->commit();
        $response['success'] = true;

    } catch (Exception $e) {
        $conn->rollback();
        $response['error'] = $e->getMessage();
    }

    $stmt->close();
    $conn->close();

    echo json_encode($response);
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>
