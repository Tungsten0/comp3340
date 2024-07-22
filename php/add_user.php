<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $permission = $_POST['permissions'];

    $fname = mysqli_real_escape_string($conn, $fname);
    $lname = mysqli_real_escape_string($conn, $lname);
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

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

