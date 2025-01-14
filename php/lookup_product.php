<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';

    $data = json_decode(file_get_contents('php://input'), true);
    $barcode = $data['barcode'];

    try {
        // Look up the product by storage location
        $sql = "SELECT products.product_id, products.quantity, inventory.storage_location 
                FROM inventory 
                JOIN products ON inventory.product_id = products.product_id 
                WHERE inventory.storage_location = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $barcode);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            echo json_encode([
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'current_location' => $product['storage_location']
            ]);
        } else {
            echo json_encode(['error' => 'No product found for the given barcode.']);
        }

        $stmt->close();
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }

    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>
