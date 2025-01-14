<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';

    $data = json_decode(file_get_contents('php://input'), true);
    $storageLocation = $data['barcode'];

    try {
        $conn->begin_transaction();

        // Delete from inventory
        $sql = "DELETE FROM inventory WHERE storage_location = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $storageLocation);
        $stmt->execute();

        // Update warehouse availability
        $sql = "UPDATE warehouse SET availability = 'free' WHERE storage_location = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $storageLocation);
        $stmt->execute();

        $conn->commit();

        echo json_encode(['message' => 'Inventory item deleted successfully.']);

    } catch (Exception $e) {
        $conn->rollback();
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>
