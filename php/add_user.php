<?php

//temporarily display errors
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';

    //get form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $permission = $_POST['permissions'];

    //prevent sql injection
    $fname = mysqli_real_escape_string($conn, $fname);
    $lname = mysqli_real_escape_string($conn, $lname);
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $check_username = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $check_username->bind_param("s", $username);
    $check_username->execute();
    $check_username->store_result();

    //check if username already exists
    if ($check_username->num_rows > 0) {
        echo "Username already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, first_name, last_name, role) VALUES (?, ?, ?, ?, ?, ?)");

        if ($stmt) {
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("ssssss", $username, $password_hashed, $email, $fname, $lname, $permission);

            if ($stmt->execute()) {
                header("Location: ../pages/admin/user_control.php#user-added");
            } else {
                header("Location: ../pages/admin/user_control.php#user-add-failed");
            }
            $stmt->close();
        } else {
            header("Location: ../pages/admin/user_control.php#error");
        }
    }
    $check_username->close();
    $conn->close();
} else {
    header("Location: ../index.php");
}