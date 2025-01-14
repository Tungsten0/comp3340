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
    $new_level = $_POST['new_level'];
    $old_storage_location = $_POST['old_storage_location'];

    $new_storage_location = $zone . '-' . $storage_number . '-' . $new_level;

    $stmt = $conn->prepare("UPDATE warehouse SET storage_location = ? WHERE storage_location = ?");
    $stmt->bind_param("ss", $new_storage_location, $old_storage_location); // Update this line

    if ($stmt->execute()) {
        header("Location: ../pages/admin/warehouse.php#bin-edit");
    } else {
        header("Location: ../pages/admin/warehouse.php#bin-edit-error");
    }

    $stmt->close();
    $conn->close();

} else {
    header("Location: ../index.php");
}