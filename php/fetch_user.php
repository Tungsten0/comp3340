<?php
include '../config/db_connection.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = $_GET['username'];
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

header('Content-Type: application/json');

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode([
        'success' => true,
        'username' => $user['username'],
        'email' => $user['email'],
        'role' => $user['role'],
        'first_name' => $user['first_name'],
        'last_name' => $user['last_name'],
        'password' => $user['password'] // This is sensitive data
    ]);
} else {
    echo json_encode(['error' => 'User not found']);
}

$conn->close();
?>
