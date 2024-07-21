<!-- db_connection.php -->
<?php
$servername = "";
$username = "u144000044_admin";
$password = "dZ4XmOZ2a";
$dbname = "u144000044_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
