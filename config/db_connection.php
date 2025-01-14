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
?>
