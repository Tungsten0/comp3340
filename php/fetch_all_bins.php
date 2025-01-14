<?php

// Temporarily display errors (uncomment for debugging)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include '../config/db_connection.php';

    // Query to fetch all warehouse records, including availability
    $sql = "SELECT storage_location, availability FROM warehouse";
    $result = $conn->query($sql);

    $warehouses = [];

    if ($result->num_rows > 0) {
        // Fetch all records and store in array
        while($row = $result->fetch_assoc()) {
            $warehouses[] = $row;
        }
    }

    // Return the warehouse data as JSON
    header('Content-Type: application/json');
    echo json_encode($warehouses);

    $conn->close();

} else {
    header("Location: ../index.php");
}
