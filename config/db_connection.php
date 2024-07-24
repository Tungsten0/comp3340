<!-- db_connection.php -->
<?php
$servername = "127.0.0.1";
$username = "u144000044_admin";
$password = "dZ4XmOZ2a;";
$dbname = "u144000044_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
    die("Connection failed: " . $conn->connect_error);
}
?>
