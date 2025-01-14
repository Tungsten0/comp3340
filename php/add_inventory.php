<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';

    $data = json_decode(file_get_contents('php://input'), true);

    $productNumber = $data['productNumber'];
    $quantity = $data['quantity'];

    $response = [];
    $conn->begin_transaction();

    try {
        for ($i = 0; $i < $quantity; $i++) {
            // Find an available storage location
            $sql = "SELECT storage_location FROM warehouse WHERE availability = 'free' LIMIT 1 FOR UPDATE";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $storageLocation = $row['storage_location'];

                // Insert into inventory
                $sql = "INSERT INTO inventory (product_id, storage_location, available) VALUES (?, ?, 0)";
                $stmt = $conn->prepare($sql);
                if ($stmt === false) {
                    throw new Exception('Prepare failed: ' . htmlspecialchars($conn->error));
                }
                $stmt->bind_param("is", $productNumber, $storageLocation);
                if (!$stmt->execute()) {
                    throw new Exception('Execute failed: ' . htmlspecialchars($stmt->error));
                }

                // Update warehouse availability
                $sql = "UPDATE warehouse SET availability = 'filled' WHERE storage_location = ?";
                $stmt = $conn->prepare($sql);
                if ($stmt === false) {
                    throw new Exception('Prepare failed: ' . htmlspecialchars($conn->error));
                }
                $stmt->bind_param("s", $storageLocation);
                if (!$stmt->execute()) {
                    throw new Exception('Execute failed: ' . htmlspecialchars($stmt->error));
                }

                // Append to response
                $response[] = [
                    'productNumber' => $productNumber,
                    'barcode' => $storageLocation,
                    'location' => $storageLocation
                ];
            } else {
                throw new Exception('No available storage location found.');
            }
        }

        $conn->commit();
        echo json_encode($response);
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