<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';

    $zone = $_POST['zone'];
    $storage_number = $_POST['storage_number'];
    $level = $_POST['level'];

    // Construct the storage location without the indicator
    $storage_location = $zone . '-' . $storage_number . '-' . $level;

    error_log("Searching for storage_location: " . $storage_location);

    // Modify the query to use LIKE for partial matching
    $stmt = $conn->prepare("SELECT storage_location FROM warehouse WHERE storage_location LIKE ?");
    if ($stmt) {
        $search_pattern = $storage_location . '%';
        $stmt->bind_param("s", $search_pattern);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $full_storage_location = $row['storage_location'];

            // Extract parts from the full storage location
            $parts = explode('-', $full_storage_location);
            if (count($parts) >= 3) {
                $zone = $parts[0];
                $storage_number = $parts[1];
                $level = $parts[2];
                $indicator = isset($parts[3]) ? $parts[3] : '';

                error_log("Found storage_location: " . $full_storage_location);

                echo json_encode([
                    'success' => true,
                    'storage_location' => $full_storage_location,
                    'storage_number' => $storage_number,
                    'new_level' => $level,
                    'new_indicator' => $indicator
                ]);
            } else {
                error_log("Invalid format for storage_location: " . $full_storage_location);
                echo json_encode(['success' => false, 'message' => 'Invalid format for storage location.']);
            }
        } else {
            error_log("No bin found for storage_location: " . $storage_location);
            echo json_encode(['success' => false, 'message' => 'No bin found.']);
        }

        $stmt->close();
    } else {
        error_log("Query preparation failed.");
        echo json_encode(['success' => false, 'message' => 'Query preparation failed.']);
    }

    $conn->close();
} else {
    header("Location: ../index.php");
}
?>