<?php

//temporarily display errors
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';

    $zone = $_POST['zone'];
    $storage_number = $_POST['storage_number'];
    $level = $_POST['level'];

    // Construct the pattern for storage_location
    $storage_location_pattern = $zone . '-' . $storage_number . '-' . $level . '-%';

    // Prepare and execute the query
    $stmt = $conn->prepare("DELETE FROM warehouse WHERE storage_location LIKE ?");
    $stmt->bind_param("s", $storage_location_pattern);

    if ($stmt->execute()) {
        header("Location: ../pages/admin/warehouse.php#bin-removed");
    } else {
        header("Location: ../pages/admin/warehouse.php#bin-remove-error");
    }

    $stmt->close();
    $conn->close();

} else {
    header("Location: ../index.php");
}