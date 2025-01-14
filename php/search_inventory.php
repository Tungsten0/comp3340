<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';

    $data = json_decode(file_get_contents('php://input'), true);

    $productNumber = $data['productNumber'] ?? null;
    $storageLocation = $data['storageLocation'] ?? null;

    $response = [];
    try {
        if ($productNumber) {
            // Fetch the product ID and total quantity from products table
            $sql = "SELECT product_id, quantity FROM products WHERE product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $productNumber);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $product = $result->fetch_assoc();
                $productID = $product['product_id'];
                $totalQuantity = $product['quantity'];

                // Fetch inventory data for the product
                $sql = "SELECT inventory.storage_location, warehouse.availability FROM inventory
                        JOIN warehouse ON inventory.storage_location = warehouse.storage_location
                        WHERE inventory.product_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $productID);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    list($zone, $storageNumber, $storageLevel) = explode('-', $row['storage_location']);
                    $response[] = [
                        'product_id' => $productID,
                        'zone' => $zone,
                        'storage_number' => $storageNumber,
                        'storage_level' => $storageLevel,
                        'quantity' => $totalQuantity,
                        'barcode' => $row['storage_location']
                    ];
                }

                echo json_encode($response);
            } else {
                echo json_encode([]);
            }
        } elseif ($storageLocation) {
            // Fetch inventory data by storage location
            $sql = "SELECT inventory.product_id, inventory.storage_location, products.quantity 
                    FROM inventory 
                    JOIN products ON inventory.product_id = products.product_id
                    WHERE inventory.storage_location = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $storageLocation);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                list($zone, $storageNumber, $storageLevel) = explode('-', $row['storage_location']);
                $response[] = [
                    'product_id' => $row['product_id'],
                    'zone' => $zone,
                    'storage_number' => $storageNumber,
                    'storage_level' => $storageLevel,
                    'quantity' => $row['quantity'],
                    'barcode' => $row['storage_location']
                ];
            }

            echo json_encode($response);
        } else {
            echo json_encode([]);
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
