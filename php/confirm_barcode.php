<?php
header('Content-Type: application/json');
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';

    $data = json_decode(file_get_contents('php://input'), true);
    $barcode = $data['barcode'];
    $product_id = $data['product_id'];

    try {
        // Confirm the barcode matches the product ID
        $sql = "SELECT COUNT(*) AS count FROM inventory WHERE product_id = ? AND storage_location = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $product_id, $barcode);
        if ($stmt === false) {
            throw new Exception('SQL prepare statement failed: ' . $conn->error);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row['count'] != 1) {
            throw new Exception('Barcode does not match the product ID.');
        }

        if ($row['count'] == 1) {
            echo json_encode(['success' => true]);
        } else {
            throw new Exception('Barcode does not match the product ID.');
        }
    } catch (Exception $e) {
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
