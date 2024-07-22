<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';

    // Retrieve and sanitize POST data
    $fname = htmlspecialchars($_POST['fname'] ?? '', ENT_QUOTES, 'UTF-8');
    $lname = htmlspecialchars($_POST['lname'] ?? '', ENT_QUOTES, 'UTF-8');
    $username = htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES, 'UTF-8');
    $permission = htmlspecialchars($_POST['permissions'] ?? '', ENT_QUOTES, 'UTF-8');

    // Debugging: Output the values to verify they are correct
    echo "First Name: $fname<br>";
    echo "Last Name: $lname<br>";
    echo "Username: $username<br>";
    echo "Email: $email<br>";
    echo "Password: $password<br>";
    echo "Permissions: $permission<br>";

    $check_username = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $check_username->bind_param("s", $username);
    $check_username->execute();
    $check_username->store_result();

    if ($check_username->num_rows > 0) {
        echo "Username already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, first_name, last_name, role) VALUES (?, ?, ?, ?, ?, ?)");

        if ($stmt) {
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("ssssss", $username, $password_hashed, $email, $fname, $lname, $permission);

            if ($stmt->execute()) {
                echo "User added successfully.";
            } else {
                echo "User add failed: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Preparation failed: " . $conn->error;
        }
    }
    $check_username->close();
    $conn->close();
} else {
    echo "Form not submitted.";
}
?>
