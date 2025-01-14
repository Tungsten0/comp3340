<?php

$host = 'localhost';
$user = 'leeshi_admin';
$password = 'RezPa6vkpJcbYExhNVyj';
$database = 'leeshi_comp3340';
// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Admin user details
$adminUsername = 'admin';
$adminPassword = password_hash('adminpassword', PASSWORD_BCRYPT); // Hash the password
$adminEmail = 'admin@example.com';
$adminFirstName = 'Admin';
$adminLastName = 'User';
$adminRole = 'admin';

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (username, password, email, first_name, last_name, role) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $adminUsername, $adminPassword, $adminEmail, $adminFirstName, $adminLastName, $adminRole);

// Execute the query
if ($stmt->execute()) {
    echo "Admin user created successfully.\n";
} else {
    echo "Error creating admin user: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>
