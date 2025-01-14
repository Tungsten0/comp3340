<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';

    $data = json_decode(file_get_contents('php://input'), true);
    $barcode = $data['barcode'];

    try {
        $conn->begin_transaction();

        // Check if the product is available in the given location
        $sql = "SELECT * FROM inventory WHERE storage_location = ? AND available = 0";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $barcode);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update the product's availability
            $sql = "UPDATE inventory SET available = 1 WHERE storage_location = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $barcode);
            $stmt->execute();

            $conn->commit();
            echo json_encode(['success' => 'Location confirmed successfully.']);
        } else {
            echo json_encode(['error' => 'No product found or product already confirmed for the given barcode.']);
        }

        $stmt->close();
    } catch (Exception $e) {
        $conn->rollback();
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }

    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>
