<?php
include '../config/db_connection.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents('php://input'), true);

$username = $data['username'];
$email = $data['email'];
$role = $data['role'];
$first_name = $data['first_name'];
$last_name = $data['last_name'];
$new_password = isset($data['password']) ? $data['password'] : null;
$allowedRoles = ['staff', 'inventory', 'admin'];
if (!in_array($data['role'], $allowedRoles)) {
    echo json_encode(['error' => 'Invalid role']);
    exit;
}
if ($new_password) {
    $password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET email = ?, role = ?, first_name = ?, last_name = ?, password = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $email, $role, $first_name, $last_name, $password_hashed, $username);
} else {
    $sql = "UPDATE users SET email = ?, role = ?, first_name = ?, last_name = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $email, $role, $first_name, $last_name, $username);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Failed to edit user']);
}

$conn->close();
?>
