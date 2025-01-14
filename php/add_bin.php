<?php
//temporarily display errors
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';

    $zone = $_POST['zone'];
    $storage_number = $_POST['storage_number'];
    $storage_level = $_POST['storage_level'];

    echo $zone . $storage_number . $storage_level;

    // Combine to create storage location
    $storage_location = $zone . '-' . $storage_number . '-' . $storage_level;

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO warehouse (storage_location) VALUES (?)");
    $stmt->bind_param("s", $storage_location);

    // Execute the statement
    if ($stmt->execute()) {
        header("Location: ../pages/admin/warehouse.php#bin-added");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

} else {
    header("Location: ../index.php");
}